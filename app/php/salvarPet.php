<?php

    include('funcoes.php');

    
    $nome          = $_POST["nNome"    ];
    $dono          = $_POST["nDono"    ];
    $tipoPet       = $_POST["nTipoPet" ];
    $raca          = $_POST["nRacaAjax"];
    $altura        = $_POST["nAltura"  ];
    $peso          = $_POST["nPeso"    ];
    $porte         = $_POST["nPorte"   ];
    $funcao        = $_GET ["funcao"   ];
    $idPet         = $_GET ["codigo"   ];

    if($_POST["nAtivoPet"] == "on") $ativo = "1"; else $ativo = "0";

    include("conexao.php");

    //Busca o número que representa a descrição do porte
    $porte = idPorte($porte);

    //Validar se é Inclusão ou Alteração
    if($funcao == "I"){

        //Busca o próximo ID na tabela
        $idPet = proxIdPet();

        //INSERT
        $sql = "INSERT INTO pet (nome,id_cliente,tipo_pet,id_raca,altura,peso,porte,ativo) "
        ." VALUES ('$nome',$dono,$tipoPet,$raca,$altura,$peso,$porte,$ativo);"; 
    
    }elseif($funcao == "A"){

        $sql = "UPDATE pet "
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

    header("location: ../agendamento.php");

?>