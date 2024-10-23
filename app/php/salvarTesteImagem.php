<?php

if($_FILES['nFoto']['tmp_name'] != ''){
        
    //Pega extensão e monta o novo nome do arquivo
    $extensao  = pathinfo($_FILES['nFoto']["name"], PATHINFO_EXTENSION);
    $novo_nome = md5($_FILES['nFoto']["name"]).'.'.$extensao;

    //Verifica se existe o diretório (ou cria)
    if(is_dir('../dist/img/teste/')){ 
        $diretorio = '../dist/img/teste/';
    }else{
        $diretorio = mkdir('../dist/img/teste/');
    }
  
    //Grava o arquivo no diretório
    move_uploaded_file($_FILES['nFoto']['tmp_name'], $diretorio.$novo_nome);

    //Salva o diretório para colocar na tabela do BD
    $diretorioImg = 'dist/img/teste/'.$novo_nome;

    //Gravação no BD
    include('conexao.php');
    $sql = "UPDATE usuarios "
            ." SET Foto = '".$diretorioImg."' "
            ." WHERE idUsuario = 4;";                                 
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

}

?>