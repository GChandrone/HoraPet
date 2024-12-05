<?php

include('funcoes.php');

// Obter os dados do formulário
$nome             = $_POST["nNome"];
$email            = $_POST["nEmail"];
$senha            = $_POST["nSenha"];
$tipoFuncionario  = $_POST["nTipoFuncionario"];
$telefone         = $_POST["nTelefone"];
$dataNascimento   = $_POST["nData"];
$funcao           = isset($_GET["funcao"]) ? $_GET["funcao"] : '';
$idFuncionario    = isset($_GET["codigo"]) ? $_GET["codigo"] : null;

// Definir o status 'ativo' dependendo do valor do checkbox
$ativo = ($_POST["nAtivoFuncionario"] == "on") ? "1" : "0";

// Depuração - Verifique os valores recebidos
var_dump($nome, $email, $senha, $tipoFuncionario, $telefone, $dataNascimento, $ativo, $funcao, $idFuncionario);

include("conexao.php");

if (!$conn) {
    die("Falha na conexão: " . mysqli_connect_error());
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Habilitar modo de exceção

// Verificar se a sessão foi iniciada, caso contrário, iniciar a sessão
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verificar se a função foi especificada
if ($funcao == "") {
    die("Erro: Função não especificada.");
}

// Validar se é Inclusão ou Alteração
if ($funcao == "I") {
    // Inclusão
    $sql = "INSERT INTO funcionario (nome, tipo_funcionario, data_nascimento, telefone, email, ativo";

    // Se a senha foi fornecida, inclui ela na query
    if (!empty($senha)) {
        $sql .= ", senha";  // Inclui a senha no campo da query
    }

    $sql .= ") VALUES ('" . mysqli_real_escape_string($conn, $nome) . "', '" 
                     . mysqli_real_escape_string($conn, $tipoFuncionario) . "', '" 
                     . mysqli_real_escape_string($conn, $dataNascimento) . "', '" 
                     . mysqli_real_escape_string($conn, $telefone) . "', '" 
                     . mysqli_real_escape_string($conn, $email) . "', '" 
                     . mysqli_real_escape_string($conn, $ativo) . "'";

    // Se a senha foi fornecida, inclui ela no valor da query
    if (!empty($senha)) {
        $sql .= ", '" . md5(mysqli_real_escape_string($conn, $senha)) . "'";
    }

    $sql .= ");";  // Finaliza a query de inserção

} elseif ($funcao == "A") {
    // Alteração
    $sql = "UPDATE funcionario "
           . "SET nome = '" . mysqli_real_escape_string($conn, $nome) . "', "
           . "tipo_funcionario = '" . mysqli_real_escape_string($conn, $tipoFuncionario) . "', "
           . "data_nascimento = '" . mysqli_real_escape_string($conn, $dataNascimento) . "', "
           . "telefone = '" . mysqli_real_escape_string($conn, $telefone) . "', "
           . "email = '" . mysqli_real_escape_string($conn, $email) . "', "
           . "ativo = '" . mysqli_real_escape_string($conn, $ativo) . "'";

    // Se a senha foi fornecida, inclui ela na query
    if (!empty($senha)) {
        $sql .= ", senha = '" . md5(mysqli_real_escape_string($conn, $senha)) . "'";  // Inclui a senha criptografada (md5) na query de update
    }

    $sql .= " WHERE id_funcionario = '" . mysqli_real_escape_string($conn, $idFuncionario) . "';";  // Condição WHERE para atualizar o funcionário correto

} elseif ($funcao == "D") {
    // Exclusão
    $sql = "DELETE FROM funcionario WHERE id_funcionario = '" . mysqli_real_escape_string($conn, $idFuncionario) . "';";
}

// Tentar executar a consulta
try {
    echo $sql;  // Depuração - Imprimir a consulta SQL gerada
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        throw new mysqli_sql_exception("Erro na execução do SQL: " . mysqli_error($conn));
    }
} catch (mysqli_sql_exception $e) {
    die($e->getMessage());
}

mysqli_close($conn);

// Redirecionar após o processo
header("location: ../funcionarios.php");

?>
