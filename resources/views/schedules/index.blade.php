@extends('layouts.octopus')
@section('content')
<header class="page-header">
    <h2>Administración de Agenda</h2>
    <div class="right-wrapper pull-right">
        <ol class="breadcrumbs">
            <li>
                <a href="{{route('home')}}">
                    <i class="fa fa-home"></i>
                </a>
            </li>
            @if(Auth::user()->role_id == 2 || Auth::user()->role_id == 6)
            <li><a href="{{ route('schedules.create')}}"><span>Crear</span></a></li>
            @endif
        </ol>
        <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
    </div>
</header>

<section class="panel">
    <header class="panel-heading">
        <div class="panel-actions">
            <a href="#" class="fa fa-caret-down"></a>
            <a href="#" class="fa fa-times"></a>
        </div>

        <h2 class="panel-title">Agenda de Instalaciones</h2>
    </header>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-9">
                <div id="calendar"></div>
            </div>
            <div class="col-md-3">
                <p class="h4 text-light">Status de Instalaciones</p>
                <hr />
                <span class="label label-success">Instalaciones Completadas</span>
                <span class="label label-warning">Instalaciones Pendientes</span>
                <span class="label label-danger">Instalaciones Canceladas</span>
            </div>
        </div>
    </div>
</section>

<section class="panel">
    <header class="panel-heading">
        <div class="panel-actions">
            <a href="#" class="fa fa-caret-down"></a>
            <a href="#" class="fa fa-times"></a>
        </div>

        <h2 class="panel-title">Instalaciones Programadas</h2>
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-striped mb-none" id="datatable-default">
            <thead >
                <tr>
                <th scope="col">Fecha Inicial</th>
                <th scope="col">Fecha Final</th>
                <th scope="col">Paquete</th>
                <th scope="col">Nombre</th>
                <th scope="col">Email</th>
                <th scope="col">Teléfono Venta</th>
                <th scope="col">Dirección</th>
                <th scope="col">Referencias</th>
                </tr>
            </thead>
            <tbody>
            @foreach( $schedules_pending as $schedule_pending )
            <tr style="cursor: pointer;">
                <td>{{ $schedule_pending->date_install_init }}</td>
                <td>{{ $schedule_pending->date_install_final }}</td>
                <td>{{ $schedule_pending->pack_name }}</td>
                <td>{{ $schedule_pending->name.' '.$schedule_pending->lastname }}</td>
                <td>{{ $schedule_pending->email }}</td>
                <td>{{ $schedule_pending->cellphone }}</td>
                <td>{{ $schedule_pending->address }}</td>
                <td>{!! $schedule_pending->reference_address !!}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</section>

<!-- Librerías Calendar -->
<script src="{{asset('octopus/assets/vendor/jquery-ui/js/jquery-ui-1.10.4.custom.js')}}"></script>
<script src="{{asset('octopus/assets/vendor/jquery-ui-touch-punch/jquery.ui.touch-punch.js')}}"></script>
<script src="{{asset('octopus/assets/vendor/fullcalendar/lib/moment.min.js')}}"></script>
<script src="{{asset('octopus/assets/vendor/fullcalendar/fullcalendar.js')}}"></script>
<script>

