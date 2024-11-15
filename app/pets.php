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
    $_SESSION['menu-n2'] = 'pets';
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
                    <h3 class="card-title">Pets</h3>
                  </div>
                  
                  <div class="col-3" align="right">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#novoPetModal">
                      Novo Pet
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
                      <input type="text" class="form-control" id="iNome" name="nNome" maxlength="50">
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
                      <select id="iTipoPetAjax" name="nTipoPet" class="form-control" required>
                        <option value="">Selecione...</option>
                        <?php echo optionTipoPet("I");?>
                      </select>
                    </div>
                  </div>

                  <div class="col-6">
                    <div class="form-group">
                      <label for="iRacaAjax">Raça:</label>
                      <select name="nRacaAjax" id="iRacaAjax" class="form-control" required>
                        <option value="">Selecione...</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-3">
                    <div class="form-group">
                      <label for="iAltura">Altura (cm):</label>
                      <input type="number" class="form-control" id="iAltura" name="nAltura">
                    </div>
                  </div>

                  <div class="col-3">
                    <div class="form-group">
                      <label for="iPeso">Peso (kg):</label>
                      <input type="number" class="form-control" id="iPeso" name="nPeso">
                    </div>
                  </div>

                  <div class="col-6">
                    <div class="form-group">
                      <label for="iPorte">Porte:</label>
                      <input type="text" class="form-control" id="iPorte" name="nPorte" readonly>
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

  // Código de porte dinâmico
  function atualizarPorte() {
    const altura = parseFloat(document.getElementById('iAltura').value) || 0;
    const peso = parseFloat(document.getElementById('iPeso').value) || 0;
    let porte = '';

  // Calcula uma pontuação com ponderação entre peso e altura
  const pontuacao = (peso * 1.5) + (altura * 1);

  // Classificação com base na pontuação
  if (pontuacao <= 55) {
    porte = 'Pequeno';
  } else if (pontuacao > 55 && pontuacao <= 87) {
    porte = 'Médio';
  } else {
    porte = 'Grande';
  }

    document.getElementById('iPorte').value = porte;
  }

  // Eventos de mudança
  document.getElementById('iAltura').addEventListener('input', atualizarPorte);
  document.getElementById('iPeso').addEventListener('input', atualizarPorte);

  //Lista dinâmica com Ajax
  $('#iTipoPetAjax').on('change',function(){
		//Pega o valor selecionado na lista 1
    var tipoPet  = $('#iTipoPetAjax').val();
    
    //Prepara a lista 2 filtrada
    var optionRaca = '';
              
    //Valida se teve seleção na lista 1
    if(tipoPet != "" && tipoPet != "0"){
      
      //Vai no PHP consultar dados para a lista 2
      $.getJSON('php/carregaRaca.php?tipo='+tipoPet,
      function (dados){  
        
        //Carrega a primeira option
        optionRaca = '<option value="">Selecione...</option>';                  
        
        //Valida o retorno do PHP para montar a lista 2
        if (dados.length > 0){                        
          
          //Se tem dados, monta a lista 2
          $.each(dados, function(i, obj){
            optionRaca += '<option value="'+obj.id_raca+'">'+obj.nome+'</option>';	                            
          })
          //Marca a lista 2 como required e mostra os dados filtrados
          $('#iRacaAjax').attr("required", "req");						
          $('#iRacaAjax').html(optionRaca).show();
        }else{
          
          //Não encontrou itens para a lista 2
          optionRaca += '<option value="">Selecione...</option>';
          $('#iRacaAjax').html(optionRaca).show();
        }
      })                
    }else{
      //Sem seleção na lista 1 não consulta
      optionRaca += '<option value="">Selecione...</option>';
      $('#iTipoPetAjax').html(optionRaca).show();
    }			
	});

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
