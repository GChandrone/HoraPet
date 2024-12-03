<?php

include('funcoes.php');

$nome        = $_POST["nNome"];
$tipoPet     = $_POST["nTipoPet"];
$funcao      = $_GET["funcao"];
$idRaca      = $_GET["codigo"];

include("conexao.php");

if (!$conn) {
    die("Falha na conexão: " . mysqli_connect_error());
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Habilitar modo de exceção

session_start(); // Certifique-se de que a sessão foi iniciada

// Validar se é Inclusão ou Alteração
if ($funcao == "I") {
    // INSERT
    $sql = "INSERT INTO raca (nome, tipo_pet) VALUES ('$nome', $tipoPet)";
} elseif ($funcao == "A") {
    // UPDATE
    $sql = "UPDATE raca SET nome = '$nome', tipo_pet = $tipoPet WHERE id_raca = $idRaca";
} elseif ($funcao == "D") {
    // DELETE
    $sql = "DELETE FROM raca WHERE id_raca = $idRaca";

    // Tentativa de execução do DELETE
    try {
        $result = mysqli_query($conn, $sql);
    } catch (mysqli_sql_exception $e) {
        // Tratamento para erro de chave estrangeira
        if ($e->getCode() == 1451) {
            $errorMessage = "Esta raça não pode ser excluída porque já está associada a um pet.";
        } else {
            $errorMessage = "Erro inesperado: " . $e->getMessage();
        }

        // Fecha a conexão e armazena a mensagem de erro na sessão
        mysqli_close($conn);
        $_SESSION['erro_mensagem'] = $errorMessage;

        // Redireciona para a página de raças
        header("location: ../racas.php");
        exit; // Interrompe a execução do script
    }
}

// Caso contrário, executa normalmente
$result = mysqli_query($conn, $sql);

if (!$result) {
    die('Erro na execução do SQL: ' . mysqli_error($conn)); // Verifique erros na execução da query
}
mysqli_close($conn);

// Redireciona para a página de raças
header("location: ../racas.php");

?>
