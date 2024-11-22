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
  
    $(document).ready(function() {
      var date = new Date();
      var d = date.getDate();
      var m = date.getMonth();
      var y = date.getFullYear();

      /*  className colors
      className: default(transparent), important(red), chill(pink), success(green), info(blue)
      */

      /* inicializar os eventos externos
      -----------------------------------------------------------------*/

      $('#external-events div.external-event').each(function() {

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
        select: function(start, end, allDay) {
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
        drop: function(date, allDay) { // essa função é chamada quando há falha

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
          <?php //echo carregaAgenda(); 
          ?>

        },

      });

    });

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