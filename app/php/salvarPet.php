<?php

    include('funcoes.php');

    
    $nome           = $_POST["nNome"      ];
    $telefone       = $_POST["nDono"      ];
    $email          = $_POST["nTipoPet"   ];
    $senha          = $_POST["nRaca"      ];
    $cep            = $_POST["nAltura"    ];
    $estado         = $_POST["nPeso"      ];
    $cidade         = $_POST["nPorte"     ];


    if($_POST["nAtivoPet"] == "on") $ativo = "1"; else $ativo = "0";

    include("conexao.php");

    //Validar se é Inclusão ou Alteração
    if($funcao == "I"){

        //INSERT
        $sql = "INSERT INTO cliente (nome,telefone,email,cep,estado,cidade,bairro,endereco,numero,complemento,ativo) "
        ." VALUES ('$nome','$telefone','$email','$cep','$estado','$cidade','$bairro','$endereco',$numero,'$complemento',$ativo);"; 
    
    }elseif($funcao == "A"){

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
        $sql = "DELETE FROM pet "
                ." WHERE id_pet = $idCliente;";
    }

    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);


    header("location: ../pets.php");

?>