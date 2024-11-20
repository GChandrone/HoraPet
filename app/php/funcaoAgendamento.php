<?php
//Função para preencher os agendamentos
function carregaAgenda($idTipoUsuario,$idUsuario){

    if($idTipoUsuario == 2){
        //Parceiro 30 min
        $minuto = 30;
    }else{
        //Atendimento 15 min
        $minuto = 15;
    }    

    include('banco.php');
    $sql = "SELECT nomecliente, idCliente, DataAgendamento, HoraAgendamento ......."
            ." ORDER BY DataAgendamento DESC, HoraAgendamento ASC;";    

    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);    

    $agenda = "";

    if (mysqli_num_rows($result) > 0) {

        $agenda = "events: [";

        foreach ($result as $campo) {
            //Agendamentos
            $id     = $campo['idCliente'];
            $nome   = $NomeCliente;
            $inicio = $campo['DataAgendamento']." ".$campo['HoraAgendamento'];
            $fim    = $campo['DataAgendamento']." ".date('H:i:s',strtotime($campo['HoraAgendamento']." + ".$minuto." minutes"));
            $classe = "success";

            $agenda .= 
            "{"
                ."title: '".$nome."',"
                ."start: '".$inicio."',"
                ."end: '".$fim."',"
                ."allDay: false,"
                ."url: 'URL DA TELA DE ATENDIMENTO',"
                ."className: '".$classe."'"
            ."},";
        }        
        $agenda .= "],";    
    }
    return $agenda;
}

// //Função para buscar a descrição do tipo de usuário
// function descrTipoPet($id){

//     if ($id == 1) {
//         $descricao = "Cachorro";
//     }else{
//         $descricao = "Gato";
//     }    

//     return $descricao;
// }

//Função para montar o select/option
function optionSituacao($p){

    if ($p == "I") {
        $option = '';
    }else{
        if ($p == 1) {
            $option = '<option value=2>Em Atendimento</option>'
                     .'<option value=3>Atendido</option>'
                     .'<option value=4>Cancelado</option>';
        }elseif ($p == 2){
            $option = '<option value=1>Agendado</option>'
                     .'<option value=3>Atendido</option>'
                     .'<option value=4>Cancelado</option>';
        }elseif ($p == 3){
            $option = '<option value=1>Agendado</option>'
                     .'<option value=2>Em Atendimento</option>'
                     .'<option value=4>Cancelado</option>';
        }elseif ($p == 4){
            $option = '<option value=1>Agendado</option>'
                     .'<option value=2>Em Atendimento</option>'
                     .'<option value=3>Atendido</option>';
        }
        
    }
    
    return $option;
}

?>