<?php
//Função para listar todos os Raças
 function listaFuncionario(){
     include("conexao.php");
     $sql = "SELECT * FROM funcionario ORDER BY id_funcionario;";
     
     
     $result = mysqli_query($conn,$sql);
     mysqli_close($conn);

     $lista = '';
     $ativo = '';
     $icone = '';

     //Validar se tem retorno do BD
     if (mysqli_num_rows($result) > 0) {
      
      
        foreach ($result as $coluna) {
            //Ativo: 1 -> Sim ou 2 -> Não
            if($coluna["ativo"] == 1){  
                $ativo = 'checked';
                $icone = '<h6><i class="fas fa-check-circle text-success"></i></h6>'; 
            }else{
                $ativo = '';
                $icone = '<h6><i class="fas fa-times-circle text-danger"></i></h6>';
            } 
            
            //***Verificar os dados da consulta SQL
            $lista .= 
            '<tr>'
                 .'<td>'.$coluna["id_funcionario"].'</td>'
                 .'<td>'.$coluna["nome"].'</td>'
                 .'<td>'.$coluna["email"].'</td>'
                 .'<td>'.formatarData($coluna["data_nascimento"]).'</td>'
                 .'<td>'.$coluna["telefone"].'</td>'
                 .'<td align="center">'.$icone.'</td>'

                 
                 .'<td>'
                     .'<div class="row" align="center">'
                         .'<div class="col-6">'
                             .'<a href="#modalEditFuncionario'.$coluna["id_funcionario"].'" data-toggle="modal">'
                                 .'<h6><i class="fas fa-edit text-info" data-toggle="tooltip" title="Alterar Funcionário"></i></h6>'
                             .'</a>'
                         .'</div>'
                         .'<div class="col-6">'
                             .'<a href="#modalDeleteFuncionario'.$coluna["id_funcionario"].'" data-toggle="modal">'
                                 .'<h6><i class="fas fa-trash text-danger" data-toggle="tooltip" title="Excluir Funcionário"></i></h6>'
                             .'</a>'
                         .'</div>'
                     .'</div>'
                 .'</td>'
             .'</tr>'
          
             .'<div class="modal fade" id="modalEditFuncionario'.$coluna["id_funcionario"].'">'
                 .'<div class="modal-dialog modal-lg">'
                     .'<div class="modal-content">'
                         .'<div class="modal-header bg-info">'
                             .'<h4 class="modal-title">Alterar Funcionario</h4>'
                             .'<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">'
                                 .'<span aria-hidden="true">&times;</span>'
                             .'</button>'
                         .'</div>'
                         .'<div class="modal-body">'
                            .'<form method="POST" action="php/salvarFuncionario.php?funcao=A&codigo='.$coluna["id_funcionario"].'" enctype="multipart/form-data">'              
              

                                .'<div class="row">'
                                    .'<div class="col-4">'
                                        .'<div class="form-group">'
                                            .'<label for="iNome">Nome:</label>'
                                            .'<input type="text" value="'.$coluna["nome"].'" class="form-control" id="iNome" name="nNome" maxlength="50">'
                                        .'</div>'
                                    .'</div>'

                                    .'<div class="col-4">'
                                        .'<div class="form-group">'
                                            .'<label for="iLogin">Data de Nascimento:</label>'
                                            .'<input type="date" value="'.$coluna["data_nascimento"].'" class="form-control" id="iData" name="nData" required>'
                                        .'</div>'
                                    .'</div>'

                                    .'<div class="col-4">'
                                        .'<div class="form-group">'
                                            .'<label for="iSenha">Telefone:</label>'
                                            .'<input type="text" value="'.$coluna["telefone"].'" class="form-control telefone-formatado" id="iTelefone" name="nTelefone" maxlength="16">'
                                        .'</div>'
                                    .'</div>'


                                    .'<div class="col-8">'
                                        .'<div class="form-group">'
                                            .'<label for="iLogin">E-mail:</label>'
                                            .'<input type="email" value="'.$coluna["email"].'" class="form-control" id="iEmail" name="nEmail" maxlength="50">'
                                        .'</div>'
                                    .'</div>'

                                    .'<div class="col-4">'
                                        .'<div class="form-group">'
                                            .'<label for="iSenha">Senha:</label>'
                                            .'<input type="password" value="'.$coluna["data_nascimento"].'" class="form-control" id="iSenha" name="nSenha">'
                                        .'</div>'
                                    .'</div>'
                                    
                                .'</div>'
                                    
                                .'<div class="custom-control custom-checkbox">'
                                    .'<input class="custom-control-input custom-control-input-info" type="checkbox" id="iAtivoFuncionario'.$coluna["id_funcionario"].'" name="nAtivoFuncionario" '.$ativo.'>'
                                    .'<label for="iAtivoFuncionario'.$coluna["id_funcionario"].'" class="custom-control-label">Funcionário Ativo</label>'
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
          
             .'<div class="modal fade" id="modalDeleteFuncionario'.$coluna["id_funcionario"].'">'
                 .'<div class="modal-dialog">'
                     .'<div class="modal-content">'
                         .'<div class="modal-header bg-danger">'
                             .'<h4 class="modal-title">Deseja excluir o funcionário: '.$coluna["nome"].'</h4>'
                             .'<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">'
                                 .'<span aria-hidden="true">&times;</span>'
                             .'</button>'
                         .'</div>'
                         .'<div class="modal-body">'
                             .'<form method="POST" action="php/salvarFuncionario.php?funcao=D&codigo='.$coluna["id_funcionario"].'" enctype="multipart/form-data">'              
                                 .'<div class="row">'
                                     .'<div class="col-12">'
                                         .'<h5>Tem certeza de que deseja excluir este funcionário?</h5>'
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