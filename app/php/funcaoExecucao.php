<?php
//Função para listar todas as Raças
function listaExecucao(){
    include("conexao.php");

    $sql = "SELECT "
               ."execucao.id_execucao, "
               ."servico.nome, "
               ."execucao.valor, "
               ."execucao.duracao, "
               ."execucao.situacao, "
               ."execucao.descricao "  
          ."FROM execucao "
          ."INNER JOIN servico "
          ."   ON servico.id_servico = execucao.id_servico "
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
                .'<td>'.$coluna["duracao"].'</td>'
                .'<td>'.$coluna["situacao"].'</td>'
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
                            .'<h4 class="modal-title">Alterar Raça</h4>'
                            .'<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">'
                                .'<span aria-hidden="true">&times;</span>'
                            .'</button>'
                        .'</div>'
                        .'<div class="modal-body">'
                           .'<form method="POST" action="php/salvarExecucao.php?funcao=A&codigo='.$coluna["id_execucao"].'" enctype="multipart/form-data">'              
             

                                .'<div class="row">'
                                    .'<div class="col-12">'
                                        .'<div class="form-group">'
                                            .'<label for="iNome">Nome:</label>'
                                            .'<input type="text" value="'.$coluna["nome"].'" class="form-control" id="iNome" name="nNome" maxlength="100" required>'
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
                            .'<form method="POST" action="php/salvarExecucao.php?funcao=D&codigo='.$coluna["id_execucao"].'" enctype="multipart/form-data">'              
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

?>