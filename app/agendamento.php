<?php
session_start();
include('php/funcoes.php');

// Todos tem Acesso
verificarAcesso(['Administrador', 'Atendente', 'Esteticista Pet']);

$urlVoltar = $_SESSION['origem'];

if ($urlVoltar == 'agendamentos.php') {
  $menu = "agendamento";
  $descVoltar = "agendamentos";
}else{
  $menu = "calendario";
  $descVoltar = "calendário";
}


if (isset($_GET["id"])) {

  $idAgendamento = $_GET["id"];
  // $idPorte = $_GET["idPorte"];

  include("php/conexao.php");

  $sql = "SELECT "
    . "  cliente.id_cliente, "
    . "  cliente.nome 	 	            as nome_cliente, "
    . "  cliente.telefone 	          as telefone_cliente, "
    . "  pet.id_pet, "
    . "  pet.nome         	          as nome_pet, "
    . "  pet.porte                    as porte_pet, "
    . "  funcionario.id_funcionario, "
    . "  funcionario.nome 	          as nome_funcionario, "
    . "  funcionario.telefone         as telefone_funcionario, "
    . "  agendamento.data, "
    . "  agendamento.horario_inicial, "
    . "  agendamento.situacao "
    . "FROM agendamento "
    . "INNER JOIN cliente "
    . "  ON cliente.id_cliente = agendamento.id_cliente "
    . "INNER JOIN pet "
    . "  ON pet.id_pet = agendamento.id_pet "
    . "INNER JOIN funcionario "
    . "  ON funcionario.id_funcionario = agendamento.id_funcionario "
    . "WHERE id_agendamento = ".decodeId($idAgendamento)."; ";


  try {
      $result = mysqli_query($conn, $sql);
  
      if (!$result) {
          throw new Exception("Erro ao executar a consulta.");
      }
  
      // Processar o resultado normalmente...
  } catch (Exception $e) {
  
      $_SESSION['erro_mensagem'] = 'Não foi possível acessar os dados. Tente novamente mais tarde.';
      $_SESSION['erro_tipo'] = 'erro_banco';
      // Redirecione para a página de erro
      header("Location: mensagem.php");
      exit;
  }

  mysqli_close($conn);

  $lista = '';

  //Validar se tem retorno do BD
  if (mysqli_num_rows($result) > 0) {

    foreach ($result as $coluna) {
      $idCliente = $coluna["id_cliente"];
      $cliente = $coluna["nome_cliente"];
      $telefone_cliente = $coluna["telefone_cliente"];
      $idPet = $coluna["id_pet"];
      $pet = $coluna["nome_pet"];
      $idPorte = $coluna["porte_pet"];
      $idFuncionario = $coluna["id_funcionario"];
      $funcionario = $coluna["nome_funcionario"];
      $telefone_funcionario = $coluna["telefone_funcionario"];
      $data = $coluna["data"];
      $hora = $coluna["horario_inicial"];
      $situacaoAgendamento = $coluna["situacao"];
    }
  }
}

