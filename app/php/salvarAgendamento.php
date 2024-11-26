<?php
    include('funcoes.php');

    $cliente       = $_POST["nCliente"       ];
    $pet           = $_POST["nPet"           ];
    $funcionario   = $_POST["nFuncionario"   ];
    $data          = $_POST["nData"          ];
    $horainicio    = $_POST["nHorarioInicio" ];
    $situacao      = $_POST["nSituacao"      ];
    $funcao        = $_GET ["funcao"         ];

    include("conexao.php");

    //Validar se é Inclusão ou Alteração
    if($funcao == "I"){

        //INSERT
        $sql = "INSERT INTO agendamento (horario_inicial,horario_final,data,situacao,id_pet,id_cliente,id_funcionario) "
        ." VALUES ('$horainicio','00:00:00','$data',$situacao,$pet,$cliente,$funcionario);";  

    }elseif($funcao == "A"){

       //NÃO VAI TER OPÇÃO DE EDITAR O AGENDAMENTO

    }elseif($funcao == "D"){
        //DELETE
        $sql = "DELETE FROM pet "
                ." WHERE id_pet = $idPet;";
    }

    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    $idAgendamento = idAgendamentoServico($cliente,$pet,$data);

    header("location: ../agendamento.php?id=".$idAgendamento);

?>