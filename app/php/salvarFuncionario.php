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
        
        $sql = "INSERT INTO funcionario (id_funcionario,nome,email,senha,data,ativo) "
        ." VALUES ("."'$idFuncionario',$nome'$email','$md5('$senha')'$idFuncionario','$ativo' );"; 
    
    
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
        $sql = "DELETE FROM usuarios "
                ." WHERE idFuncionario = $idFuncionario;";
    }

    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);


    //VERIFICA SE TEM IMAGEM NO INPUT
    if($_FILES['Foto']['tmp_name'] != ""){

        //Usar o mesmo nome do arquivo original
        //$nomeArq = $_FILES['Foto']['name'];
        //...
        //OU
        //Pega a extensão do arquivo e cria um novo nome pra ele (MD5 do nome original)
        $extensao = pathinfo($_FILES['Foto']['name'], PATHINFO_EXTENSION);
        $novoNome = md5($_FILES['Foto']['name']).'.'.$extensao;        
        
        //Verificar se o diretório existe, ou criar a pasta
        if(is_dir('../dist/img/')){
            //Existe
            $diretorio = '../dist/img/';
        }else{
            //Criar pq não existe
            $diretorio = mkdir('../dist/img/');
        }

        //Cria uma cópia do arquivo local na pasta do projeto
        move_uploaded_file($_FILES['Foto']['tmp_name'], $diretorio.$novoNome);

        //Caminho que será salvo no banco de dados
        $dirImagem = 'dist/img/'.$novoNome;

        include("conexao.php");
        //UPDATE
        $sql = "UPDATE usuarios "
                ." SET Foto = '$dirImagem' "
                ." WHERE idFuncionario = $idFuncionario;";
        $result = mysqli_query($conn,$sql);
        mysqli_close($conn);
    }

    header("location: ../funcionarios.php");

?>