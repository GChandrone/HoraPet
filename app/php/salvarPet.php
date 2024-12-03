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

    if (!$conn) {
        die("Falha na conexão: " . mysqli_connect_error());
    }
    
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Habilitar modo de exceção
    
    session_start(); // Certifique-se de que a sessão foi iniciada

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

        // Tentativa de execução do DELETE
        try {
            $result = mysqli_query($conn, $sql);
        } catch (mysqli_sql_exception $e) {
            // Tratamento para erro de chave estrangeira
            if ($e->getCode() == 1451) {
                $errorMessage = "Este pet não pode ser excluído porque já está associado a um agendamento.";
            } else {
                $errorMessage = "Erro inesperado: " . $e->getMessage();
            }

            // Fecha a conexão e armazena a mensagem de erro na sessão
            mysqli_close($conn);
            $_SESSION['erro_mensagem'] = $errorMessage;

            // Redireciona para a página de raças
            header("location: ../pets.php");
            exit; // Interrompe a execução do script
        }        
    }

    $result = mysqli_query($conn,$sql);

    if (!$result) {
        die('Erro na execução do SQL: ' . mysqli_error($conn)); // Verifique erros na execução da query
    }

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

    header("location: ../pets.php");

?>