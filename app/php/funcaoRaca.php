<?php
//Função para listar todas as Raças
 function listaRaca(){
     include("conexao.php");
     $sql = "SELECT * FROM raca ORDER BY id_raca;";
          
     $result = mysqli_query($conn,$sql);
     mysqli_close($conn);

     $lista = '';

     //Validar se tem retorno do BD
     if (mysqli_num_rows($result) > 0) {
      
      
         foreach ($result as $coluna) {
             
             //***Verificar os dados da consulta SQL
             $lista .= 
             '<tr>'
                 .'<td>'.$coluna["id_raca"].'</td>'
                 .'<td>'.$coluna["nome"].'</td>'
                 .'<td>'.descrTipoPet($coluna["tipo_pet"]).'</td>'
                 .'<td>'
                     .'<div class="row" align="center">'
                         .'<div class="col-6">'
                             .'<a href="#modalEditRaca'.$coluna["id_raca"].'" data-toggle="modal">'
                                 .'<h6><i class="fas fa-edit text-info" data-toggle="tooltip" title="Alterar Raça"></i></h6>'
                             .'</a>'
                         .'</div>'
                         .'<div class="col-6">'
                             .'<a href="#modalDeleteRaca'.$coluna["id_raca"].'" data-toggle="modal">'
                                 .'<h6><i class="fas fa-trash text-danger" data-toggle="tooltip" title="Excluir Raça"></i></h6>'
                             .'</a>'
                         .'</div>'
                     .'</div>'
                 .'</td>'
             .'</tr>'
          
             .'<div class="modal fade" id="modalEditRaca'.$coluna["id_raca"].'">'
                 .'<div class="modal-dialog modal-lg">'
                     .'<div class="modal-content">'
                         .'<div class="modal-header bg-info">'
                             .'<h4 class="modal-title">Alterar Raça</h4>'
                             .'<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">'
                                 .'<span aria-hidden="true">&times;</span>'
                             .'</button>'
                         .'</div>'
                         .'<div class="modal-body">'
                            .'<form method="POST" action="php/salvarRaca.php?funcao=A&codigo='.$coluna["id_raca"].'" enctype="multipart/form-data">'              
              

                             .'<div class="row">'
                                .'<div class="col-8">'
                                    .'<div class="form-group">'
                                        .'<label for="iNome">Nome:</label>'
                                        .'<input type="text" value="'.$coluna["nome"].'" class="form-control" id="iNome" name="nNome" maxlength="100" required>'
                                    .'</div>'
                                .'</div>'
            
                                .'<div class="col-4">'
                                    .'<div class="form-group">'
                                        .'<label for="iNome">Tipo do Pet:</label>'
                                        .'<select name="nTipoPet" class="form-control" required>'
                                            .'<option value="'.$coluna["tipo_pet"].'">'.descrTipoPet($coluna["tipo_pet"]).'</option>'
                                            .optionTipoPet($coluna["tipo_pet"])
                                        .'</select>'
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
          
             .'<div class="modal fade" id="modalDeleteRaca'.$coluna["id_raca"].'">'
                 .'<div class="modal-dialog">'
                     .'<div class="modal-content">'
                         .'<div class="modal-header bg-danger">'
                             .'<h4 class="modal-title">Excluir Raça: '.$coluna["nome"].'</h4>'
                             .'<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">'
                                 .'<span aria-hidden="true">&times;</span>'
                             .'</button>'
                         .'</div>'
                         .'<div class="modal-body">'
                             .'<form method="POST" action="php/salvarRaca.php?funcao=D&codigo='.$coluna["id_raca"].'" enctype="multipart/form-data">'              
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

 //Função para buscar o nome do dono do pet
 function descrRaca($id){

    $nome = "";

    include("conexao.php");
    $sql = "SELECT nome FROM raca WHERE id_raca = $id;";        
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

?>