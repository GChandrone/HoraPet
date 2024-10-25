<?php

//Função para buscar a descrição do tipo de usuário
function descrTipoPet($id){

    if ($id = 1) {
        $descricao = "Cachorro";
    }else{
        $descricao = "Gato";
    }    

    return $descricao;
}

//Função para montar o select/option
function optionTipoPet(){

    $option = '<option value=1>Cachorro</option>'
             .'<option value=2>Gato</option>';
   
    return $option;
}

?>