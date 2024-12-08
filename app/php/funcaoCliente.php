<?php
//Função para listar todos os Clientes
 function listaCliente(){
     include("conexao.php");
     $sql = "SELECT * FROM cliente ORDER BY id_cliente;";
     
     
     $result = mysqli_query($conn,$sql);
     mysqli_close($conn);

     $lista = '';

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
                 .'<td>'.$coluna["id_cliente"].'</td>'
                 .'<td>'.$coluna["nome"].'</td>'
                 .'<td>'.$coluna["telefone"].'</td>'
                //  .'<td>'.$coluna["email"].'</td>'
                 .'<td>'.$coluna["estado"].'</td>'
                 .'<td>'.$coluna["cidade"].'</td>'
                 .'<td>'.$coluna["bairro"].'</td>'
                 .'<td>'.$coluna["endereco"].'</td>'
                 .'<td>'.$coluna["numero"].'</td>'
                //  .'<td>'.$coluna["complemento"].'</td>'
                 .'<td align="center">'.$icone.'</td>'

                 .'<td>'
                     .'<div class="row" align="center">'
                         .'<div class="col-6">'
                             .'<a href="#modalEditCliente'.$coluna["id_cliente"].'" data-toggle="modal">'
                                 .'<h6><i class="fas fa-edit text-info" data-toggle="tooltip" title="Alterar Cliente"></i></h6>'
                             .'</a>'
                         .'</div>'
                         .'<div class="col-6">'
                             .'<a href="#modalDeleteCliente'.$coluna["id_cliente"].'" data-toggle="modal">'
                                 .'<h6><i class="fas fa-trash text-danger" data-toggle="tooltip" title="Excluir Cliente"></i></h6>'
                             .'</a>'
                         .'</div>'
                     .'</div>'
                 .'</td>'
             .'</tr>'
          
             .'<div class="modal fade" id="modalEditCliente'.$coluna["id_cliente"].'">'
                 .'<div class="modal-dialog modal-lg">'
                     .'<div class="modal-content">'
                         .'<div class="modal-header bg-info">'
                             .'<h4 class="modal-title">Alterar Cliente</h4>'
                             .'<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">'
                                 .'<span aria-hidden="true">&times;</span>'
                             .'</button>'
                         .'</div>'
                         .'<div class="modal-body">'
                            .'<form method="POST" action="php/salvarCliente.php?funcao=A&codigo='.$coluna["id_cliente"].'" enctype="multipart/form-data">'              

                                .'<div class="row">'
                                    .'<div class="col-8">'
                                        .'<div class="form-group">'
                                            .'<label for="iNome">Nome:</label>'
                                            .'<input type="text" value="'.$coluna["nome"].'" class="form-control" id="iNome" name="nNome" maxlength="50" required>'
                                        .'</div>'
                                    .'</div>'

                                    .'<div class="col-4">'
                                        .'<div class="form-group">'
                                            .'<label for="iTelefone">Telefone:</label>'
                                            .'<input type="text" value="'.$coluna["telefone"].'" class="form-control telefone-formatado" id="iTelefone" name="nTelefone" maxlength="16" required>'
                                        .'</div>'
                                    .'</div>'


                                    .'<div class="col-12">'
                                        .'<div class="form-group">'
                                            .'<label for="iEmail">E-mail:</label>'
                                            .'<input type="email" value="'.$coluna["email"].'" class="form-control" id="iEmail" name="nEmail" maxlength="150" required>'
                                        .'</div>'
                                    .'</div>'

                                    .'<div class="col-3">'
                                        .'<div class="form-group">'
                                            .'<label>CEP</label>'
                                            .'<input value="'.$coluna["cep"].'" name="nCEP" id="iCEP" type="text" class="form-control cep" maxlength="9" required>'
                                        .'</div>'
                                    .'</div>'
                                    
                                    .'<div class="col-9">'
                                        .'<div class="form-group">'
                                            .'<label>Endereço</label>'
                                            .'<input required value="'.$coluna["endereco"].'" name="nEndereco" id="iEndereco" type="text" class="form-control" maxlength="150" required>'
                                        .'</div>'
                                    .'</div>'

                                    .'<div class="col-3">'
                                        .'<div class="form-group">'
                                            .'<label>Número</label>'
                                            .'<input required value="'.$coluna["numero"].'" name="nNumero" id="iNumero" type="text" maxlength="5" class="form-control">'
                                        .'</div>'
                                    .'</div>'

                                    .'<div class="col-9">'
                                        .'<div class="form-group">'
                                            .'<label>Complemento</label>'
                                            .'<input name="nComplemento" value="'.$coluna["complemento"].'" id="iComplemento" type="text" maxlength="100" class="form-control">'
                                        .'</div>'
                                    .'</div>'

                                    .'<div class="col-5">'
                                        .'<div class="form-group">'
                                            .'<label>Bairro</label>'
                                            .'<input required name="nBairro" value="'.$coluna["bairro"].'" id="iBairro" type="text" class="form-control" maxlength="100" required>'
                                        .'</div>'
                                    .'</div>'
                                    
                                    .'<div class="col-5">'
                                        .'<div class="form-group">'
                                            .'<label>Cidade</label>'
                                            .'<input required name="nCidade" value="'.$coluna["cidade"].'" id="iCidade" type="text" class="form-control" maxlength="100" required>'
                                        .'</div>'
                                    .'</div>'

                                    .'<div class="col-2">'
                                        .'<div class="form-group">'
                                            .'<label>UF</label>'
                                            .'<input required name="nUF" value="'.$coluna["estado"].'" id="iUF" type="text" class="form-control" maxlength="2" required>'
                                        .'</div>'
                                    .'</div>'
                                
                                .'</div>'
                                
                                .'<div class="custom-control custom-checkbox">'
                                    .'<input class="custom-control-input custom-control-input-info" type="checkbox" id="iAtivoCliente'.$coluna["id_cliente"].'" name="nAtivoCliente" '.$ativo.'>'
                                    .'<label for="iAtivoCliente'.$coluna["id_cliente"].'" class="custom-control-label">Cliente Ativo</label>'
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
          
             .'<div class="modal fade" id="modalDeleteCliente'.$coluna["id_cliente"].'">'
                 .'<div class="modal-dialog">'
                     .'<div class="modal-content">'
                         .'<div class="modal-header bg-danger">'
                             .'<h4 class="modal-title">Excluir Cliente: '.$coluna["nome"].'</h4>'
                             .'<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">'
                                 .'<span aria-hidden="true">&times;</span>'
                             .'</button>'
                         .'</div>'
                         .'<div class="modal-body">'
                             .'<form method="POST" action="php/salvarCliente.php?funcao=D&codigo='.$coluna["id_cliente"].'" enctype="multipart/form-data">'              
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

function optionCliente(){

    $lista = "";

    include("conexao.php");
    $sql = "SELECT id_cliente, nome FROM cliente ORDER BY id_cliente;";        
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {
        
        foreach ($result as $coluna) {            
            //***Verificar os dados da consulta SQL
            $lista .= '<option value="'.$coluna['id_cliente'].'">'.$coluna['nome'].'</option>';
        }        
    } 

    return $lista;

}

 ?>