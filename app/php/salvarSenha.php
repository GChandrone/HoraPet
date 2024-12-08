<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$senha         = $_POST['nSenha'];
$idFuncionario = $_SESSION['idFuncionario'];

include('funcoes.php');

// Gravação no BD
include('conexao.php');
$sql = "UPDATE funcionario "
        . "SET senha = '" . md5($senha) . "' "
        . "WHERE id_funcionario = " . $idFuncionario . ";";

// Executando a consulta
$result = mysqli_query($conn, $sql);

mysqli_close($conn);

// Verificando se a senha foi alterada com sucesso
if ($result) {
    $_SESSION['mensagem_sucesso'] = "Senha alterada com sucesso!";
} else {
    $_SESSION['erro_mensagem'] = "Erro ao alterar a senha.";
}

// Redirecionando para a página de perfil
header("location: ../perfil.php");

?>