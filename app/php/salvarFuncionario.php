<?php

    include('funcoes.php');

    $nome           = $_POST["nNome"    ];
    $email          = $_POST["nEmail"   ];
    $senha          = $_POST["nSenha"   ];
    $telefone       = $_POST["nTelefone"];
    $dataNascimento = $_POST["nData"    ];
    $funcao         = $_GET ["funcao"   ];
    $idFuncionario  = $_GET ["codigo"   ];


    if($_POST["nAtivoFuncionario"] == "on") $ativo = "1"; else $ativo = "0";

    include("conexao.php");

    //Validar se é Inclusão ou Alteração
    if($funcao == "I"){

        //INSERT
        $sql = "INSERT INTO funcionario (nome,data_nascimento,telefone,email,ativo) "
        ." VALUES ('$nome','$dataNascimento','$telefone','$email','$ativo');"; 
    
    
    }elseif($funcao == "A"){
        //UPDATE
        // if($senha == ''){ 
        //     $setSenha = ''; 
        // }else{ 
        //     $setSenha = " Senha = md5('".$senha."'), ";
        // }

        $sql = "UPDATE funcionario "
                ." SET nome            = '$nome', "
                    ." data_nascimento = '$dataNascimento', "
                    ." telefone        = '$telefone', "
                    ." email           = '$email', " 
                    ." ativo           =  $ativo "
                ." WHERE id_funcionario = $idFuncionario;";

    }elseif($funcao == "D"){
        //DELETE
        $sql = "DELETE FROM funcionario WHERE id_funcionario = $idFuncionario;";
    }

    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);


    header("location: ../funcionarios.php");

?>