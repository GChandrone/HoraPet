<?php
session_start();
include('php/funcoes.php');
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>HoraPet</title>

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
    $_SESSION['menu-n2'] = 'calendario';
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
                      <h3 class="card-title">Incluir Agendamento</h3>
                    </div>

                  </div>
                </div>

                <form method="POST" action="php/salvarAgendamento.php?funcao=I" enctype="multipart/form-data">

                  <!-- Incio Agendamento -->
                  <div class="card-body">
                    <div class="row">

                      <div class="col-6">
                        <div class="form-group">
                          <label for="iCliente">Cliente - Telefone:</label>
                          <select id="iCliente" name="nCliente" class="form-control clienteAjax" required>
                            <option value="">Selecione...</option>
                            <?php echo optionDonoPet(); ?>
                          </select>
                        </div>
                      </div>

                      <div class="col-6">
                        <div class="form-group">
                          <label for="iPet">Pet:</label>
                          <select name="nPet" id="iPet" class="form-control petAjax" required>
                            <option value="">Selecione...</option>
                          </select>
                        </div>
                      </div>

                      <div class="col-12">
                        <div class="form-group">
                          <label for="iFuncionario">Funcionário - Telefone:</label>
                          <select id="iFuncionario" name="nFuncionario" class="form-control" required>
                            <option value="">Selecione...</option>
                            <?php echo optionFuncionario(); ?>
                          </select>
                        </div>
                      </div>

                      <div class="col-4">
                        <div class="for8m-group">
                          <label for="iData">Data:</label>
                          <input type="date" class="form-control" id="iData" name="nData" required>
                        </div>
                      </div>

                      <div class="col-4">
                        <div class="form-group">
                          <label for="iHorarioInicio">Horário:</label>
                          <input type="time" class="form-control" id="iHorarioInicio" name="nHorarioInicio" required>
                        </div>
                      </div>

                      <div class="col-4">
                        <div class="form-group">
                          <label for="iSituacao">Situação:</label>
                          <select id="iSituacao" name="nSituacao" class="form-control" required>
                            <option value="1">Agendado</option>
                            <?php echo optionSituacao('I'); ?>
                          </select>
                        </div>
                      </div>

                    </div>
                  </div>

                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-success">Salvar</button>
                  </div>

                </form>
                <!-- Fim Agendamento -->

                <!-- Incio Servicos -->

                <!-- <div class="card card-success collapsed-card">
                  <div class="card-header pointer" data-card-widget="collapse">
                    <h3 class="card-title">Serviços</h3>
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-plus"></i>
                      </button>
                    </div>
                  </div>
                  <div class="card-body">
                    <table id="tabela" class="table table-bordered table-hover">
                      <thead>
                        <tr>
                          <th>Serviço</th>
                          <th>Valor</th>
                          <th>Duração</th>
                          <th>Situação</th>
                          <th class="text-center">
                            <button type="button" class="btn btn-success" data-toggle="modal"
                              data-target="#novaExecucaoModal">
                              +
                            </button>
                          </th>
                        </tr>
                      </thead>
                      <tbody>

                        <?php //echo listaRaca();
                        ?>

                      </tbody>

                    </table>

                    <div class="modal fade" id="novaExecucaoModal">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header bg-success">
                            <h4 class="modal-title">Nova Serviço</h4>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">

                            <div class="row">
                              <div class="col-8">
                                <div class="form-group">
                                  <label for="iNome">Nome:</label>
                                  <input type="text" class="form-control" id="iNome" name="nNome" maxlength="50"
                                    required>
                                </div>
                              </div>

                              <div class="col-4">
                                <div class="form-group">
                                  <label for="iNome">Tipo do Pet:</label>
                                  <select name="nTipoPet" class="form-control" required>
                                    <option value="">Selecione...</option>
                                    <?php echo optionTipoPet("I"); ?>
                                  </select>
                                </div>
                              </div>

                            </div>

                          </div>

                        </div>
                         /.modal-content 
                      </div>
                       /.modal-dialog 
                    </div>
                     /.modal 

                  </div>
                   /.card-body 
                </div>
                Fim Servicos -->

                <!-- /.card-body -->
              </div>
              <!-- /.card -->

            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->

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
    $(function() {
      $('#tabela').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": false,
        "autoWidth": false,
        "responsive": true,
      });
    });
  </script>

</body>

</html>