<?php
//Função para listar todos os usuários
function listaPet(){

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

            //Ativo: 1 -> Sim ou 2 -> Não
            if($coluna["ativo"] == 1){  
                $ativo = 'checked';
                $icone = '<h6><i class="fas fa-check-circle text-success"></i></h6>'; 
            }else{
                $ativo = '';
                $icone = '<h6><i class="fas fa-times-circle text-danger"></i></h6>';
            } 
            
            // Verifica se há foto
            if (!empty($coluna["foto"])) {
                $fotoPet = $coluna["foto"];
            } else {;
                $fotoPet = 'dist/img/default-pet.png';
            } 

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
                                             .'<input type="number" value="'.$coluna["altura"].'" class="form-control" id="iAlturaAlterar" name="nAltura" required min="10" max="150">'
                                         .'</div>'
                                     .'</div>'
            
                                     .'<div class="col-3">'
                                         .'<div class="form-group">'
                                             .'<label for="iPesoAlterar">Peso (kg):</label>'
                                             .'<input type="number" value="'.$coluna["peso"].'" class="form-control" id="iPesoAlterar" name="nPeso" required min="1" max="150">'
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

//Próximo ID do usuário
function proxIdPet(){

    $id = "";

    include("conexao.php");
    $sql = "SELECT MAX(id_pet) AS Maior FROM pet;";        
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
            $id = $coluna["Maior"] + 1;
        }        
    } 

    return $id;
}

//Função para buscar a foto do pet
function fotoPet($id){

    $resp = "";

    include("conexao.php");
    $sql = "SELECT foto FROM pet WHERE id_pet = $id;";        
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
            $resp = $coluna["foto"];
        }        
    } 

    return $resp;
}

//Função para buscar o id do porte
function idPorte($descricao){

    if ($descricao == "Pequeno") {
        $id = 1;
    }else if($descricao == "Médio"){
        $id = 2;
    }else if($descricao == "Grande"){
        $id = 3;
    }    

    return $id;
}

//Função para buscar a descrição do porte
function descrPorte($id){

    if ($id == 1) {
        $descricao = "Pequeno";
    }else if($id == 2){
        $descricao = "Médio";
    }else if($id == 3){
        $descricao = "Grande";
    }    

    return $descricao;
}

//Função para buscar o porte do pet
function portePet($id){

    $resp = "";

    include("conexao.php");
    $sql = "SELECT porte FROM pet WHERE id_pet = $id;";        
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
            $resp = $coluna["porte"];
        }        
    } 

    return $resp;
}

?>