if ($urlVoltar == 'calendario.php') {
  $urlVoltar = "calendario.php?data=".$data;
}

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
    $_SESSION['menu-n2'] = $menu;
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
                      <h3 class="card-title"><?php echo isset($idAgendamento) ? 'Alterar' : 'Incluir'; ?> Agendamento</h3>
                    </div>

                    <?php if (isset($idAgendamento)) { ?>
                      <div class="col-3" align="right">
                        <a href="<?php echo $urlVoltar; ?>" class="btn btn-secondary" title="Volta para a tela de <?php echo $descVoltar; ?>">
                          Voltar
                        </a>
                      </div>
                    <?php }?>        

                  </div>
                </div>

                <?php if (isset($idAgendamento)) { ?>
                  <!-- Quando há idAgendamento faz uma alteração -->
                  <form id="formAgendamento" method="POST"
                    action="<?php echo 'php/salvarAgendamento.php?funcao=A&codigo=' . $idAgendamento; ?>"
                    enctype="multipart/form-data">
                  <?php } else { ?>
                    <!-- Quando não há idAgendamento faz uma inclusão -->
                    <form id="formAgendamento" method="POST" action="php/salvarAgendamento.php?funcao=I"
                      enctype="multipart/form-data">
                    <?php } ?>

                    <!-- Incio Agendamento -->
                    <div class="card-body">
                      <div class="row">

                        <div class="col-6">
                          <div class="form-group">
                            <label for="iCliente">Cliente - Telefone:</label>
                            <select id="iCliente" name="nCliente" class="form-control clienteAjax" required <?php echo isset($idAgendamento) ? 'readonly disabled' : ''; ?>>
                              <?php if (isset($idAgendamento)) { ?>
                                <!-- Exibe apenas a opção selecionada quando há idAgendamento -->
                                <option value="<?php echo $idCliente; ?>" selected>
                                  <?php echo $coluna["nome_cliente"] . ' - ' . $coluna["telefone_cliente"]; ?>
                                </option>
                              <?php } else { ?>
                                <!-- Exibe a opção padrão "Selecione..." quando não há idAgendamento -->
                                <option value="">Selecione...</option>
                                <?php echo optionDonoPet(); ?>
                              <?php } ?>
                            </select>
                          </div>
                        </div>

                        <div class="col-6">
                          <div class="form-group">
                            <label for="iPet">Pet:</label>
                            <?php if (isset($idAgendamento)) { ?>
                              <select name="nPet" class="form-control petAjax" id="" readonly disabled>
                                <option value="<?php echo $idPet; ?>" selected>
                                  <?php echo $coluna["nome_pet"]; ?>
                                </option>
                              </select>
                              <input type="hidden" name="nPet" value="<?php echo $idPet; ?>">
                            <?php } else { ?>
                              <select name="nPet" class="form-control petAjax" id="iPet">
                                <option value="">Selecione...</option>
                              </select>
                            <?php } ?>
                            </select>
                          </div>
                        </div>

                        <div class="col-12">
                          <div class="form-group">
                            <label for="iFuncionario">Funcionário - Telefone:</label>
                            <select id="iFuncionario" name="nFuncionario" class="form-control">
                              <?php if (isset($idAgendamento)) { ?>
                                <!-- Exibe apenas a opção selecionada quando há idAgendamento -->
                                <option value="<?php echo $idFuncionario; ?>" selected>
                                  <?php echo $coluna["nome_funcionario"] . ' - ' . $coluna["telefone_funcionario"]; ?>
                                </option>
                              <?php } else { ?>
                                <!-- Exibe a opção padrão "Selecione..." quando não há idAgendamento -->
                                <option value="">Selecione...</option>
                              <?php } ?>
                              <?php echo optionFuncionario(); ?>
                            </select>
                          </div>
                        </div>

                        <div class="col-4">
                          <div class="for8m-group">
                            <label for="iData">Data:</label>
                            <input type="date" class="form-control" id="iData" name="nData" value="<?php echo $data; ?>"
                              required min="2024-01-01" max="9999-12-31">
                          </div>
                        </div>

                        <div class="col-4">
                          <div class="form-group">
                            <label for="iHorarioInicio">Horário:</label>
                            <input type="time" class="form-control" id="iHorarioInicio" name="nHorarioInicio" min="08:00" max="19:00"
                              value="<?php echo $hora; ?>" required>
                          </div>
                        </div>

                        <div class="col-4">
                          <div class="form-group">
                            <label for="iSituacaoAgendamento">Situação:</label>
                            <select id="iSituacaoAgendamento" name="nSituacaoAgendamento" class="form-control" required>
                              <?php echo isset($idAgendamento) ? '<option value="' . $situacaoAgendamento . '">' . descrSituacaoAgendamento($situacaoAgendamento) . '</option>' : '<option value="1">Agendado</option>'; ?>
                              <?php echo isset($idAgendamento) ? optionSituacaoAgendamento($situacaoAgendamento) : optionSituacaoAgendamento('I'); ?>
                            </select>
                          </div>
                        </div>

                      </div>
                    </div>

                    <?php if (isset($idAgendamento)) { ?>

                      <div class="modal-footer">
                        <a href= <?php echo "agendamento.php?id=".$idAgendamento."&add=true"?> class="btn btn-danger">Cancelar</a>
                        <button type="submit" class="btn btn-success">Salvar</button>
                      </div>

                    <?php } else { ?>
                      
                      <div class="modal-footer">
                        <a href="agendamentos.php" class="btn btn-danger">Cancelar</a>
                        <button type="submit" class="btn btn-success">Salvar</button>
                      </div> 

                    <?php } ?>

                    </form>

                    <!-- Fim Agendamento -->

                    <!-- /.card-body -->
              </div>
              <!-- /.card -->
              <!-- Incio Servicos -->
              <?php if (isset($idAgendamento) > 0) { ?>

                <div
                  class="card card-success <?php echo isset($_GET['add']) && $_GET['add'] === 'true' ? '' : 'collapsed-card'; ?>">
                  <div class="card-header pointer" data-card-widget="collapse">
                    <h3 class="card-title">Adicionar Serviços</h3>
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i <?php echo isset($_GET['add']) ? 'class="fas fa-minus"' : 'class="fas fa-plus"'; ?>></i>
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

                        <?php echo listaExecucao($idAgendamento, $idPorte); ?>

                      </tbody>

                    </table>

                  </div>
                  <!-- /.card-body  -->
                </div>
                <!-- Fim Servicos -->

              <?php } ?>

              <div class="modal fade modal-limpar" id="novaExecucaoModal">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header bg-success">
                      <h4 class="modal-title">Novo Serviço</h4>
                      <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">

                      <form id="formServico" method="POST"
                        action="<?php echo 'php/salvarExecucao.php?funcao=I&idPorte=' . $idPorte . '&idAgendamento=' . decodeId($idAgendamento); ?>"
                        enctype="multipart/form-data">

                        <div class="row">
                          <div class="col-8">
                            <div class="form-group">
                              <label for="iServico">Serviço:</label>
                              <select id="iServico" name="nServico" class="form-control" required>
                                <option value="">Selecione...</option>
                                <?php echo optionServico($idPorte); ?>
                              </select>
                            </div>
                          </div>

                          <div class="col-4">
                            <div class="form-group">
                              <label for="iSituacaoExecucao">Situação:</label>
                              <select id="iSituacaoExecucao" name="nSituacaoExecucao" class="form-control" required>
                                <option value="1">Planejado</option>
                                <?php echo optionSituacaoExecucao("I"); ?>
                              </select>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-12">
                            <div class="form-group">
                              <label>Descrição:</label>
                              <textarea name="nDescricao" class="form-control" rows="3" placeholder="Escreva..."
                                maxlength="255"></textarea>
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
                  <!-- /.modal-content  -->
                </div>
                <!-- /.modal-dialog  -->
              </div>
              <!-- /.modal  -->

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

  
  <?php
    // Verificar a mensagem de erro
    if (isset($_SESSION['erro_mensagem'])):
    ?>
    <script>
    Swal.fire({
      icon: 'error',
      title: 'Atenção',
      text: '<?php echo $_SESSION['erro_mensagem']; ?>'
    });
    </script>
    <?php
    // Limpar a mensagem de erro após exibição
    unset($_SESSION['erro_mensagem']);
    endif;
  ?>
  
  
  
  
  
  
  
  
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