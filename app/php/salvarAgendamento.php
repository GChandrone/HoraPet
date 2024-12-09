<?php
    include('funcoes.php');

    $cliente             = $_POST["nCliente"            ];
    $pet                 = $_POST["nPet"                ];
    $funcionario         = $_POST["nFuncionario"        ];
    $data                = $_POST["nData"               ];
    $horainicio          = $_POST["nHorarioInicio"      ];
    $situacaoAgendamento = $_POST["nSituacaoAgendamento"];
    $funcao              = $_GET ["funcao"              ];
    $idAgendamento       = $_GET ["codigo"              ];

    // var_dump($cliente.'-'.$pet);
    // die();

    include("conexao.php");

    // Validar se é Inclusão ou Alteração
    if($funcao == "I"){

        // INSERT
        $sql = "INSERT INTO agendamento (horario_inicial,horario_final,data,situacao,id_pet,id_cliente,id_funcionario) "
        ." VALUES ('$horainicio','$horainicio','$data',$situacaoAgendamento,$pet,$cliente,$funcionario);";

        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);

        $idAgendamento = idAgendamentoServico($cliente, $pet, $data);
        $idPorte = portePet($pet);
        header("location: ../agendamento.php?id=".encodeId($idAgendamento));

    } elseif($funcao == "A"){

        $sql = "UPDATE agendamento "
        ." SET id_funcionario   = $funcionario, "
            ." data             = '$data', " 
            ." horario_inicial  = '$horainicio', " 
            ." situacao         = $situacaoAgendamento "
        ." WHERE id_agendamento = ".decodeId($idAgendamento).";";

        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);

        $idPorte = portePet($pet);

        header("location: ../agendamento.php?id=".$idAgendamento."&add=true");

    } elseif($funcao == "D"){

        // Primeiro exclui as execuções do agendamento
        $sqlExecucao = "DELETE FROM execucao WHERE id_agendamento = $idAgendamento;";
        mysqli_query($conn, $sqlExecucao);

        // Depois exclui o agendamento
        $sqlAgendamento = "DELETE FROM agendamento WHERE id_agendamento = $idAgendamento;";
        mysqli_query($conn, $sqlAgendamento);

        mysqli_close($conn);

        header("location: ../agendamentos.php");
    }
?>
