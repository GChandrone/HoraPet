<?php 
  session_start();
  include('php/funcoes.php');
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
    $_SESSION['menu-n1'] = 'administrador';
    $_SESSION['menu-n2'] = 'agendamento';
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
                    <h3 class="card-title">Agendamentos</h3>
                  </div>
                  
                  <div class="col-3" align="right">
                    <a href="agendamento.php" class="btn btn-success">
                      Novo Agendamento
                    </a>
                  </div>

                </div>
              </div>

              

              <!-- /.card-header -->
              <div class="card-body">
                <table id="tabela" class="table table-bordered table-hover tabela">
                  <thead>
                  <tr>
                      <th>ID</th>
                      <th>Foto</th>
                      <th>Nome</th>
                      <th>Tipo</th>
                      <th>Raça</th>
                      <th>Porte</th>
                      <th>Dono</th>
                      <th>Ativo</th>
                      <th>Ações</th>
                  </tr>
                  </thead>
                  <tbody>

                  <?php echo listaPet(); ?>
                  
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

      <div class="modal fade" id="novoPetModal">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header bg-success">
              <h4 class="modal-title">Novo Pet</h4>
              <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="POST" action="php/salvarPet.php?funcao=I" enctype="multipart/form-data">              
                
                <div class="row">
                  <div class="col-6">
                    <div class="form-group">
                      <label for="iNome">Nome:</label>
                      <input type="text" class="form-control" id="iNome" name="nNome" maxlength="50" required>
                    </div>
                  </div>

                  <div class="col-6">
                    <div class="form-group">
                      <label for="iDono">Dono - Telefone:</label>
                      <select id="iDono" name="nDono" class="form-control" required>
                        <option value="">Selecione...</option>
                        <?php echo optionDonoPet();?>
                      </select>
                    </div>
                  </div>


                  <div class="col-6">
                    <div class="form-group">
                      <label>Tipo do Pet:</label>
                      <select id="iTipoPetAjaxIncluir" name="nTipoPet" class="form-control tipoPetAjax" required>
                        <option value="">Selecione...</option>
                        <?php echo optionTipoPet("I");?>
                      </select>
                    </div>
                  </div>

                  <div class="col-6">
                    <div class="form-group">
                      <label for="iRacaAjax">Raça:</label>
                      <select name="nRacaAjax" id="iRacaAjax" class="form-control racaAjax" required>
                        <option value="">Selecione...</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-3">
                    <div class="form-group">
                      <label for="iAltura">Altura (cm):</label>
                      <input type="number" class="form-control" id="iAltura" name="nAltura" required>
                    </div>
                  </div>

                  <div class="col-3">
                    <div class="form-group">
                      <label for="iPeso">Peso (kg):</label>
                      <input type="number" class="form-control" id="iPeso" name="nPeso" required>
                    </div>
                  </div>

                  <div class="col-6">
                    <div class="form-group">
                      <label for="iPorte">Porte:</label>
                      <input type="text" class="form-control" id="iPorte" name="nPorte" readonly required>
                    </div>
                  </div>

                  <div class="col-12"> 
                    <div class="form-group">
                      <label for="iFoto">Foto:</label>
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="iFoto" name="nFoto" accept="image/*">
                        <label class="custom-file-label" for="customFile">Nenhum arquivo escolhido</label>
                      </div>
                    </div>
                  </div> 
                
                </div>
                
                <div class="custom-control custom-checkbox">
                  <input class="custom-control-input custom-control-input-success" type="checkbox" id="iAtivoPet" name="nAtivoPet" checked>
                  <label for="iAtivoPet" class="custom-control-label">Pet Ativo</label>
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

  $(function () {
    bsCustomFileInput.init();
  });
</script>

</body>
</html>
