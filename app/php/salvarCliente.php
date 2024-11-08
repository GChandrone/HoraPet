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
    }

    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);


    header("location: ../clientes.php");

?>