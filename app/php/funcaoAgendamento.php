<?php

//Função para listar todos os usuários
function listaAgendamento($idFuncionario, $tipoUsuario){

    include("conexao.php");
    $sql = " SELECT "
        ."agendamento.id_agendamento, "
        ."pet.porte, "
        ."pet.foto                      AS foto_pet, "
        ."pet.nome                      AS nome_pet, "
        ."cliente.nome                  AS nome_dono, "
        ."funcionario.nome              AS nome_funcionario, "
        ."agendamento.data, "
        ."agendamento.horario_inicial, "
        ."SUM(execucao.valor)           AS valor_total, "
        ."agendamento.situacao "
    ."FROM agendamento "
    ."INNER JOIN pet "
       ."ON pet.id_pet = agendamento.id_pet "
    ."INNER JOIN cliente "
        ."ON cliente.id_cliente = agendamento.id_cliente "
    ."INNER JOIN funcionario "
        ."ON funcionario.id_funcionario = agendamento.id_funcionario "
    ."LEFT JOIN execucao "
        ."ON execucao.id_agendamento = agendamento.id_agendamento ";

    if ($tipoUsuario = "Esteticista Pet") {
        $sql .= "WHERE agendamento.id_funcionario = ".$idFuncionario." ";
    }    

    $sql.="GROUP BY "
        ."agendamento.id_agendamento, "
        ."pet.foto, "
        ."pet.nome, "
        ."cliente.nome, "
        ."funcionario.nome, "
        ."agendamento.data, "
        ."agendamento.horario_inicial, "
        ."agendamento.situacao "
    ."ORDER BY agendamento.id_agendamento DESC;";
            
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    $lista = '';
    $ativo = '';
    $icone = '';

    // Adicionando o estilo CSS para centralizar verticalmente
   

    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {
        
        
        foreach ($result as $coluna) {

            // Verifica se há foto
            if (!empty($coluna["foto_pet"])) {
                $fotoPet = $coluna["foto_pet"];
            } else {;
                $fotoPet = 'dist/img/default-pet.png';
            }    

            //***Verificar os dados da consulta SQL
            $lista .= 
            '<tr>'
                .'<td align="center">'
                    .'<a href="#modalFotoPet'.$coluna["id_agendamento"].'" data-toggle="modal">'
                        .'<img src="'.$fotoPet.'" alt="Foto do Pet" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">'
                    .'</a>'
                .'</td>'
                .'<td>'.$coluna["nome_pet"].'</td>'
                .'<td>'.$coluna["nome_dono"].'</td>'
                .'<td>'.$coluna["nome_funcionario"].'</td>'
                .'<td>'.formatarData($coluna["data"]).'</td>'
                .'<td>'.formatarHora($coluna["horario_inicial"]).'</td>'
                .'<td>'.formatarMoeda($coluna["valor_total"]).'</td>'
                .'<td>'.descrSituacaoAgendamento($coluna["situacao"]).'</td>'
                .'<td>'
                    .'<div class="row" align="center">'
                        .'<div class="col-6">'
                            .'<a href="agendamento.php?id='.encodeId($coluna["id_agendamento"]).'&add=true">'
                                .'<h6><i class="fas fa-edit text-info" data-toggle="tooltip" title="Alterar agendamento"></i></h6>'
                            .'</a>'
                        .'</div>'

                        .'<div class="col-6">'
                            .'<a href="#modalDeleteAgendamento'.$coluna["id_agendamento"].'" data-toggle="modal">'
                                .'<h6><i class="fas fa-trash text-danger" data-toggle="tooltip" title="Excluir agendamento"></i></h6>'
                            .'</a>'
                        .'</div>'
                    .'</div>'
                .'</td>'
            .'</tr>'
            
            .'<div class="modal fade" id="modalDeleteAgendamento'.$coluna["id_agendamento"].'">'
                .'<div class="modal-dialog">'
                    .'<div class="modal-content">'
                        .'<div class="modal-header bg-danger">'
                            .'<h4 class="modal-title">Deseja excluir agendamento do pet: '.$coluna["nome_pet"].'</h4>'
                            .'<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">'
                                .'<span aria-hidden="true">&times;</span>'
                            .'</button>'
                        .'</div>'
                        .'<div class="modal-body">'

                            .'<form method="POST" action="php/salvarAgendamento.php?funcao=D&codigo='.$coluna["id_agendamento"].'" enctype="multipart/form-data">'              

                                .'<div class="row">'
                                    .'<div class="col-12">'
                                        .'<h5>Tem certeza de que deseja excluir este agendamento?</h5>'
                                    .'</div>'
                                .'</div>'
                                
                                .'<div class="modal-footer">'
                                    .'<button type="button" class="btn btn-danger" data-dismiss="modal">Não</button>'
                                    .'<button type="submit" class="btn btn-success">Sim</button>'
                                .'</div>'
                                
                            .'</form>'
                            
                        .'</div>'
                    .'</div>'
                .'</div>'
            .'</div>'  
            
            .'<div class="modal fade" id="modalFotoPet'.$coluna["id_agendamento"].'">'
                .'<div class="modal-dialog modal-dialog-centered">'
                    .'<div class="modal-content">'
                        .'<div class="modal-header bg-success">'
                            .'<h4 class="modal-title">'.$coluna["nome_pet"].'</h4>'
                            .'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'
                                .'<span aria-hidden="true">&times;</span>'
                            .'</button>'
                        .'</div>'
                        .'<div class="modal-body text-center">'
                            .'<img src="'.$fotoPet.'" alt="Foto do Pet" class="img-fluid rounded" style="max-width: 100%; height: auto;">'
                        .'</div>'
                    .'</div>'
                .'</div>'
            .'</div>';
        }    
    }
    
    return $lista;
}

