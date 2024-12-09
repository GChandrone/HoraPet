<?php
// Inicia a sessão se não estiver ativa
if(session_status() !== PHP_SESSION_ACTIVE){
    session_start();
}

include("funcoes.php");

$_SESSION['logado'] = 0;

// Pegando os valores dos campos do formulário
$email = stripslashes($_POST["nEmail"]);
$senha = stripslashes($_POST["nSenha"]);

include("conexao.php");

// Consulta ao banco de dados
$sql = "SELECT * FROM funcionario WHERE email = '$email' AND senha = md5('$senha');";
$resultLogin = mysqli_query($conn, $sql);
mysqli_close($conn);

// Verifica se encontrou um resultado
if (mysqli_num_rows($resultLogin) > 0) {
    // Login bem-sucedido, mas verifica se o funcionário está ativo
    $coluna = mysqli_fetch_assoc($resultLogin);
    
    if ($coluna['ativo'] == 1) {
        // Funcionário ativo, loga o usuário
        $_SESSION['tipoFuncionario']        = $coluna['tipo_funcionario'];
        $_SESSION['descTipoFuncionario']    = descrTipoFuncionario($coluna['tipo_funcionario']);
        $_SESSION['logado']                 = 1;
        $_SESSION['EmailFuncionario']       = $coluna['email'];
        $_SESSION['TelefoneFuncionario']    = $coluna['telefone'];
        $_SESSION['idFuncionario']          = $coluna['id_funcionario'];
        $_SESSION['NomeFuncionario']        = $coluna['nome'];
        $_SESSION['Ativo']                  = $coluna['ativo'];
        

        // Redireciona para a página de calendário
        header('location: ../calendario.php');
        exit; // Evita a execução de código após o redirecionamento
    } else {
        // Funcionário desativado
        $_SESSION['login_erro'] = 'Seu usuário está desativado. Entre em contato com o administrador.';
        
        // Redireciona de volta para a página de login
        header('location: ../');
        exit; // Evita a execução de código após o redirecionamento
    }
} else {
    // Login falhou - salva a mensagem de erro na sessão
    $_SESSION['login_erro'] = 'E-mail ou senha incorretos. Tente novamente.';
    
    // Redireciona de volta para a página de login
    header('location: ../');
    exit; // Evita a execução de código após o redirecionamento
}
?>
