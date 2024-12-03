<?php

    include('funcoes.php');
    
    $nome           = $_POST["nNome"       ];
    $telefone       = $_POST["nTelefone"   ];
    $email          = $_POST["nEmail"      ];
    $senha          = $_POST["nSenha"      ];
    $cep            = $_POST["nCEP"        ];
    $estado         = $_POST["nUF"         ];
    $cidade         = $_POST["nCidade"     ];
    $bairro         = $_POST["nBairro"     ];
    $endereco       = $_POST["nEndereco"   ];
    $numero         = $_POST["nNumero"     ];
    $complemento    = $_POST["nComplemento"];
    $funcao         = $_GET ["funcao"      ];
    $idCliente      = $_GET ["codigo"      ];


    if($_POST["nAtivoCliente"] == "on") $ativo = "1"; else $ativo = "0";

    include("conexao.php");

    if (!$conn) {
        die("Falha na conexão: " . mysqli_connect_error());
    }
    
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Habilitar modo de exceção
    
    session_start(); // Certifique-se de que a sessão foi iniciada

    //Validar se é Inclusão ou Alteração
    if($funcao == "I"){

        //INSERT
        $sql = "INSERT INTO cliente (nome,telefone,email,cep,estado,cidade,bairro,endereco,numero,complemento,ativo) "
        ." VALUES ('$nome','$telefone','$email','$cep','$estado','$cidade','$bairro','$endereco',$numero,'$complemento',$ativo);"; 
    
    }elseif($funcao == "A"){
        //UPDATE
        // if($senha == ''){ 
        //     $setSenha = ''; 
        // }else{ 
        //     $setSenha = " Senha = md5('".$senha."'), ";
        // }

        $sql = "UPDATE cliente "
                ." SET nome        = '$nome', "
                    ." telefone    = '$telefone', "
                    ." email       = '$email', "
                    ." cep         = '$cep', "
                    ." estado      = '$estado', "
                    ." cidade      = '$cidade', "
                    ." bairro      = '$bairro', "
                    ." endereco    = '$endereco', "
                    ." numero      =  $numero, "
                    ." complemento = '$complemento', "
                    ." ativo       =  $ativo "
                ." WHERE id_cliente = $idCliente;";

    }elseif($funcao == "D"){
        //DELETE
        $sql = "DELETE FROM cliente "
                ." WHERE id_cliente = $idCliente;";

        // Tentativa de execução do DELETE
        try {
            $result = mysqli_query($conn, $sql);
        } catch (mysqli_sql_exception $e) {
            // Tratamento para erro de chave estrangeira
            if ($e->getCode() == 1451) {
                $errorMessage = "Este cliente não pode ser excluído porque já está associado a um pet.";
            } else {
                $errorMessage = "Erro inesperado: " . $e->getMessage();
            }

            // Fecha a conexão e armazena a mensagem de erro na sessão
            mysqli_close($conn);
            $_SESSION['erro_mensagem'] = $errorMessage;

            // Redireciona para a página de raças
            header("location: ../clientes.php");
            exit; // Interrompe a execução do script
        }
    }

    $result = mysqli_query($conn,$sql);

    if (!$result) {
        die('Erro na execução do SQL: ' . mysqli_error($conn)); // Verifique erros na execução da query
    }

    mysqli_close($conn);


    header("location: ../clientes.php");

?>