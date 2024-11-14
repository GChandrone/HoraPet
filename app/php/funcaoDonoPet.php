<?php

//Função para buscar o nome do dono do pet
function descrDonoPet($id){

    $nome = "";

    include("conexao.php");
    $sql = "SELECT nome FROM cliente WHERE id_cliente = $id;";        
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
            $nome = $coluna["nome"];
        }        
    } 

    return $nome;
}

//Função para montar o select/option
function optionDonoPet(){

    $option = "";

    include("conexao.php");
    $sql = "SELECT id_cliente, nome, telefone FROM cliente ORDER BY nome;";        
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
            $option .= '<option value="'.$coluna['id_cliente'].'">'.$coluna['nome'].' - '.$coluna['telefone'].'</option>';
        }        
    } 

    return $option;
}

?>