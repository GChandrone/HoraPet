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
                      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#novoAgendamentoModal">
                        Novo Agendamento
                      </button>
                    </div>

                  </div>
                </div>

                <div class="col-md-9">
                  <div class="card card-primary">
                    <div class="card-body p-0">
                      <!-- THE CALENDAR -->
                      <div id="calendar"></div>
                    </div>
                    <!-- /.card-body -->
                  </div>
                  <!-- /.card -->
                </div>
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
                <h4 class="modal-title">Nova Raça</h4>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form method="POST" action="php/salvarAgendamento.php?funcao=I" enctype="multipart/form-data">

                  <div class="row">
                    <div class="col-8">
                      <div class="form-group">
                        <label for="iNome">Nome:</label>
                        <input type="text" class="form-control" id="iNome" name="nNome" maxlength="50" required>
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

                    <!-- <div class="col-12">  UTILIZAR NO CADASTRO DO PET
                    <div class="form-group">
                      <label for="iFoto">Foto:</label>
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="iFoto" name="nFoto" accept="image/*">
                        <label class="custom-file-label" for="customFile">Nenhum arquivo escolhido</label>
                      </div>
                    </div>
                  </div> -->
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

/* initialize the external events
 -----------------------------------------------------------------*/
function ini_events(ele) {
  ele.each(function () {

    // create an Event Object (https://fullcalendar.io/docs/event-object)
    // it doesn't need to have a start or end
    var eventObject = {
      title: $.trim($(this).text()) // use the element's text as the event title
    }

    // store the Event Object in the DOM element so we can get to it later
    $(this).data('eventObject', eventObject)

    // make the event draggable using jQuery UI
    $(this).draggable({
      zIndex        : 1070,
      revert        : true, // will cause the event to go back to its
      revertDuration: 0  //  original position after the drag
    })

  })
}

ini_events($('#external-events div.external-event'))

/* initialize the calendar
 -----------------------------------------------------------------*/
//Date for the calendar events (dummy data)
var date = new Date()
var d    = date.getDate(),
    m    = date.getMonth(),
    y    = date.getFullYear()

var Calendar = FullCalendar.Calendar;
var Draggable = FullCalendar.Draggable;

var containerEl = document.getElementById('external-events');
var checkbox = document.getElementById('drop-remove');
var calendarEl = document.getElementById('calendar');

// initialize the external events
// -----------------------------------------------------------------

new Draggable(containerEl, {
  itemSelector: '.external-event',
  eventData: function(eventEl) {
    return {
      title: eventEl.innerText,
      backgroundColor: window.getComputedStyle( eventEl ,null).getPropertyValue('background-color'),
      borderColor: window.getComputedStyle( eventEl ,null).getPropertyValue('background-color'),
      textColor: window.getComputedStyle( eventEl ,null).getPropertyValue('color'),
    };
  }
});

var calendar = new Calendar(calendarEl, {
  headerToolbar: {
    left  : 'prev,next today',
    center: 'title',
    right : 'dayGridMonth,timeGridWeek,timeGridDay'
  },
  themeSystem: 'bootstrap',
  //Random default events
  events: [
    {
      title          : 'All Day Event',
      start          : new Date(y, m, 1),
      backgroundColor: '#f56954', //red
      borderColor    : '#f56954', //red
      allDay         : true
    },
    {
      title          : 'Long Event',
      start          : new Date(y, m, d - 5),
      end            : new Date(y, m, d - 2),
      backgroundColor: '#f39c12', //yellow
      borderColor    : '#f39c12' //yellow
    },
    {
      title          : 'Meeting',
      start          : new Date(y, m, d, 10, 30),
      allDay         : false,
      backgroundColor: '#0073b7', //Blue
      borderColor    : '#0073b7' //Blue
    },
    {
      title          : 'Lunch',
      start          : new Date(y, m, d, 12, 0),
      end            : new Date(y, m, d, 14, 0),
      allDay         : false,
      backgroundColor: '#00c0ef', //Info (aqua)
      borderColor    : '#00c0ef' //Info (aqua)
    },
    {
      title          : 'Birthday Party',
      start          : new Date(y, m, d + 1, 19, 0),
      end            : new Date(y, m, d + 1, 22, 30),
      allDay         : false,
      backgroundColor: '#00a65a', //Success (green)
      borderColor    : '#00a65a' //Success (green)
    },
    {
      title          : 'Click for Google',
      start          : new Date(y, m, 28),
      end            : new Date(y, m, 29),
      url            : 'https://www.google.com/',
      backgroundColor: '#3c8dbc', //Primary (light-blue)
      borderColor    : '#3c8dbc' //Primary (light-blue)
    }
  ],
  editable  : true,
  droppable : true, // this allows things to be dropped onto the calendar !!!
  drop      : function(info) {
    // is the "remove after drop" checkbox checked?
    if (checkbox.checked) {
      // if so, remove the element from the "Draggable Events" list
      info.draggedEl.parentNode.removeChild(info.draggedEl);
    }
  }
});

calendar.render();
// $('#calendar').fullCalendar()

/* ADDING EVENTS */
var currColor = '#3c8dbc' //Red by default
// Color chooser button
$('#color-chooser > li > a').click(function (e) {
  e.preventDefault()
  // Save color
  currColor = $(this).css('color')
  // Add color effect to button
  $('#add-new-event').css({
    'background-color': currColor,
    'border-color'    : currColor
  })
})
$('#add-new-event').click(function (e) {
  e.preventDefault()
  // Get value and make sure it is not null
  var val = $('#new-event').val()
  if (val.length == 0) {
    return
  }

  // Create events
  var event = $('<div />')
  event.css({
    'background-color': currColor,
    'border-color'    : currColor,
    'color'           : '#fff'
  }).addClass('external-event')
  event.text(val)
  $('#external-events').prepend(event)

  // Add draggable funtionality
  ini_events(event)

  // Remove event from text input
  $('#new-event').val('')
})
})
  </script>

</body>

</html>