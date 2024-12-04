<?php

    include('funcoes.php');

    $idServico          = $_POST["nServico"];
    $idSituacaoExecucao = $_POST["nSituacaoExecucao"];
    $descricao          = $_POST["nDescricao"];
    $idPorte            = $_GET ["idPorte" ];
    $idAgendamento      = $_GET ["idAgendamento"];
    $funcao             = $_GET ["funcao"  ];
    $idExecucao         = $_GET ["codigo"  ];
    $duracaoTotal       = 0;
    $contServico        = 0;

    if($funcao == "I" || $funcao == "A"){

        include("conexao.php");

        $sql  = "SELECT ";
        $sql .= "  nome, ";
        if ($idPorte == 1) {
            $sql .=  " valor_pequeno   as valor, ";
            $sql .=  " duracao_pequeno as duracao ";
        }elseif($idPorte == 2){
            $sql .=  " valor_medio     as valor, ";
            $sql .=  " duracao_medio   as duracao ";
        }else{
            $sql .=  " valor_grande    as valor, ";
            $sql .=  " duracao_grande  as duracao ";
        }
        $sql .= "FROM servico ";
        $sql .= "WHERE id_servico = ".$idServico.";";    

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
                $nome          = $coluna['nome'];
                $valor         = $coluna['valor'];
                $duracao       = $coluna['duracao'];

                if($contServico > 0) $duracaoTotal += date('H:i:s',strtotime($duracao)); else $duracaoTotal = date('H:i:s',strtotime($duracao));
                
                $contServico++;
            }        
        }
    }

    include("conexao.php");

    //Validar se é Inclusão ou Alteração
    if($funcao == "I"){

        // Verifica se o serviço já foi adicionado ao agendamento
        $sqlCheck = "SELECT COUNT(*) as total " 
                  . "FROM execucao "
                  ." WHERE id_agendamento = $idAgendamento AND id_servico = $idServico;";

        $resultCheck = mysqli_query($conn, $sqlCheck);
       
        $row = mysqli_fetch_assoc($resultCheck);

        if ($row['total'] > 0) {
            // Retorna uma resposta dizendo que o serviço já foi adicionado
            $_SESSION['erro_mensagem'] = 'Este serviço já foi adicionado a este agendamento.';
        } else {
            //INSERT
            $sql = "INSERT INTO execucao (id_servico,valor,duracao,descricao,situacao,id_agendamento) "
                ." VALUES ("."$idServico,$valor,'$duracao','$descricao',1,$idAgendamento);";

        }

    }elseif($funcao == "A"){
        
        $sql = "UPDATE execucao "
                ." SET id_servico     = $idServico, "
                    ." valor          = $valor, " 
                    ." duracao        = '$duracao', " 
                    ." descricao      = '$descricao', " 
                    ." situacao       = $idSituacaoExecucao, "
                    ." id_agendamento = $idAgendamento "
                ." WHERE id_execucao  = $idExecucao;";

    }elseif($funcao == "D"){
        //DELETE
        $sql = "DELETE FROM execucao "
                ." WHERE id_execucao = $idExecucao;";
    }

    $result = mysqli_query($conn,$sql);

    mysqli_close($conn);

    atualizaDuracaoAgendamento($idAgendamento);

    header("location: ../agendamento.php?id=".$idAgendamento."&idPorte=".$idPorte."&add=true");

?>