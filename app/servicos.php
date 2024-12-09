<?php
session_start();
include('php/funcoes.php');
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
  <div class="wrapper">

    <!-- Navbar -->
    <?php include('partes/navbar.php'); ?>
    <!-- Fim Navbar -->

    <!-- Sidebar -->
    <?php
    $_SESSION['menu-n1'] = 'administrador';
    $_SESSION['menu-n2'] = 'servicos';
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
                      <h3 class="card-title">Serviços</h3>
                    </div>

                    <div class="col-3" align="right">
                      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#novoServicoModal">
                        Novo Serviço
                      </button>
                    </div>

                  </div>
                </div>



                <!-- /.card-header -->
                <div class="card-body">
                  <table id="tabela" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Valor Pequeno</th>
                        <th>Valor Médio</th>
                        <th>Valor Grande</th>
                        <th>Duração Pequeno</th>
                        <th>Duração Médio</th>
                        <th>Duração Grande</th>
                        <!-- <th>Descrição</th> -->
                        <th>Ativo</th>
                        <th>Ações</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php echo listaServico(); ?>

                    </tbody>

                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->

            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->

        <div class="modal fade modal-limpar" id="novoServicoModal">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header bg-success">
                <h4 class="modal-title">Novo Serviço</h4>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form id="formNovoServico" method="POST" action="php/salvarServico.php?funcao=I" enctype="multipart/form-data">
                  <div class="row">
                    <div class="col-12">
                      <div class="form-group">
                        <label for="iNome">Título do serviço:</label>
                        <input type="text" class="form-control" id="iTitulo" name="nTitulo" maxlength="50" required>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-12">
                      <div class="form-group">
                        <label>Descrição</label>
                        <textarea name="nDescricao" class="form-control" rows="3" placeholder="Escreva..."
                          maxlength="255"></textarea>
                      </div>
                    </div>
                  </div>

                  <h6><b>Configurações por porte</b></h6>

                  <div class="btn-group btn-group-toggle mb-2" data-toggle="buttons">
                    <label class="btn btn-outline-success active btn-sm" onclick="mostrarCampos('pequeno')">
                      <input type="radio" class="form-control" name="porte" id="portePequeno" autocomplete="off"
                        checked> Pequeno
                    </label>
                    <label class="btn btn-outline-success btn-sm" onclick="mostrarCampos('medio')">
                      <input type="radio" class="form-control" name="porte" id="porteMedio" autocomplete="off"> Médio
                    </label>
                    <label class="btn btn-outline-success btn-sm" onclick="mostrarCampos('grande')">
                      <input type="radio" class="form-control" name="porte" id="porteGrande" autocomplete="off"> Grande
                    </label>
                  </div>

                  <div id="camposPequeno" class="porte-campos">
                    <div class="row">
                      <div class="col-6">
                        <div class="form-group">
                          <label for="valorPequeno">Valor (Pequeno):</label>
                          <input type="text" class="form-control valor-real" id="valorPequeno" name="nValorPequeno" maxlength="9"
                            placeholder="R$ 0,00">
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-group">
                          <label for="duracaoPequeno">Duração (Pequeno):</label>
                          <input type="time" class="form-control" id="duracaoPequeno" name="nDuracaoPequeno">
                        </div>
                      </div>
                    </div>
                  </div>

                  <div id="camposMedio" class="porte-campos" style="display: none;">
                    <div class="row">
                      <div class="col-6">
                        <div class="form-group">
                          <label for="valorMedio">Valor (Médio):</label>
                          <input type="text" class="form-control valor-real" id="valorMedio" name="nValorMedio" maxlength="9"
                            placeholder="R$ 0,00">
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-group">
                          <label for="duracaoMedio">Duração (Médio):</label>
                          <input type="time" class="form-control" id="duracaoMedio" name="nDuracaoMedio">
                        </div>
                      </div>
                    </div>
                  </div>

                  <div id="camposGrande" class="porte-campos" style="display: none;">
                    <div class="row">
                      <div class="col-6">
                        <div class="form-group">
                          <label for="valorGrande">Valor (Grande):</label>
                          <input type="text" class="form-control valor-real" id="valorGrande" name="nValorGrande" maxlength="9"
                            placeholder="R$ 0,00">
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-group">
                          <label for="duracaoGrande">Duração (Grande):</label>
                          <input type="time" class="form-control" id="duracaoGrande" name="nDuracaoGrande">
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="custom-control custom-checkbox">
                    <input class="custom-control-input custom-control-input-success" type="checkbox" id="iAtivoServico"
                      name="nAtivoServico" checked>
                    <label for="iAtivoServico" class="custom-control-label">Serviço Ativo</label>
                  </div>

                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-success">Salvar</button>
                  </div>
                </form>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

      </section>
      <!-- /.content -->
    </div>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- JS -->
  <?php include('partes/js.php'); ?>
  <!-- Fim JS -->

  <script>

    <?php if (isset($_SESSION['erro_mensagem'])): ?>
      // Exibe a mensagem de erro utilizando o Toast

      Swal.fire({
        type: 'error',
        title: 'Atenção',
        text: '<?php echo $_SESSION['erro_mensagem']; ?>'
      });

      // Após exibir a mensagem, limpa a variável de sessão para não mostrar novamente
      <?php unset($_SESSION['erro_mensagem']); ?>
    <?php endif; ?>

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