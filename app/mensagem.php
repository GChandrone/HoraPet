<?php
session_start();

// Verificar se há mensagem de erro
if (!isset($_SESSION['erro_mensagem'], $_SESSION['erro_tipo'])) {
    header('Location: index.php'); // Redireciona caso acessado diretamente
    exit();
}

// Recuperar a mensagem e o tipo de erro
$mensagem = $_SESSION['erro_mensagem'];
$tipoErro = $_SESSION['erro_tipo'];

// Definir a URL de redirecionamento com base no tipo de erro
$redirectUrl = $tipoErro === "acesso_negado" 
    ? ($_SESSION['redirect_url'] ?? 'calendario.php') 
    : 'index.php';

// Limpar as variáveis da sessão
unset($_SESSION['erro_mensagem'], $_SESSION['erro_tipo'], $_SESSION['redirect_url']);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <link rel="icon" type="image/png" href="../landing/images/patinhaVerde.png">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Hora Pet</title>

  <!-- CSS -->
  <?php include('partes/css.php'); ?>
  <!-- Fim CSS -->

</head>
<body class="hold-transition sidebar-mini layout-fixed">

<!-- JS -->
<?php include('partes/js.php'); ?>
<!-- Fim JS -->

<script>
    Swal.fire({
        type: 'error',
        title: 'Acesso Negado',
        text: '<?php echo $mensagem; ?>'
    }).then(() => {
        window.location.href = '<?php echo $redirectUrl; ?>';
    });
</script>

</body>
</html>
