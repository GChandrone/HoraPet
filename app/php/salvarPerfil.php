<?php
    
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    $nome          = $_POST['nNome'];
    $email         = $_POST['nEmail'];
    $telefone      = $_POST['nTelefone'];
    $idFuncionario = $_SESSION['idFuncionario'];

    include('funcoes.php');

    //Gravação no BD
    include('conexao.php');
    $sql = "UPDATE funcionario "
            ." SET nome     = '".$nome."', "
            ."     email    = '".$email."', "
            ."     telefone = '".$telefone."' "
            ." WHERE id_funcionario = ".$idFuncionario.";";                                 
    
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    if ($result) {
        // Atualizar as variáveis de sessão com os novos dados
        $_SESSION['NomeFuncionario'] = $nome;
        $_SESSION['EmailFuncionario'] = $email;
        $_SESSION['TelefoneFuncionario'] = $telefone;

        $_SESSION['mensagem_sucesso'] = "Informações atualizadas com sucesso!";
    } else {
        $_SESSION['erro_mensagem'] = "Erro ao atualizar informações.";
    }

    // Redirecionando para a página de perfil
    // header("location: ../perfil.php");
    header("location: ../perfil.php");

?>