<?php

    include('funcoes.php');

    $nome        = $_POST["nNome"];
    $tipoPet     = $_POST["nTipoPet"];
    $funcao      = $_GET["funcao"];
    $idRaca      = $_GET["codigo"];

    // if($_POST["nAtivo"] == "on") $ativo = "S"; else $ativo = "N";

    include("conexao.php");

    //Validar se é Inclusão ou Alteração
    if($funcao == "I"){

        //Busca o próximo ID na tabela
        $idRaca = proxIdRaca();

        //INSERT
        $sql = "INSERT INTO raca (nome,tipo_pet) "
             ." VALUES ("."'$nome',$tipoPet);";   

    }elseif($funcao == "A"){
        //UPDATE
        if($senha == ''){ 
            $setSenha = ''; 
        }else{ 
            $setSenha = " Senha = md5('".$senha."'), ";
        }

        $sql = "UPDATE usuarios "
                ." SET idTipoUsuario = $tipoUsuario, "
                    ." Nome = '$nome', "
                    ." Login = '$login', "
                    .$setSenha 
                    ." FlgAtivo = '$ativo' "
                ." WHERE idUsuario = $idUsuario;";

    }elseif($funcao == "D"){
        //DELETE
        $sql = "DELETE FROM usuarios "
                ." WHERE idUsuario = $idUsuario;";
    }

    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);


    //VERIFICA SE TEM IMAGEM NO INPUT
    if($_FILES['nFoto']['tmp_name'] != ""){

        //Usar o mesmo nome do arquivo original
        //$nomeArq = $_FILES['Foto']['name'];
        //...
        //OU
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
        $sql = "UPDATE raca "
                ." SET foto = '$dirImagem' "
                ." WHERE id_raca = $idRaca;";

        $result = mysqli_query($conn,$sql);
        mysqli_close($conn);
    }

    header("location: ../racas.php");

?>