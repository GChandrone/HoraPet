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
    $_SESSION['menu-n2'] = 'agenda';
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
                      <button type="button" class="btn btn-success" data-toggle="modal"
                        data-target="#novoAgendamentoModal">
                        Novo Agendamento
                      </button>
                    </div>

                  </div>
                </div>

                <!-- THE CALENDAR -->
                <div id="calendar"></div>
                <!-- /.card-body -->
                <!-- /.card -->
                <!-- /.col -->

                <!-- /.card-body -->
              </div>
              <!-- /.card -->

            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->

        <div class="modal fade" id="novoAgendamentoModal">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header bg-success">
                <h5 class="modal-title">Novo Agendamento</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form method="POST" action="php/salvarAgendamento.php?funcao=I" enctype="multipart/form-data">


                  <!-- Incio Agendamento -->
                  <div class="card">
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
                  </div>


                  <!-- TESTE -->
                  <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-success">Salvar</button>
                  </div>

                </form> -->
                  <!-- TESTE -->

                  <!-- Fim Agendamento -->

                  <!-- Incio Servicos -->

                  <div class="card card-success collapsed-card">
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

                          <?php echo listaRaca(); ?>

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
                              <form method="POST" action="php/salvarRaca.php?funcao=I" enctype="multipart/form-data">

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
                          <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog  -->
                      </div>
                      <!-- /.modal  -->

                    </div>
                    <!-- /.card-body  -->
                  </div>
                  <!-- Fim Servicos -->

                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-success">Salvar</button>
                  </div>

                </form>

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

    $(document).ready(function () {
      var date = new Date();
      var d = date.getDate();
      var m = date.getMonth();
      var y = date.getFullYear();

      /*  className colors
      className: default(transparent), important(red), chill(pink), success(green), info(blue)
      */

      /* inicializar os eventos externos
      -----------------------------------------------------------------*/

      $('#external-events div.external-event').each(function () {

        // não precisa ter começo nem fim
        var eventObject = {
          title: $.trim($(this).text()) // o texto do elemento como o título do evento
        };

        // armazena o objeto de evento no elemento DOM para que possamos acessá-lo mais tarde
        $(this).data('eventObject', eventObject);

        // evento draggable usando jQuery UI
        $(this).draggable({
          zIndex: 999,
          revert: true,
          revertDuration: 0
        });

      });


      /* inicializa o calendário
      -----------------------------------------------------------------*/

      var calendar = $('#calendar').fullCalendar({
        header: {
          left: 'title',
          center: 'agendaDay,agendaWeek,month',
          right: 'prev,next today'
        },
        editable: false,
        firstDay: 0, //  0(Domingo) 
        selectable: false,
        defaultView: 'month',

        axisFormat: 'H:mm',
        columnFormat: {
          month: 'ddd', // Ter
          week: 'ddd d', // Ter 16
          day: 'dddd M/d', // Terça 16/6
          agendaDay: 'dddd d' // Terça 16
        },
        titleFormat: {
          month: 'MMMM yyyy', // Junho 2020
          week: "MMMM yyyy", // Junho 2020
          day: 'MMMM yyyy' // Terça, Jun 16, 2020
        },
        allDaySlot: false,
        selectHelper: true,
        select: function (start, end, allDay) {
          var title = prompt('Event Title:');
          if (title) {
            calendar.fullCalendar('renderEvent', {
              title: title,
              start: start,
              end: end,
              allDay: allDay
            },
              true // evento "stick"
            );
          }
          calendar.fullCalendar('unselect');
        },
        droppable: true, // permite que os itens sejam colocados no calendário
        drop: function (date, allDay) { // essa função é chamada quando há falha

          // recuperar o elemento armazenado do elemento descartado Event Object
          var originalEventObject = $(this).data('eventObject');

          // para que vários eventos não tenham uma referência ao mesmo objeto
          var copiedEventObject = $.extend({}, originalEventObject);

          // data que foi relatada
          copiedEventObject.start = date;
          copiedEventObject.allDay = allDay;

          // renderizar o evento no calendário
          // o último argumento "true" determina se o evento "sticks"
          $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

          // a caixa de seleção "remover após soltar" está marcada?
          if ($('#drop-remove').is(':checked')) {
            // se sim, remova o elemento da lista "Draggable Events"
            $(this).remove();
          }
          <?php //echo carregaAgenda(); ?>

        },

      });

    });

    $(function () {
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