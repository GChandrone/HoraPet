<?php
    session_start();

    // Destruir a sessão e redirecionar
    $_SESSION['logado'] = 0;
    session_destroy();

    // Verifica se existe uma mensagem de erro na sessão
    $login_erro = '';
    if (isset($_SESSION['login_erro'])) {
        $login_erro = $_SESSION['login_erro'];
        unset($_SESSION['login_erro']); // Limpa a mensagem após exibi-la
    }
?>
<!DOCTYPE HTML>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Hora Pet</title>
    <!-- CSS -->
    <?php include('partes/csslogin.php'); ?>
</head>
<body class="img js-fullheight">
    <!-- Mensagem de erro -->
    <div class="error-message">
        <?php echo $login_erro; ?> <!-- Exibe a mensagem de erro aqui -->
    </div>

    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center mb-5"></div>
            </div>

            <form method="POST" action="php/validaLogin.php">
                <div class="TelaDeLogin">
                    <div class="wrapper">
                        <div class="card-switch">
                            <div class="flip-card__inner">
                                <!-- Tela de Login -->
                                <div class="flip-card__front">
                                    <div class="row justify-content-center">
                                        <div class="col-md-6 col-lg-4">
                                            <div class="login-wrap p-0">
                                                <div class="fundotransp">
                                                    <h3 class="mb-4 text-center">Seja bem-vindo</h3>
                                                    <form action="#" class="signin-form">
                                                        <div class="form-group">
                                                            <input type="email" id="iEmail" name="nEmail"
                                                                class="form-control" placeholder="Email" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <input id="password-field" type="password" id="iSenha"
                                                                name="nSenha" class="form-control" placeholder="Senha"
                                                                required>
                                                            <span toggle="#password-field"
                                                                class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                                        </div>
                                                        <div class="form-group">
                                                            <button type="submit"
                                                                class="form-control btn btn-primary submit px-3"
                                                                id="loginButton">Entrar</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <script src="dist/js/jquery.min.js"></script>
    <script src="dist/js/popper.js"></script>
    <script src="dist/js/bootstrap.min.js"></script>
    <script src="dist/js/main.js"></script>

    <script>
        window.onload = function() {
            // Usando fetch para garantir que a imagem seja carregada corretamente
            fetch('dist/img/backiee-103563.jpg')
            .then(response => response.blob()) // Converte a imagem para um objeto Blob
            .then(imageBlob => {
                // Cria uma URL temporária para a imagem
                const imageObjectURL = URL.createObjectURL(imageBlob);
                var imgElement = document.querySelector('.img');
                imgElement.style.backgroundImage = `url(${imageObjectURL})`; // Define a imagem como fundo
            })
            .catch(error => {
                console.error('Erro ao carregar a imagem:', error);
            });
        }

        // Exibe a mensagem de erro suavemente se ela estiver definida
        $(document).ready(function() {
            <?php if ($login_erro): ?>
                $(".error-message").addClass("show"); // Isso exibe a mensagem de erro
            <?php endif; ?>
        });
    </script>
</body>
</html>