//Função para preencher os agendamentos
function carregaAgenda($idFuncionario, $tipoUsuario){

    include('conexao.php');
    $sql = "SELECT "
           ."  pet.nome as nome_pet, "
           ."  agendamento.id_agendamento, "
           ."  agendamento.data, "
           ."  agendamento.horario_inicial, "
           ."  agendamento.horario_final "
           ."FROM agendamento "
           ."INNER JOIN pet "
           ."   ON pet.id_pet = agendamento.id_pet ";
           
    if ($tipoUsuario = "Esteticista Pet") {
        $sql .= "WHERE agendamento.id_funcionario = ".$idFuncionario." ";
    }

    $sql .= "ORDER BY "
                ."data DESC, " 
                ."horario_inicial ASC;"; 

    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);    

    $agenda = "";

    if (mysqli_num_rows($result) > 0) {

        $agenda = "events: [";

        foreach ($result as $campo) {
            //Agendamentos
            $id      = $campo['id_agendamento'];
            $nome    = $campo['nome_pet'];
            $inicio  = $campo['data']." ".$campo['horario_inicial'];
            $fim     = $campo['data']." ".$campo['horario_final'];
            $classe  = "success";

            $agenda .= 
            "{"
                ."title: '".$nome."',"
                ."start: '".$inicio."',"
                ."end: '".$fim."',"
                ."allDay: false,"
                ."url: 'agendamento.php?id=".encodeId($id)."&add=true',"
                ."className: '".$classe."'"
            ."},";
        }        
        $agenda .= "],";    

    }
    return $agenda;
}

//Função para montar o select/option
function optionSituacaoAgendamento($p){

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

function idAgendamentoServico($cliente,$pet,$data){

    $camposConcatenados = $cliente.$pet.$data;

    $keyAgendamento = md5($camposConcatenados);
    
    include("conexao.php");

    $sql = "SELECT " 
              ."MAX(id_agendamento) as id_agendamento "
          ."FROM agendamento "
          ."WHERE MD5(CONCAT(id_cliente,id_pet,data)) = '".$keyAgendamento."'; ";

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
            $id = $coluna["id_agendamento"];
        }        
    } 

    return $id;
}

//Função para buscar a descrição da situação do agendamento
function descrSituacaoAgendamento($id){

    if ($id == 1) {
        $descricao = "Agendado";
    }else if($id == 2){
        $descricao = "Em Atendimento";
    }else if($id == 3){
        $descricao = "Atendido";
    }else if($id == 4){
        $descricao = "Cancelado";
    }         

    return $descricao;
}

function atualizaDuracaoAgendamento($idAgendamento) {
    
    $horaInicial = horaInicioAgendamento($idAgendamento);
    $duracao = duracaoAgendamento($idAgendamento);

    // Se a duração for inválida ou vazia, use um valor padrão
    if (empty($duracao)) {
        $duracao = '00:00:00';
    }

    // Cria um objeto DateTime para a hora inicial
    $dateTime = new DateTime($horaInicial);

    // Adiciona a duração como um intervalo
    $dateTime->add(new DateInterval('PT' . explode(':', $duracao)[0] . 'H' . explode(':', $duracao)[1] . 'M' . explode(':', $duracao)[2] . 'S'));

    // Exibe o horário final
    $horaFim = $dateTime->format('H:i:s');
    
    include("conexao.php");

    $sql = "UPDATE agendamento SET horario_final = '$horaFim' WHERE id_agendamento = $idAgendamento;";
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
}

function horaInicioAgendamento($idAgendamento){

    $horaInicio = "";

    include("conexao.php");

    $sql = "SELECT horario_inicial FROM agendamento WHERE id_agendamento = ".$idAgendamento.";";

    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);    

    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {

        foreach ($result as $coluna) {
            $horaInicio = $coluna["horario_inicial"];
        }

    }

    return $horaInicio;

}

function duracaoAgendamento($idAgendamento){
    
    $horaDuracao = "";

    include("conexao.php");

    $sql = "SELECT time_format( SEC_TO_TIME( SUM( TIME_TO_SEC( duracao ) ) ),'%H:%i:%s') AS duracao FROM execucao WHERE id_agendamento = ".$idAgendamento.";";

    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);       

    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {

        foreach ($result as $coluna) {
            $horaDuracao = $coluna["duracao"];
        }

    }

    return $horaDuracao;

}

?>