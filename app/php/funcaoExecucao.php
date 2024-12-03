<?php
//Função para listar todas as Raças
function listaExecucao($idAgendamento, $idPorte){
    include("conexao.php");

    $sql = "SELECT "
               ."execucao.id_execucao, "
               ."servico.id_servico, ";
               if ($idPorte == 1) {
                    $sql .=  " valor_pequeno as valor_execucao, ";
                }elseif($idPorte == 2){
                    $sql .=  " valor_medio   as valor_execucao, ";
                }else{
                    $sql .=  " valor_grande  as valor_execucao, ";
                }
         $sql .="servico.nome, "
               ."execucao.valor, "
               ."execucao.duracao, "
               ."execucao.situacao, "
               ."execucao.descricao "  
          ."FROM execucao "
          ."INNER JOIN servico "
          ."   ON servico.id_servico = execucao.id_servico "
          ."WHERE execucao.id_agendamento = $idAgendamento "
          ."ORDER BY id_execucao; ";
         
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    $lista = '';

    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {
     
     
        foreach ($result as $coluna) {
            
            //***Verificar os dados da consulta SQL
            $lista .= 
            '<tr>'
                .'<td>'.$coluna["nome"].'</td>'
                .'<td>'.formatarMoeda($coluna["valor"]).'</td>'
                .'<td>'.formatarHora($coluna["duracao"]).'</td>'
                .'<td>'.descrSituacaoExecucao($coluna["situacao"]).'</td>'
                .'<td>'
                    .'<div class="row" align="center">'
                        .'<div class="col-6">'
                            .'<a href="#modalEditExecucao'.$coluna["id_execucao"].'" data-toggle="modal">'
                                .'<h6><i class="fas fa-edit text-info" data-toggle="tooltip" title="Alterar Execução"></i></h6>'
                            .'</a>'
                        .'</div>'
                        .'<div class="col-6">'
                            .'<a href="#modalDeleteExecucao'.$coluna["id_execucao"].'" data-toggle="modal">'
                                .'<h6><i class="fas fa-trash text-danger" data-toggle="tooltip" title="Excluir Execução"></i></h6>'
                            .'</a>'
                        .'</div>'
                    .'</div>'
                .'</td>'
            .'</tr>'
         
            .'<div class="modal fade" id="modalEditExecucao'.$coluna["id_execucao"].'">'
                 .'<div class="modal-dialog modal-lg">'
                     .'<div class="modal-content">'
                         .'<div class="modal-header bg-info">'
                             .'<h4 class="modal-title">Alterar Serviço</h4>'
                             .'<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">'
                                 .'<span aria-hidden="true">&times;</span>'
                             .'</button>'
                         .'</div>'
                         .'<div class="modal-body">'
                    
                            .'<form method="POST" action="php/salvarExecucao.php?funcao=A&codigo='.$coluna["id_execucao"].'&idPorte='.$idPorte.'&idAgendamento='.$idAgendamento.'" enctype="multipart/form-data">'              
                                .'<div class="row">'
                                    .'<div class="col-8">'
                                        .'<div class="form-group">'
                                        .'<label for="iServico">Serviço:</label>'
                                        .'<select id="iServico" name="nServico" class="form-control" required>'
                                            .'<option value="'.$coluna["id_servico"].'">'.$coluna["nome"].' - '.formatarMoeda($coluna["valor_execucao"]).'</option>'
                                            .optionServico($idPorte)
                                        .'</select>'
                                        .'</div>'
                                    .'</div>'

                                    .'<div class="col-4">'
                                        .'<div class="form-group">'
                                        .'<label for="iSituacaoExecucao">Situação:</label>'
                                        .'<select id="iSituacaoExecucao" name="nSituacaoExecucao" class="form-control" required>'
                                            .'<option value="'.$coluna["situacao"].'">'.descrSituacaoExecucao($coluna["situacao"]).'</option>'
                                            .optionSituacaoExecucao($coluna["situacao"])
                                        .'</select>'
                                        .'</div>'
                                    .'</div>'
                                .'</div>'

                                .'<div class="row">'
                                    .'<div class="col-12">'
                                        .'<div class="form-group">'
                                        .'<label>Descrição:</label>'
                                        .'<textarea name="nDescricao" class="form-control" rows="3" placeholder="Escreva..."'
                                            .'maxlength="255">'.$coluna["descricao"].'</textarea>'
                                        .'</div>'
                                    .'</div>'
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
         
            .'<div class="modal fade" id="modalDeleteExecucao'.$coluna["id_execucao"].'">'
                .'<div class="modal-dialog">'
                    .'<div class="modal-content">'
                        .'<div class="modal-header bg-danger">'
                            .'<h4 class="modal-title">Retirar Serviço: '.$coluna["nome"].'</h4>'
                            .'<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">'
                                .'<span aria-hidden="true">&times;</span>'
                            .'</button>'
                        .'</div>'
                        .'<div class="modal-body">'
                            .'<form method="POST" action="php/salvarExecucao.php?funcao=D&codigo='.$coluna["id_execucao"].'&idAgendamento='.$idAgendamento.'&idPorte='.$idPorte.'" enctype="multipart/form-data">'              
                                .'<div class="row">'
                                    .'<div class="col-12">'
                                        .'<h5>Tem certeza de que deseja excluir o registro?</h5>'
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
            .'</div>';            
        }    
    }
 
    return $lista;
}

//Função para montar o select/option
function optionSituacaoExecucao($p){

    if ($p == "I") {
        $option = '';
    }else{
        if ($p == 1) {
            $option = '<option value=2>Executando</option>'
                     .'<option value=3>Executado</option>'
                     .'<option value=4>Cancelado</option>';
        }elseif ($p == 2){
            $option = '<option value=1>Planejado</option>'
                     .'<option value=3>Executado</option>'
                     .'<option value=4>Cancelado</option>';
        }elseif ($p == 3){
            $option = '<option value=1>Planejado</option>'
                     .'<option value=2>Executando</option>'
                     .'<option value=4>Cancelado</option>';
        }elseif ($p == 4){
            $option = '<option value=1>Planejado</option>'
                     .'<option value=2>Executando</option>'
                     .'<option value=3>Executado</option>';
        }
        
    }
    
    return $option;
}

//Função para buscar a descrição da situação da execução
function descrSituacaoExecucao($id){

    if ($id == 1) {
        $descricao = "Planejado";
    }else if($id == 2){
        $descricao = "Executando";
    }else if($id == 3){
        $descricao = "Executado";
    }else if($id == 4){
        $descricao = "Cancelado";
    }         

    return $descricao;
}

?>