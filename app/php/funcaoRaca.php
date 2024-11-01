<?php
//Função para listar todos os Raças
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
                                        .'<input type="text" value="'.$coluna["nome"].'" class="form-control" id="iNome" name="nNome" maxlength="100">'
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
                            
                                // .'<div class="col-12">' UTILIZAR NO CADASTRO DO PET
                                //     .'<div class="form-group">'
                                //         .'<label for="iFoto">Foto:</label>'
                                //         .'<div class="custom-file">'
                                //             .'<input type="file" class="custom-file-input" id="iFoto" name="nFoto" accept="image/*">'
                                //             .'<label class="custom-file-label" for="customFile">Nenhum arquivo escolhido</label>'
                                //         .'</div>'
                                //     .'</div>'
                                // .'</div>'
                                
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

// //Função para buscar o tipo de acesso do usuário
// function tipoAcessoUsuario($id){

//     $resp = "";

//     include("conexao.php");
//     $sql = "SELECT idTipoUsuario FROM usuarios WHERE idUsuario = $id;";        
//     $result = mysqli_query($conn,$sql);
//     mysqli_close($conn);

//     //Validar se tem retorno do BD
//     if (mysqli_num_rows($result) > 0) {
                
//         $array = array();
        
//         while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
//             array_push($array,$linha);
//         }
        
//         foreach ($array as $coluna) {            
//             //***Verificar os dados da consulta SQL
//             if($coluna["idTipoUsuario"] == 1){
//                 //Admin
//                 $resp = '<option value="1">Admin</option>'
//                         .'<option value="2">Empresa</option>'
//                         .'<option value="3">Comum</option>';
//             }else if($coluna["idTipoUsuario"] == 2){
//                 //Empresa
//                 $resp = '<option value="2">Empresa</option>'
//                         .'<option value="1">Admin</option>'
//                         .'<option value="3">Comum</option>';
//             }else{
//                 //Comum
//                 $resp = '<option value="3">Comum</option>'
//                         .'<option value="1">Admin</option>'
//                         .'<option value="2">Empresa</option>';
//             }
//         }        
//     } 

//     return $resp;
// }

// //Função para buscar a foto do usuário
// function fotoUsuario($id){

//     $resp = "";

//     include("conexao.php");
//     $sql = "SELECT Foto FROM usuarios WHERE idUsuario = $id;";        
//     $result = mysqli_query($conn,$sql);
//     mysqli_close($conn);

//     //Validar se tem retorno do BD
//     if (mysqli_num_rows($result) > 0) {
                
//         $array = array();
        
//         while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
//             array_push($array,$linha);
//         }
        
//         foreach ($array as $coluna) {            
//             //***Verificar os dados da consulta SQL
//             $resp = $coluna["Foto"];
//         }        
//     } 

//     return $resp;
// }

// //Função para buscar o nome do usuário
// function nomeUsuario($id){

//     $resp = "";

//     include("conexao.php");
//     $sql = "SELECT Nome FROM usuarios WHERE idUsuario = $id;";        
//     $result = mysqli_query($conn,$sql);
//     mysqli_close($conn);

//     //Validar se tem retorno do BD
//     if (mysqli_num_rows($result) > 0) {
                
//         $array = array();
        
//         while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
//             array_push($array,$linha);
//         }
        
//         foreach ($array as $coluna) {            
//             //***Verificar os dados da consulta SQL
//             $resp = $coluna["Nome"];
//         }        
//     } 

//     return $resp;
// }

// //Função para buscar o login do usuário
// function loginUsuario($id){

//     $resp = "";

//     include("conexao.php");
//     $sql = "SELECT Login FROM usuarios WHERE idUsuario = $id;";        
//     $result = mysqli_query($conn,$sql);
//     mysqli_close($conn);

//     //Validar se tem retorno do BD
//     if (mysqli_num_rows($result) > 0) {
                
//         $array = array();
        
//         while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
//             array_push($array,$linha);
//         }
        
//         foreach ($array as $coluna) {            
//             //***Verificar os dados da consulta SQL
//             $resp = $coluna["Login"];
//         }        
//     } 

//     return $resp;
// }

// //Função para buscar a flag FlgAtivo do usuário
// function ativoUsuario($id){

//     $resp = "";

//     include("conexao.php");
//     $sql = "SELECT FlgAtivo FROM usuarios WHERE idUsuario = $id;";        
//     $result = mysqli_query($conn,$sql);
//     mysqli_close($conn);

//     //Validar se tem retorno do BD
//     if (mysqli_num_rows($result) > 0) {
        
//         foreach ($result as $coluna) {            
//             //***Verificar os dados da consulta SQL
//             if($coluna["FlgAtivo"] == 'S') $resp = 'checked'; else $resp = '';
//         }        
//     } 

//     return $resp;
// }

// //Função para retornar a qtd de usuários ativos
// function qtdUsuariosAtivos(){
//     $qtd = 0;

//     include("conexao.php");
//     $sql = "SELECT COUNT(*) AS Qtd FROM usuarios WHERE FlgAtivo = 'S';";

//     $result = mysqli_query($conn,$sql);
//     mysqli_close($conn);

//     //Validar se tem retorno do BD
//     if (mysqli_num_rows($result) > 0) {
        
//         foreach ($result as $coluna) {            
//             //***Verificar os dados da consulta SQL
//             $qtd = $coluna['Qtd'];
//         }        
//     }
    
//     return $qtd;
// }

// ?>