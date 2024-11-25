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
        $sql = "INSERT INTO agendamento (horario_inicial,horario_final,data,situacao,id_pet,id_cliente) "
        ." VALUES ('$horainicio','00:00:00','$data',$situacao,$pet,$cliente);";  

    }elseif($funcao == "A"){

        $sql = "UPDATE agendamento "
                ." SET nome       = '$nome', "
                    ." id_cliente =  $dono, "
                    ." tipo_pet   =  $tipoPet, "
                    ." id_raca    =  $raca, "
                    ." altura     =  $altura, "
                    ." peso       =  $peso, "
                    ." porte      =  $porte, "
                    ." ativo      =  $ativo "
                ." WHERE id_pet   =  $idPet;";

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