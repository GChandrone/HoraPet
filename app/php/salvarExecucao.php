<?php

    include('funcoes.php');

    // Campos adicionais do agendamento (se necessários)
    $hiddenFuncionario = $_POST['nFuncionario'];
    $hiddenData        = $_POST['nData'];
    $hiddenHorario     = $_POST['nHorarioInicio'];
    $hiddenSituacao    = $_POST['nSituacao'];

    var_dump($hiddenFuncionario);
    die();

    $idServico     = $_POST["nServico"];
    $idPorte       = $_GET ["idPorte" ];
    $idAgendamento = $_GET ["idAgendamento"];
    $funcao        = $_GET ["funcao"  ];
    $idExecucao    = $_GET ["codigo"  ];

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
                $nome    = $coluna['nome'];
                $valor   = $coluna['valor'];
                $duracao = $coluna['duracao'];
            }        
        }
    }

    include("conexao.php");

    //Validar se é Inclusão ou Alteração
    if($funcao == "I"){

        //INSERT
        $sql = "INSERT INTO execucao (id_servico,valor,duracao,situacao,id_agendamento) "
             ." VALUES ("."$idServico,$valor,'$duracao',1,$idAgendamento);";

    }elseif($funcao == "A"){
        
        $sql = "UPDATE servico "
                ." SET nome            = '$nome', "
                    ." valor_pequeno   = $valorPequeno, " 
                    ." valor_medio     = $valorMedio, " 
                    ." valor_grande    = $valorGrande, " 
                    ." duracao_pequeno = '$duracaoPequeno', "
                    ." duracao_medio   = '$duracaoMedio', "
                    ." duracao_grande  = '$duracaoGrande', "
                    ." descricao       = '$descricao', "
                    ." ativo           = $ativo "
                ." WHERE id_servico    = $idServico;";

    }elseif($funcao == "D"){
        //DELETE
        $sql = "DELETE FROM execucao "
                ." WHERE id_execucao = $idExecucao;";
    }

    $result = mysqli_query($conn,$sql);

    $sqlAgendamento = "UPDATE agendamento "
                    ." SET id_funcionario   = $hiddenFuncionario, "
                        ." data             = '$hiddenData', " 
                        ." horario_inicial  = '$hiddenHorario', " 
                        ." situacao         = $hiddenSituacao "
                    ." WHERE id_agendamento = $idAgendamento;";

    mysqli_query($conn, $sqlAgendamento);

    mysqli_close($conn);

    header("location: ../agendamento.php?id=".$idAgendamento."&idPorte=".$idPorte."&add=true");

?>