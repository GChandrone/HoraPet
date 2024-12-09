<?php 
  session_start();
  include('php/funcoes.php');

  $_SESSION['origem'] = 'agendamentos.php';

  // Todos tem Acesso
  verificarAcesso(['Administrador', 'Atendente', 'Esteticista Pet']);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Hora Pet</title>
  <link rel="icon" type="image/png" href="../landing/images/patinhaVerde.png">
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
                  
                  <?php if ($_SESSION['descTipoFuncionario'] != 'Esteticista Pet') { ?>
                    <div class="col-3" align="right">
                    <a href="agendamento.php" class="btn btn-success">
                      Novo Agendamento
                    </a>
                  </div>
                  <?php }?>

                </div>
              </div>

              

              <!-- /.card-header -->
              <div class="card-body">
                <table id="tabela" class="table table-bordered table-hover tabela">
                  <thead>
                  <tr>
                      <th>Foto</th>
                      <th>Pet</th>
                      <th>Dono</th>
                      <th>Funcionário</th>
                      <th>Data</th>
                      <th>Horário</th>
                      <th>Valor</th>
                      <th>Situação</th>
                      <th>Ações</th>
                  </tr>
                  </thead>
                  <tbody>

                  <?php echo listaAgendamento($_SESSION['idFuncionario'], $_SESSION['descTipoFuncionario']); ?>
                  
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
