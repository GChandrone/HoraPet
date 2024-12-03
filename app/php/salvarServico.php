<?php

    include('funcoes.php');

    $nome           = $_POST["nTitulo"        ];
    $valorPequeno   = $_POST["nValorPequeno"  ];
    $duracaoPequeno = $_POST["nDuracaoPequeno"];
    $valorMedio     = $_POST["nValorMedio"    ];
    $duracaoMedio   = $_POST["nDuracaoMedio"  ];
    $valorGrande    = $_POST["nValorGrande"   ];
    $duracaoGrande  = $_POST["nDuracaoGrande" ];
    $descricao      = $_POST["nDescricao"     ];
    $funcao         = $_GET ["funcao"         ];
    $idServico      = $_GET ["codigo"         ];

    $valorPequeno = desformatarMoeda($valorPequeno);
    $valorMedio   = desformatarMoeda($valorMedio);
    $valorGrande  = desformatarMoeda($valorGrande);

    if($_POST["nAtivoServico"] == "on") $ativo = "1"; else $ativo = "0";

    include("conexao.php");

    if (!$conn) {
        die("Falha na conexão: " . mysqli_connect_error());
    }
    
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Habilitar modo de exceção
    
    session_start(); // Certifique-se de que a sessão foi iniciada

    //Validar se é Inclusão ou Alteração
    if($funcao == "I"){

        //INSERT
        $sql = "INSERT INTO servico (nome,valor_pequeno,valor_medio,valor_grande,duracao_pequeno,duracao_medio,duracao_grande,descricao,ativo) "
             ." VALUES ("."'$nome',$valorPequeno,$valorMedio,$valorGrande,'$duracaoPequeno','$duracaoMedio','$duracaoGrande','$descricao',$ativo);";

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
        $sql = "DELETE FROM servico "
                ." WHERE id_servico = $idServico;";

        // Tentativa de execução do DELETE
        try {
            $result = mysqli_query($conn, $sql);
        } catch (mysqli_sql_exception $e) {
            // Tratamento para erro de chave estrangeira
            if ($e->getCode() == 1451) {
                $errorMessage = "Este serviço não pode ser excluído porque já está associado a um agendamento.";
            } else {
                $errorMessage = "Erro inesperado: " . $e->getMessage();
            }

            // Fecha a conexão e armazena a mensagem de erro na sessão
            mysqli_close($conn);
            $_SESSION['erro_mensagem'] = $errorMessage;

            // Redireciona para a página de raças
            header("location: ../servicos.php");
            exit; // Interrompe a execução do script
        } 
    }

    $result = mysqli_query($conn,$sql);

    if (!$result) {
        die('Erro na execução do SQL: ' . mysqli_error($conn)); // Verifique erros na execução da query
    }

    mysqli_close($conn);

    header("location: ../servicos.php");

?>