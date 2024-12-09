<?php

include('funcoes.php');

// Obter os dados do formulário
$nome             = $_POST["nNome"           ];
$email            = $_POST["nEmail"          ];
$senha            = $_POST["nSenha"          ];
$tipoFuncionario  = $_POST["nTipoFuncionario"];
$telefone         = $_POST["nTelefone"       ];
$dataNascimento   = $_POST["nData"           ];
$funcao           = $_GET ["funcao"          ];
$idFuncionario    = $_GET ["codigo"          ];

if($_POST["nAtivoFuncionario"] == "on") $ativo = "1"; else $ativo = "0";

// Depuração - Verifique os valores recebidos
var_dump($nome, $email, $senha, $tipoFuncionario, $telefone, $dataNascimento, $ativo, $funcao, $idFuncionario);

include("conexao.php");

if (!$conn) {
    die("Falha na conexão: " . mysqli_connect_error());
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Habilitar modo de exceção

session_start();

// Validar se é Inclusão ou Alteração
if ($funcao == "I") {
    // INSERT
    $sql = "INSERT INTO funcionario (nome, tipo_funcionario, data_nascimento, telefone, email, senha, ativo) "
         ." VALUES ('$nome',$tipoFuncionario,'$dataNascimento','$telefone','$email','".md5($senha)."','$ativo');"; 

} elseif ($funcao == "A") {
    // UPDATE
    
    $sql = "UPDATE funcionario "
                ." SET nome             = '$nome', "
                    ." data_nascimento  = '$dataNascimento', "
                    ." tipo_funcionario =  $tipoFuncionario, "
                    ." telefone         = '$telefone', "
                    ." email            = '$email', " 
                    ." ativo            =  $ativo "
                ." WHERE id_funcionario = $idFuncionario;";
    
} elseif ($funcao == "D") {
    //DELETE
    $sql = "DELETE FROM funcionario WHERE id_funcionario = $idFuncionario;";

    // Tentativa de execução do DELETE
    try {
        $result = mysqli_query($conn, $sql);
    } catch (mysqli_sql_exception $e) {
        // Tratamento para erro de chave estrangeira
        if ($e->getCode() == 1451) {
            $errorMessage = "Este funcionário não pode ser excluído porque já está associado a um agendamento.";
        } else {
            $errorMessage = "Erro inesperado: " . $e->getMessage();
        }

        // Fecha a conexão e armazena a mensagem de erro na sessão
        mysqli_close($conn);
        $_SESSION['erro_mensagem'] = $errorMessage;

        // Redireciona para a página de raças
        header("location: ../funcionarios.php");
        exit; // Interrompe a execução do script
    }
}

$result = mysqli_query($conn,$sql);

if (!$result) {
    die('Erro na execução do SQL: ' . mysqli_error($conn)); // Verifique erros na execução da query
}

mysqli_close($conn);

header("location: ../funcionarios.php");

?>
