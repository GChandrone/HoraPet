<?php
    session_start();

    // Defina a mensagem de erro se necessário
    $_SESSION['login_erro'] = 'Você foi desconectado. Faça login novamente para continuar.';

    // Destruir a sessão e redirecionar
    $_SESSION['logado'] = 0;
    session_destroy();

    // Redireciona para a página inicial
    header('location: ../');
    exit;
?>
