<?php
session_start();
include('php/funcoes.php');

  // Todos tem acesso
  verificarAcesso(['Administrador', 'Atendente', 'Est']);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Hora Pet</title>

  <!-- CSS -->
  <?php include('partes/css.php'); ?>
  <!-- Fim CSS -->

</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Navbar -->
    <?php include('partes/navbar.php'); ?>
    <!-- Fim Navbar -->

    <!-- Sidebar -->
    <?php
    $_SESSION['menu-n1'] = '';
    $_SESSION['menu-n2'] = 'perfil';
    include('partes/sidebar.php');
    ?>
    <!-- Fim Sidebar -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <!-- Espaço -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <div class="row">
                    <div class="col-9">
                      <h3 class="card-title">Meu Perfil</h3>
                    </div>
                    <div class="col-3" align="right">
                      <a href="#modalAlterarSenha" class="btn btn-warning" data-toggle="modal" data-toggle="tooltip">
                        Alterar Senha
                      </a>
                    </div>
                  </div>
                </div>

                <!-- /.card-header -->
                <div class="card-body">
                  <form method="POST" action="php/salvarPerfil.php" enctype="multipart/form-data">
                    <div class="card-body">
                      <div class="row">

                        <!-- Informações de Perfil -->
                        <div class="col-12">
                          <div class="row">
                            <div class="col-6">
                              <div class="form-group">
                                <label for="iNome">Nome</label>
                                <input name="nNome" id="iNome" type="text" maxlength="50" class="form-control"
                                  value="<?php echo htmlspecialchars($_SESSION['NomeFuncionario'] ?? ''); ?>" required>
                              </div>
                            </div>

                            <div class="col-6">
                              <div class="form-group">
                                <label>Nível de Acesso</label>
                                <!-- Usando a função descrTipoFuncionario para exibir o nome do cargo -->
                                <input readonly name="nNivelAcesso" type="text" maxlength="50" class="form-control"
                                  value="<?php echo htmlspecialchars(descrTipoFuncionario($_SESSION['tipoFuncionario'] ?? '')); ?>">
                              </div>
                            </div>

                            <div class="col-6">
                              <div class="form-group">
                                <label>E-mail</label>
                                <input type="email" class="form-control" name="nEmail" id="iEmail" maxlength="150"
                                  value="<?php echo htmlspecialchars($_SESSION['EmailFuncionario'] ?? ''); ?>">
                              </div>
                            </div>

                            <div class="col-6">
                              <div class="form-group">
                                <label id="">Telefone</label>
                                <input type="iTelefone" class="form-control telefone-formatado" name="nTelefone" maxlength="16"
                                  id="iTelefone"
                                  value="<?php echo htmlspecialchars($_SESSION['TelefoneFuncionario'] ?? ''); ?>">
                              </div>
                            </div>
                          </div>
                        </div> <!-- Fim Informações de Perfil -->

                      </div> <!-- /.row -->
                    </div> <!-- /.card-body -->

                    <div class="card-action text-right">
                      <a href="perfil.php" class="btn btn-danger" data-toggle="tooltip" title="Cancelar a operação">
                        <span>Cancelar</span>
                      </a>
                      <input type="submit" class="btn btn-success" value="Salvar" data-toggle="tooltip"
                        title="Salvar as alterações no perfil">
                    </div>
                  </form>
                </div> <!-- /.card-body -->
              </div> <!-- /.card -->
            </div> <!-- /.col -->
          </div> <!-- /.row -->
        </div> <!-- /.container-fluid -->
      </section> <!-- /.content -->
    </div> <!-- /.content-wrapper -->


    <div class="modal fade modal-limpar" id="modalAlterarSenha">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-warning">
            <h4 class="modal-title">Alterar Senha</h4>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="POST" action="php/salvarSenha.php"
              enctype="multipart/form-data">
              <div class="row">
                <div class="col-12">
                  <div class="form-group">
                    <label for="iSenha">Nova Senha:</label>
                    <input type="password" class="form-control" id="iSenha"
                      name="nSenha" maxlength="20" required>  
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-success">Salvar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div> <!-- ./wrapper -->

  <!-- JS -->
  <?php include('partes/js.php'); ?>
  <!-- Fim JS -->

  <script>

    <?php if (isset($_SESSION['erro_mensagem'])){ ?>
      // Exibe a mensagem de erro utilizando o Toast
      
      Swal.fire({
            type: 'error',
            title: 'Erro',
            text: '<?php echo $_SESSION['erro_mensagem']; ?>'
      });
      // Após exibir a mensagem, limpa a variável de sessão para não mostrar novamente
      <?php unset($_SESSION['erro_mensagem']); ?>
    <?php }else{ ?> 

      Swal.fire({
            type: 'success',
            title: 'Sucesso',
            text: '<?php echo $_SESSION['mensagem_sucesso']; ?>'
      });
      // Após exibir a mensagem, limpa a variável de sessão para não mostrar novamente
      <?php unset($_SESSION['mensagem_sucesso']); ?>

    <?php }?> 

    $(function () {
      $('#tabela').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
  </script>

</body>

</html>