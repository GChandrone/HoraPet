<?php

    include('funcoes.php');

    
    $cliente       = $_POST["nCliente"       ];
    $pet           = $_POST["nPet"           ];
    $funcionario   = $_POST["nFuncionario"   ];
    $data          = $_POST["nData"          ];
    $horainicio    = $_POST["nHorarioInicio" ];
    $situacao      = $_POST["nSituacao"      ];
    $funcao        = $_GET ["funcao"         ];
    $idPet         = $_GET ["codigo"         ];

    include("conexao.php");

    //Validar se é Inclusão ou Alteração
    if($funcao == "I"){

        //INSERT
        $sql = "INSERT INTO agendamento (horario_inicial,horario_final,data,situacao,id_pet,id_cliente) "
        ." VALUES ('$horainicio','00:00:00',$data,$situacao,$pet,$cliente);";  

    }elseif($funcao == "A"){

        $sql = "UPDATE agendamento "
                ." SET nome       = '$nome', "
                    ." id_cliente =  $dono, "
                    ." tipo_pet   =  $tipoPet, "
                    ." id_raca    =  $raca, "
                    ." altura     =  $altura, "
                    ." peso       =  $peso, "
                    ." porte      =  $porte, "
                    ." ativo      =  $ativo "
                ." WHERE id_pet   =  $idPet;";

    }elseif($funcao == "D"){
        //DELETE
        $sql = "DELETE FROM pet "
                ." WHERE id_pet = $idPet;";
    }

    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    //VERIFICA SE TEM IMAGEM NO INPUT
    if($_FILES['nFoto']['tmp_name'] != ""){

        //Pega a extensão do arquivo e cria um novo nome pra ele (MD5 do nome original)
        $extensao = pathinfo($_FILES['nFoto']['name'], PATHINFO_EXTENSION);
        $novoNome = md5($_FILES['nFoto']['name']).'.'.$extensao;        
        
        //Verificar se o diretório existe, ou criar a pasta
        if(is_dir('../dist/img/')){
            //Existe
            $diretorio = '../dist/img/';
        }else{
            //Criar pq não existe
            $diretorio = mkdir('../dist/img/');
        }

        //Cria uma cópia do arquivo local na pasta do projeto
        move_uploaded_file($_FILES['nFoto']['tmp_name'], $diretorio.$novoNome);

        //Caminho que será salvo no banco de dados
        $dirImagem = 'dist/img/'.$novoNome;

        include("conexao.php");
        //UPDATE
        $sql = "UPDATE pet "
                ." SET foto = '$dirImagem' "
                ." WHERE id_pet = $idPet;";

        $result = mysqli_query($conn,$sql);
        mysqli_close($conn);
    }

    header("location: ../agendamento.php?id=" . $idAgendamento);
  
?>