<?php
    include('funcoes.php');

    $cliente             = $_POST["nCliente"];
    $pet                 = $_POST["nPet"];
    $funcionario         = $_POST["nFuncionario"];
    $data                = $_POST["nData"];
    $horainicio          = $_POST["nHorarioInicio"];
    $situacaoAgendamento = $_POST["nSituacaoAgendamento"];
    $funcao              = $_GET["funcao"];
    $idAgendamento       = $_GET["codigo"];

    include("conexao.php");

    // Função para verificar conflito de horários
    function verificaConflito($conn, $funcionario, $data, $horainicio, $idAgendamento = null) {
        $query = "SELECT COUNT(*) as total 
                  FROM agendamento 
                  WHERE id_funcionario = $funcionario 
                    AND data = '$data' 
                    AND horario_inicial = '$horainicio'";

        // Se for uma atualização, excluímos o agendamento atual da verificação
        if ($idAgendamento !== null) {
            $idAgendamento = decodeId($idAgendamento);
            $query .= " AND id_agendamento != $idAgendamento";
        }

        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);

        return $row['total'] > 0;
    }

    // Validar se é Inclusão ou Alteração
    if ($funcao == "I") {

        // Verificar conflitos
        if (verificaConflito($conn, $funcionario, $data, $horainicio)) {
            mysqli_close($conn);
            $_SESSION['erro_mensagem'] = $errorMessage;
            header("location: ../agendamento.php?error=conflito");
            

        }else{
                // INSERT
                $sql = "INSERT INTO agendamento (horario_inicial,horario_final,data,situacao,id_pet,id_cliente,id_funcionario) "
                . " VALUES ('$horainicio','$horainicio','$data',$situacaoAgendamento,$pet,$cliente,$funcionario);";

                $result = mysqli_query($conn, $sql);
                mysqli_close($conn);

                $idAgendamento = idAgendamentoServico($cliente, $pet, $data);
                $idPorte = portePet($pet);
                header("location: ../agendamento.php?id=" . encodeId($idAgendamento));
        }        

    } elseif ($funcao == "A") {

        // Verificar conflitos
        if (verificaConflito($conn, $funcionario, $data, $horainicio, $idAgendamento)) {
            mysqli_close($conn);
            header("location: ../agendamento.php?id=$idAgendamento&error=conflito");
            exit();
        }

        // UPDATE
        $sql = "UPDATE agendamento "
        . " SET id_funcionario   = $funcionario, "
        . "     data             = '$data', " 
        . "     horario_inicial  = '$horainicio', " 
        . "     situacao         = $situacaoAgendamento "
        . " WHERE id_agendamento = " . decodeId($idAgendamento) . ";";

        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);

        header("location: ../agendamento.php?id=" . $idAgendamento . "&add=true");

    } elseif ($funcao == "D") {

        // DELETE
        $sqlExecucao = "DELETE FROM execucao WHERE id_agendamento = $idAgendamento;";
        mysqli_query($conn, $sqlExecucao);

        $sqlAgendamento = "DELETE FROM agendamento WHERE id_agendamento = $idAgendamento;";
        mysqli_query($conn, $sqlAgendamento);

        mysqli_close($conn);

        header("location: ../agendamentos.php");
    }
?>
