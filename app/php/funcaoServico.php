<?php
//Função para listar todos os usuários
function listaServico(){

    include("conexao.php");
    $sql = "SELECT * FROM servico ORDER BY id_servico;";
            
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
                .'<td>'.$coluna["id_servico"].'</td>'
                .'<td>'.$coluna["nome"].'</td>'
                .'<td>'.formatarMoeda($coluna["valor_pequeno"]).'</td>'
                .'<td>'.formatarMoeda($coluna["valor_medio"]).'</td>'
                .'<td>'.formatarMoeda($coluna["valor_grande"]).'</td>'
                .'<td>'.formatarHora($coluna["duracao_pequeno"]).'</td>'
                .'<td>'.formatarHora($coluna["duracao_medio"]).'</td>'
                .'<td>'.formatarHora($coluna["duracao_grande"]).'</td>'
                // .'<td>'.$coluna["descricao"].'</td>'
                .'<td align="center">'.$icone.'</td>'
                .'<td>'
                    .'<div class="row" align="center">'
                        .'<div class="col-6">'
                            .'<a href="#modalEditServico'.$coluna["id_servico"].'" data-toggle="modal">'
                                .'<h6><i class="fas fa-edit text-info" data-toggle="tooltip" title="Alterar serviço"></i></h6>'
                            .'</a>'
                        .'</div>'

                        .'<div class="col-6">'
                            .'<a href="#modalDeleteServico'.$coluna["id_servico"].'" data-toggle="modal">'
                                .'<h6><i class="fas fa-trash text-danger" data-toggle="tooltip" title="Excluir serviço"></i></h6>'
                            .'</a>'
                        .'</div>'
                    .'</div>'
                .'</td>'
            .'</tr>'
            
            .'<div class="modal fade" id="modalEditServico'.$coluna["id_servico"].'">'
                .'<div class="modal-dialog modal-lg">'
                    .'<div class="modal-content">'
                        .'<div class="modal-header bg-info">'
                            .'<h4 class="modal-title">Alterar Serviço</h4>'
                            .'<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">'
                                .'<span aria-hidden="true">&times;</span>'
                            .'</button>'
                        .'</div>'
                        .'<div class="modal-body">'

                            .'<form id="formAjusteServico" data-servico-id="'.$coluna["id_servico"].'" method="POST" action="php/salvarServico.php?funcao=A&codigo='.$coluna["id_servico"].'" enctype="multipart/form-data">'              
                
                                .'<div class="row">'
                                    .'<div class="col-12">'
                                        .'<div class="form-group">'
                                            .'<label for="iNome">Título do serviço:</label>'
                                            .'<input type="text" value="'.$coluna["nome"].'" class="form-control" id="iTitulo" name="nTitulo" maxlength="50" required>'
                                        .'</div>'
                                    .'</div>'
                                .'</div>'

                                .'<div class="row">'
                                    .'<div class="col-12">'
                                        .'<div class="form-group">'
                                            .'<label>Descrição</label>'
                                            .'<textarea name="nDescricao" class="form-control" rows="3" placeholder="Escreva..." maxlength="255">'.$coluna["descricao"].'</textarea>'
                                        .'</div>'
                                    .'</div>'
                                .'</div>'

                                .'<h6><b>Configurações por porte</b></h6>'

                                .'<div class="btn-group btn-group-toggle mb-2" data-toggle="buttons">'
                                    .'<label class="btn btn-outline-info active btn-sm" onclick="mostrarCampos(\'pequeno\', \'modalEditServico' . $coluna['id_servico'] . '\')">'
                                        .'<input type="radio" class="form-control" name="porte" id="portePequeno" autocomplete="off" checked> Pequeno'
                                    .'</label>'
                                    .'<label class="btn btn-outline-info btn-sm" onclick="mostrarCampos(\'medio\', \'modalEditServico' . $coluna['id_servico'] . '\')">'
                                        .'<input type="radio" class="form-control" name="porte" id="porteMedio" autocomplete="off"> Médio'
                                    .'</label>'
                                    .'<label class="btn btn-outline-info btn-sm" onclick="mostrarCampos(\'grande\', \'modalEditServico' . $coluna['id_servico'] . '\')">'
                                        .'<input type="radio" class="form-control" name="porte" id="porteGrande" autocomplete="off"> Grande'
                                    .'</label>'
                                .'</div>'

                                .'<div id="camposPequeno" class="porte-campos">'
                                    .'<div class="row">'
                                        .'<div class="col-6">'
                                            .'<div class="form-group">'
                                                .'<label for="valorPequeno">Valor (Pequeno):</label>'
                                                .'<input type="text" value="'.formatarMoeda($coluna["valor_pequeno"]).'" class="form-control valor-real" id="valorPequenoAlterar'.$coluna["id_servico"].'" name="nValorPequeno" placeholder="R$ 0,00" maxlength="9">'
                                            .'</div>'
                                        .'</div>'
                                        .'<div class="col-6">'
                                            .'<div class="form-group">'
                                                .'<label for="duracaoPequeno">Duração (Pequeno):</label>'
                                                .'<input type="time" value="'.$coluna["duracao_pequeno"].'" class="form-control" id="duracaoPequenoAlterar'.$coluna["id_servico"].'" name="nDuracaoPequeno">'
                                            .'</div>'
                                        .'</div>'
                                    .'</div>'
                                .'</div>'

                                .'<div id="camposMedioAlterar" class="porte-campos" style="display: none;">'
                                    .'<div class="row">'
                                        .'<div class="col-6">'
                                            .'<div class="form-group">'
                                                .'<label for="valorMedio">Valor (Médio):</label>'
                                                .'<input type="text" value="'.formatarMoeda($coluna["valor_medio"]).'" class="form-control valor-real" id="valorMedioAlterar'.$coluna["id_servico"].'" name="nValorMedio" placeholder="R$ 0,00" maxlength="9">'
                                            .'</div>'
                                        .'</div>'
                                        .'<div class="col-6">'
                                            .'<div class="form-group">'
                                                .'<label for="duracaoMedio">Duração (Médio):</label>'
                                                .'<input type="time" value="'.$coluna["duracao_medio"].'" class="form-control" id="duracaoMedioAlterar'.$coluna["id_servico"].'" name="nDuracaoMedio">'
                                            .'</div>'
                                        .'</div>'
                                    .'</div>'
                                .'</div>'

                                .'<div id="camposGrandeAlterar" class="porte-campos" style="display: none;">'
                                    .'<div class="row">'
                                        .'<div class="col-6">'
                                            .'<div class="form-group">'
                                                .'<label for="valorGrande">Valor (Grande):</label>'
                                                .'<input type="text" value="'.formatarMoeda($coluna["valor_grande"]).'" class="form-control valor-real" id="valorGrandeAlterar'.$coluna["id_servico"].'" name="nValorGrande" placeholder="R$ 0,00" maxlength="9">'
                                            .'</div>'
                                        .'</div>'
                                        .'<div class="col-6">'
                                            .'<div class="form-group">'
                                                .'<label for="duracaoGrande">Duração (Grande):</label>'
                                                .'<input type="time" value="'.$coluna["duracao_grande"].'" class="form-control" id="duracaoGrandeAlterar'.$coluna["id_servico"].'" name="nDuracaoGrande">'
                                            .'</div>'
                                        .'</div>'
                                    .'</div>'
                                .'</div>'

                                .'<div class="form-group">'
                                    .'<div class="custom-control custom-checkbox">'
                                        .'<input class="custom-control-input custom-control-input-info" type="checkbox" id="iAtivoServico'.$coluna["id_servico"].'" name="nAtivoServico" '.$ativo.'>'
                                        .'<label for="iAtivoServico'.$coluna["id_servico"].'" class="custom-control-label">Serviço Ativo</label>'
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
            
            .'<div class="modal fade" id="modalDeleteServico'.$coluna["id_servico"].'">'
                .'<div class="modal-dialog">'
                    .'<div class="modal-content">'
                        .'<div class="modal-header bg-danger">'
                            .'<h4 class="modal-title">Excluir Serviço: '.$coluna["nome"].'</h4>'
                            .'<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">'
                                .'<span aria-hidden="true">&times;</span>'
                            .'</button>'
                        .'</div>'
                        .'<div class="modal-body">'

                            .'<form method="POST" action="php/salvarServico.php?funcao=D&codigo='.$coluna["id_servico"].'" enctype="multipart/form-data">'              

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
function optionServico($idPorte){

    $option = "";

    include("conexao.php");
    $sql  = "SELECT ";
    $sql .= "  id_servico, ";
    $sql .= "  nome, ";
    if ($idPorte == 1) {
        $sql .=  " valor_pequeno as valor ";
    }elseif($idPorte == 2){
        $sql .=  " valor_medio   as valor ";
    }else{
        $sql .=  " valor_grande  as valor ";
    }
    $sql .= "FROM servico ORDER BY nome;";    

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
            $option .= '<option value="'.$coluna['id_servico'].'">'.$coluna['nome'].' - '.formatarMoeda($coluna['valor']).'</option>';
        }        
    } 

    return $option;
}

?>