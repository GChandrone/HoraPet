<?php

// Função para buscar a descrição do tipo de usuário
function descrTipoFuncionario($id){
    if ($id == 1) {
        return "Administrador";
    } elseif ($id == 2) {
        return "Atendente";
    } else {
        return "Esteticista Pet";
    }
}

// Função para montar o select/option
function optionTipoFuncionario($p){
    if ($p == "I") {
        return '<option value=1>Administrador</option>'
             .'<option value=2>Atendente</option>'
             .'<option value=3>Esteticista Pet</option>';
    } else {
        $option = ''; // Inicializa a variável $option para evitar erro de variável não definida

        if ($p == 1) {
            $option .= '<option value=2>Atendente</option>';
            $option .= '<option value=3>Esteticista Pet</option>';
        } elseif ($p == 2) {
            $option .= '<option value=1>Administrador</option>';
            $option .= '<option value=3>Esteticista Pet</option>';
        } elseif ($p == 3) {
            $option .= '<option value=1>Administrador</option>';
            $option .= '<option value=2>Atendente</option>';
        }

        return $option;
    }
}

?>
