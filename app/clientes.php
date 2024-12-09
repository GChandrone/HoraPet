<?php 
  session_start();
  include('php/funcoes.php');

  // O Administrador e o Atendente tem acesso
  verificarAcesso(['Administrador', 'Atendente']);
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
    $_SESSION['menu-n2'] = 'clientes';
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
                    <h3 class="card-title">Clientes</h3>
                  </div>
                  
                  <div class="col-3" align="right">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#novoClienteModal">
                      Novo Cliente
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
                      <th>Telefone</th>
                      <!-- <th>Email</th> -->
                      <th>UF</th>
                      <th>Cidade</th> 
                      <th>Bairro</th>                
                      <th>Endereço</th>
                      <th>Número</th>
                      <th>Ativo</th>
                      <th>Ações</th>
                  </tr>
                  </thead>
                  <tbody>

                  <?php echo listaCliente(); ?>
                  
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

      <div class="modal fade modal-limpar" id="novoClienteModal">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header bg-success">
              <h4 class="modal-title">Novo Cliente</h4>
              <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="POST" action="php/salvarCliente.php?funcao=I" enctype="multipart/form-data">              
                
                <div class="row">
                  <div class="col-8">
                    <div class="form-group">
                      <label for="iNome">Nome:</label>
                      <input type="text" class="form-control" id="iNome" name="nNome" maxlength="50" required>
                    </div>
                  </div>

                  <div class="col-4">
                    <div class="form-group">
                      <label for="iTelefone">Telefone:</label>
                      <input type="text" class="form-control telefone-formatado" id="iTelefone" name="nTelefone" maxlength="16" required>
                    </div>
                  </div>


                  <div class="col-12">
                    <div class="form-group">
                      <label for="iEmail">E-mail:</label>
                      <input type="email" class="form-control" id="iEmail" name="nEmail" maxlength="150" required>
                    </div>
                  </div>

                  <div class="col-3">
                    <div class="form-group">
                      <label>CEP</label>
                      <input name="nCEP" id="iCEP" type="text" class="form-control cep" maxlength="9" required>
                    </div>
                  </div>
                  
                  <div class="col-9">
                    <div class="form-group">
                      <label>Endereço</label>
                      <input name="nEndereco" id="iEndereco" type="text" class="form-control" maxlength="150" required>
                    </div>
                  </div>

                  <div class="col-3">
                    <div class="form-group">
                      <label>Número</label>
                      <input name="nNumero" id="iNumero" type="text" maxlength="5" class="form-control">
                    </div>
                  </div>

                  <div class="col-9">
                    <div class="form-group">
                      <label>Complemento</label>
                      <input name="nComplemento" id="iComplemento" type="text" maxlength="100" class="form-control">
                    </div>
                  </div>

                  <div class="col-5">
                    <div class="form-group">
                      <label>Bairro</label>
                      <input name="nBairro" id="iBairro" type="text" class="form-control" maxlength="100" required>
                    </div>
                  </div>
                  
                  <div class="col-5">
                    <div class="form-group">
                      <label>Cidade</label>
                      <input name="nCidade" id="iCidade" type="text" class="form-control" maxlength="100" required>
                    </div>
                  </div>

                  <div class="col-2">
                    <div class="form-group">
                      <label>UF</label>
                      <input name="nUF" id="iUF" type="text" class="form-control" maxlength="2" required>
                    </div>
                  </div>
                
                </div>
                
                <div class="custom-control custom-checkbox">
                  <input class="custom-control-input custom-control-input-success" type="checkbox" id="iAtivoCliente" name="nAtivoCliente" checked>
                  <label for="iAtivoCliente" class="custom-control-label">Cliente Ativo</label>
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
      "order": [[0, "desc"]]
    });
  });
</script>

</body>
</html>
