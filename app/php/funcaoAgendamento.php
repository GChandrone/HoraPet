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
?>