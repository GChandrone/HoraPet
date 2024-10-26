<?php

//Função para buscar a descrição do tipo de usuário
function descrTipoPet($id){

    if ($id == 1) {
        $descricao = "Cachorro";
    }else{
        $descricao = "Gato";
    }    

    return $descricao;
}

//Função para montar o select/option
function optionTipoPet($p){

    if ($p == "I") {
        $option = '<option value=1>Cachorro</option>'
                 .'<option value=2>Gato</option>';
    }else{
        if ($p == 1) {
            $option = '<option value=2>Gato</option>';
        }elseif ($p == 2){
            $option = '<option value=1>Cachorro</option>';
        }
    }
    
    return $option;
}

?>