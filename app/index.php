<!DOCTYPE HTML>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <title>PHP</title>

    <!-- CSS -->
    <?php include('partes/csslogin.php'); ?>
    <!-- Fim CSS -->


</head>

<body class="img js-fullheight" style="background-image: url(dist/img/backiee-103563.jpg);">
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
                                                                <!-- Botão para enviar o formulário de login -->
                                                                <div class="form-group">
                                                                    
                                                                    <button type="submit"
                                                                        class="form-control btn btn-primary submit px-3"
                                                                        id="loginButton">Entrar</button>
                                                                </div>

                                                                <!-- Botão para virar o card para cadastro -->
                                                                <button id="flipButton"
                                                                    class="btn btn-primary">Esqueceu a senha</button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                
                                        

                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                        </section>

                        <script src="js/jquery.min.js"></script>
                        <script src="js/popper.js"></script>
                        <script src="js/bootstrap.min.js"></script>
                        <script src="js/main.js"></script>

                        <script>
                            // JavaScript para controlar a rotação do card
                            const flipButton = document.getElementById('flipButton');
                            const backButton = document.getElementById('backButton');
                            const flipCardInner = document.querySelector('.flip-card__inner');

                            flipButton.addEventListener('click', () => {
                                flipCardInner.classList.add('flipped'); // Ativa rotação para cadastro
                            });

                            backButton.addEventListener('click', () => {
                                flipCardInner.classList.remove('flipped'); // Remove a rotação e volta para login
                            });
                        </script>

    </form>

</body>

</html>