<?php

    include('funcoes.php');

    
    $nome           = $_POST["nNome"    ];
    $email          = $_POST["nEmail"   ];
    $senha          = $_POST["nSenha"   ];
    $telefone       = $_POST["nTelefone"];
    $dataNascimento = $_POST["ndata"    ];
    $funcao         = $_GET ["funcao"   ];
    $idFuncionario  = $_GET ["codigo"   ];


    if($_POST["nAtivo"] == "on") $ativo = "1"; else $ativo = "0";

    include("conexao.php");

    //Validar se é Inclusão ou Alteração
    if($funcao == "I"){

        //INSERT
        
        $sql = "INSERT INTO funcionario (id_funcionario,nome,email,senha,data) "
        ." VALUES ("."'$idFuncionario',$nome'$email','$md5('$senha')'$idFuncionario' );"; 
    
    
    }elseif($funcao == "A"){
        //UPDATE
        if($senha == ''){ 
            $setSenha = ''; 
        }else{ 
            $setSenha = " Senha = md5('".$senha."'), ";
        }

        $sql = "UPDATE funcionario "
                ." SET idFuncionario = $idFuncionario, "
                    ." nome = '$nome', "
                    ." email = '$email', "
                    .$setSenha 
                    ." ativo = '$ativo' "
                ." WHERE idFuncionario = $idFuncionario;";

    }elseif($funcao == "D"){
        //DELETE
        $sql = "DELETE FROM funcionario "
                ." WHERE idFuncionario = $idFuncionario;";
    }

    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);


    header("location: ../funcionarios.php");

?>