(function( $ ) {

'use strict';
    var instalations = @json($schedules);
    console.log(instalations);
    var data = [];
    var title = '', start = '', end = '', allDay = false, className = '', url = ''; 
    var day= '', month='', year='', day2= '', month2='', year2='', date_init = '', date_fin = '';
    var hr = '', min= '', hr2 = '', min2 = '';
    
    for(let i = 0; i < instalations.length; i++) {
        date_init = instalations[i].date_install_init;
        date_fin = instalations[i].date_install_final;
        year = date_init.substring(0, 4);
        month = date_init.substring(5, 7);
        day = date_init.substring(8, 10);
        hr = date_init.substring(11,13);
        min = date_init.substring(14,16);

        year2 = date_fin.substring(0, 4);
        month2 = date_fin.substring(5, 7);
        day2 = date_fin.substring(8, 10);
        hr2 = date_fin.substring(11,13);
        min2 = date_fin.substring(14,16);

        if(instalations[i].status == 'pendiente'){
            className = 'fc-event-warning';
        }else if(instalations[i].status == 'completado'){
            className = 'fc-event-success';
        }else if(instalations[i].status == 'cancelado'){
            className = 'fc-event-danger';
        }

        url = "{{ route('schedules.show', ['schedule' => 'temp']) }}";
        url = url.replace('temp', instalations[i].id);

        data.push({
            title: 'Instalación '+instalations[i].pack_name,
            start: new Date(year,month-1,day,hr,min),
            end: new Date(year2,month2-1,day2,hr2,min2),
            allDay: allDay,
            className: className,
            url: url
        });
        console.log(instalations[i].date_install_init);
    }
        // console.log(data);

var initCalendarDragNDrop = function() {
    $('#external-events div.external-event').each(function() {

        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
        // it doesn't need to have a start or end
        var eventObject = {
            title: $.trim($(this).text()) // use the element's text as the event title
        };

        // store the Event Object in the DOM element so we can get to it later
        $(this).data('eventObject', eventObject);

        // make the event draggable using jQuery UI
        $(this).draggable({
            zIndex: 999,
            revert: true,      // will cause the event to go back to its
            revertDuration: 0  //  original position after the drag
        });

    });
};

var initCalendar = function() {
    var $calendar = $('#calendar');
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();
    // console.log(d);
    // console.log(m);
    // console.log(y);

    $calendar.fullCalendar({
        header: {
            left: 'title',
            right: 'prev,today,next,basicDay,basicWeek,month'
        },

        timeFormat: 'h:mm',

        titleFormat: {
            month: 'MMMM YYYY',      // September 2009
            week: "MMM D YYYY",      // Sep 13 2009
            day: 'dddd, MMM D, YYYY' // Tuesday, Sep 8, 2009
        },

        themeButtonIcons: {
            prev: 'fa fa-caret-left',
            next: 'fa fa-caret-right',
        },

        editable: true,
        droppable: true, // esto permite colocar cosas en el calendario !!!
        drop: function(date, allDay) { // esta función se llama cuando se suelta algo
            var $externalEvent = $(this);
            // recuperar el objeto de evento almacenado del elemento caído
            var originalEventObject = $externalEvent.data('eventObject');

            // necesitamos copiarlo, para que varios eventos no tengan una referencia al mismo objeto
            var copiedEventObject = $.extend({}, originalEventObject);

            // asígnele la fecha en la que se informó
            copiedEventObject.start = date;
            copiedEventObject.allDay = allDay;
            copiedEventObject.className = $externalEvent.attr('data-event-class');

            // renderizar el evento en el calendario
            // el último argumento `true` determina si el evento" se pega "(http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
            $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

            // ¿Está marcada la casilla de verificación "eliminar después de soltar"?
            if ($('#RemoveAfterDrop').is(':checked')) {
                // Si es así, elimine el elemento de la lista "Eventos que se pueden arrastrar".
                $(this).remove();
            }

        },
        
        events: data
    });

    // FIX INPUTS TO BOOTSTRAP VERSIONS
    var $calendarButtons = $calendar.find('.fc-header-right > span');
    $calendarButtons
        .filter('.fc-button-prev, .fc-button-today, .fc-button-next')
            .wrapAll('<div class="btn-group mt-sm mr-md mb-sm ml-sm"></div>')
            .parent()
            .after('<br class="hidden"/>');

    $calendarButtons
        .not('.fc-button-prev, .fc-button-today, .fc-button-next')
            .wrapAll('<div class="btn-group mb-sm mt-sm"></div>');

    $calendarButtons
        .attr({ 'class': 'btn btn-sm btn-default' });
};

$(function() {
    initCalendar();
    initCalendarDragNDrop();
});

}).apply(this, [ jQuery ]);
</script>
@endsection