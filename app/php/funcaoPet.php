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
                .'<td>'.$coluna["id_pet"].'</td>'
                .'<td align="center">'.'Foto'.'</td>'
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
                                            .'<input type="text" value="'.$coluna["nome_pet"].'" class="form-control" id="iNome" name="nNome" maxlength="50">'
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
                                            .'<select id="iTipoPetAjax" name="nTipoPet" class="form-control" required>'
                                                .'<option value="'.$coluna["tipo_pet"].'">'.descrTipoPet($coluna["tipo_pet"]).'</option>'
                                                .optionTipoPet($coluna["tipo_pet"])
                                            .'</select>'
                                        .'</div>'
                                    .'</div>'
            
                                    .'<div class="col-6">'
                                        .'<div class="form-group">'
                                            .'<label for="iRacaAjax">Raça:</label>'
                                                .'<select name="nRacaAjax" id="iRacaAjax" class="form-control" required>'
                                                .'<option value="">Selecione...</option>'
                                            .'</select>'
                                        .'</div>'
                                    .'</div>'
            
                                    .'<div class="col-3">'
                                        .'<div class="form-group">'
                                            .'<label for="iAltura">Altura (cm):</label>'
                                            .'<input type="number" value="'.$coluna["altura"].'" class="form-control" id="iAltura" name="nAltura">'
                                        .'</div>'
                                    .'</div>'
            
                                    .'<div class="col-3">'
                                        .'<div class="form-group">'
                                            .'<label for="iPeso">Peso (kg):</label>'
                                            .'<input type="number" value="'.$coluna["peso"].'" class="form-control" id="iPeso" name="nPeso">'
                                        .'</div>'
                                    .'</div>'
            
                                    .'<div class="col-6">'
                                        .'<div class="form-group">'
                                            .'<label for="iPorte">Porte:</label>'
                                            .'<input type="text" value="'.descrPorte($coluna["porte"]).'" class="form-control" id="iPorte" name="nPorte" readonly>'
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
                                    .'<input class="custom-control-input custom-control-input-success" type="checkbox" id="iAtivoPet'.$coluna["id_pet"].'" name="nAtivoPet" '.$ativo.'>'
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
                                        .'<h5>Tem certeza de que deseja excluir este pet??</h5>'
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

//Função para buscar a foto do usuário
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

?>

<script>

  // Código de porte dinâmico
  function atualizarPorte() {
    const altura = parseFloat(document.getElementById('iAltura').value) || 0;
    const peso = parseFloat(document.getElementById('iPeso').value) || 0;
    let porte = '';

  // Calcula uma pontuação com ponderação entre peso e altura
  const pontuacao = (peso * 1.5) + (altura * 1);

  // Classificação com base na pontuação
  if (pontuacao <= 55) {
    porte = 'Pequeno';
  } else if (pontuacao > 55 && pontuacao <= 87) {
    porte = 'Médio';
  } else {
    porte = 'Grande';
  }

    document.getElementById('iPorte').value = porte;
  }

  // Eventos de mudança
  document.getElementById('iAltura').addEventListener('input', atualizarPorte);
  document.getElementById('iPeso').addEventListener('input', atualizarPorte);

  //Lista dinâmica com Ajax
  $('#iTipoPetAjax').on('change',function(){
		//Pega o valor selecionado na lista 1
    var tipoPet  = $('#iTipoPetAjax').val();
    
    //Prepara a lista 2 filtrada
    var optionRaca = '';
              
    //Valida se teve seleção na lista 1
    if(tipoPet != "" && tipoPet != "0"){
      
      //Vai no PHP consultar dados para a lista 2
      $.getJSON('php/carregaRaca.php?tipo='+tipoPet,
      function (dados){  
        
        //Carrega a primeira option
        optionRaca = '<option value="">Selecione...</option>';                  
        
        //Valida o retorno do PHP para montar a lista 2
        if (dados.length > 0){                        
          
          //Se tem dados, monta a lista 2
          $.each(dados, function(i, obj){
            optionRaca += '<option value="'+obj.id_raca+'">'+obj.nome+'</option>';	                            
          })
          //Marca a lista 2 como required e mostra os dados filtrados
          $('#iRacaAjax').attr("required", "req");						
          $('#iRacaAjax').html(optionRaca).show();
        }else{
          
          //Não encontrou itens para a lista 2
          optionRaca += '<option value="">Selecione...</option>';
          $('#iRacaAjax').html(optionRaca).show();
        }
      })                
    }else{
      //Sem seleção na lista 1 não consulta
      optionRaca += '<option value="">Selecione...</option>';
      $('#iTipoPetAjax').html(optionRaca).show();
    }			
	});

    </script>