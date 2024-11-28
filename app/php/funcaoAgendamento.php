<?php

//Função para listar todos os usuários
function listaAgendamento(){

    include("conexao.php");
    $sql = "SELECT "
               ."pet.id_pet, "
               ."pet.foto, "
               ."pet.nome             as nome_pet, "
               ."pet.tipo_pet, "
               ."raca.nome            as nome_raca, "
               ."raca.id_raca,"
               ."pet.porte, "
               ."cliente.id_cliente, "
               ."cliente.telefone     as telefone_cliente, "
               ."cliente.nome         as nome_cliente, "
               ."pet.ativo, "
               ."pet.altura, "
               ."pet.peso "  
          ."FROM pet "
          ."INNER JOIN raca "
          ."   ON raca.id_raca = pet.id_raca "
          ."INNER JOIN cliente "
          ."   ON cliente.id_cliente = pet.id_cliente "
          ."ORDER BY id_pet; ";
            
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    $lista = '';
    $ativo = '';
    $icone = '';

    // Adicionando o estilo CSS para centralizar verticalmente
   

    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {
        
        
        foreach ($result as $coluna) {

            //***Verificar os dados da consulta SQL
            $lista .= 
            '<tr>'
                .'<td>'.$coluna["id_pet"].'</td>'
                .'<td align="center">'
                    .'<a href="#modalFotoPet'.$coluna["id_pet"].'" data-toggle="modal">'
                        .'<img src="'.$fotoPet.'" alt="Foto do Pet" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">'
                    .'</a>'
                .'</td>'
                .'<td>'.$coluna["nome_pet"].'</td>'
                .'<td>'.descrTipoPet($coluna["tipo_pet"]).'</td>'
                .'<td>'.$coluna["nome_raca"].'</td>'
                .'<td>'.descrPorte($coluna["porte"]).'</td>'
                .'<td>'.$coluna["nome_cliente"].'</td>'
                .'<td align="center">'.$icone.'</td>'
                .'<td>'
                    .'<div class="row" align="center">'
                        .'<div class="col-6">'
                            .'<a href="#modalEditPet'.$coluna["id_pet"].'" data-toggle="modal">'
                                .'<h6><i class="fas fa-edit text-info" data-toggle="tooltip" title="Alterar pet"></i></h6>'
                            .'</a>'
                        .'</div>'

                        .'<div class="col-6">'
                            .'<a href="#modalDeletePet'.$coluna["id_pet"].'" data-toggle="modal">'
                                .'<h6><i class="fas fa-trash text-danger" data-toggle="tooltip" title="Alterar pet"></i></h6>'
                            .'</a>'
                        .'</div>'
                    .'</div>'
                .'</td>'
            .'</tr>'
            
            .'<div class="modal fade" id="modalEditPet'.$coluna["id_pet"].'">'
                .'<div class="modal-dialog modal-lg">'
                    .'<div class="modal-content">'
                        .'<div class="modal-header bg-info">'
                            .'<h4 class="modal-title">Alterar Pet</h4>'
                            .'<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">'
                                .'<span aria-hidden="true">&times;</span>'
                            .'</button>'
                        .'</div>'
                        .'<div class="modal-body">'

                            .'<form method="POST" action="php/salvarPet.php?funcao=A&codigo='.$coluna["id_pet"].'" enctype="multipart/form-data">'              
                
                                .'<div class="row">'
                                    .'<div class="col-6">'
                                        .'<div class="form-group">'
                                            .'<label for="iNome">Nome:</label>'
                                            .'<input type="text" value="'.$coluna["nome_pet"].'" class="form-control" id="iNome" name="nNome" maxlength="50" required>'
                                        .'</div>'
                                    .'</div>'
            
                                    .'<div class="col-6">'
                                        .'<div class="form-group">'
                                            .'<label for="iDono">Dono - Telefone:</label>'
                                            .'<select id="iDono" name="nDono" class="form-control" required>'
                                                .'<option value="'.$coluna["id_cliente"].'">'.$coluna["nome_cliente"].' - '.$coluna["telefone_cliente"].'</option>'
                                                .optionDonoPet()
                                            .'</select>'
                                        .'</div>'
                                    .'</div>'
            
                                    .'<div class="col-6">'
                                        .'<div class="form-group">'
                                            .'<label>Tipo do Pet:</label>'
                                            .'<select id="iTipoPetAjax" name="nTipoPet" class="form-control tipoPetAjax" required>'
                                                .'<option value="'.$coluna["tipo_pet"].'">'.descrTipoPet($coluna["tipo_pet"]).'</option>'
                                                .optionTipoPet($coluna["tipo_pet"])
                                            .'</select>'
                                        .'</div>'
                                    .'</div>'
            
                                    .'<div class="col-6">'
                                        .'<div class="form-group">'
                                            .'<label for="iRacaAjax">Raça:</label>'
                                            .'<select name="nRacaAjax" id="iRacaAjax" class="form-control racaAjax" required>'
                                                .'<option value="'.$coluna["id_raca"].'">'.descrRaca($coluna["id_raca"]).'</option>'
                                            .'</select>'
                                        .'</div>'
                                    .'</div>'
            
                                     .'<div class="col-3">'
                                         .'<div class="form-group">'
                                             .'<label for="iAlturaAlterar">Altura (cm):</label>'
                                             .'<input type="number" value="'.$coluna["altura"].'" class="form-control" id="iAlturaAlterar" name="nAltura" required>'
                                         .'</div>'
                                     .'</div>'
            
                                     .'<div class="col-3">'
                                         .'<div class="form-group">'
                                             .'<label for="iPesoAlterar">Peso (kg):</label>'
                                             .'<input type="number" value="'.$coluna["peso"].'" class="form-control" id="iPesoAlterar" name="nPeso" required>'
                                         .'</div>'
                                     .'</div>'
            
                                     .'<div class="col-6">'
                                         .'<div class="form-group">'
                                             .'<label for="iPorteAlterar">Porte:</label>'
                                             .'<input type="text" value="'.descrPorte($coluna["porte"]).'" class="form-control" id="iPorteAlterar" name="nPorte" readonly required>'
                                         .'</div>'
                                     .'</div>'
            
                                    .'<div class="col-12">'
                                        .'<div class="form-group">'
                                            .'<label for="iFoto">Foto:</label>'
                                            .'<div class="custom-file">'
                                                .'<input type="file" class="custom-file-input" id="iFoto" name="nFoto" accept="image/*">'
                                                .'<label class="custom-file-label" for="customFile">Nenhum arquivo escolhido</label>'
                                            .'</div>'
                                        .'</div>'
                                    .'</div>'
                            
                                .'</div>'
                            
                                .'<div class="custom-control custom-checkbox">'
                                    .'<input class="custom-control-input custom-control-input-info" type="checkbox" id="iAtivoPet'.$coluna["id_pet"].'" name="nAtivoPet" '.$ativo.'>'
                                    .'<label for="iAtivoPet'.$coluna["id_pet"].'" class="custom-control-label">Pet Ativo</label>'
                                .'</div>'

                                .'<div class="modal-footer">'
                                    .'<button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>'
                                    .'<button type="submit" class="btn btn-success">Salvar</button>'
                                .'</div>'
                                
                            .'</form>'
                            
                        .'</div>'
                    .'</div>'
                .'</div>'
            .'</div>'
            
            .'<div class="modal fade" id="modalDeletePet'.$coluna["id_pet"].'">'
                .'<div class="modal-dialog">'
                    .'<div class="modal-content">'
                        .'<div class="modal-header bg-danger">'
                            .'<h4 class="modal-title">Deseja excluir o pet: '.$coluna["nome_pet"].'</h4>'
                            .'<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">'
                                .'<span aria-hidden="true">&times;</span>'
                            .'</button>'
                        .'</div>'
                        .'<div class="modal-body">'

                            .'<form method="POST" action="php/salvarPet.php?funcao=D&codigo='.$coluna["id_pet"].'" enctype="multipart/form-data">'              

                                .'<div class="row">'
                                    .'<div class="col-12">'
                                        .'<h5>Tem certeza de que deseja excluir este pet?</h5>'
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
            
            .'<div class="modal fade" id="modalFotoPet'.$coluna["id_pet"].'">'
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

?>