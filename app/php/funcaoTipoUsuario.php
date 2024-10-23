<?php

//Função para buscar a descrição do tipo de usuário
function descrTipoUsuario($id){

    $descricao = "";

    include("conexao.php");
    $sql = "SELECT Descricao FROM tipousuario WHERE idTipoUsuario = $id;";        
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {
                
        $array = array();
        
        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($array,$linha);
        }
        
        foreach ($array as $coluna) {            
            //***Verificar os dados da consulta SQL
            $descricao = $coluna["Descricao"];
        }        
    } 

    return $descricao;
}

//Função para montar o select/option
function optionTipoUsuario(){

    $option = "";

    include("conexao.php");
    $sql = "SELECT idTipoUsuario, Descricao FROM tipousuario ORDER BY Descricao;";        
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {
                
        $array = array();
        
        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($array,$linha);
        }
        
        foreach ($array as $coluna) {            
            //***Verificar os dados da consulta SQL            
            $option .= '<option value="'.$coluna['idTipoUsuario'].'">'.$coluna['Descricao'].'</option>';
        }        
    } 

    return $option;
}

?>