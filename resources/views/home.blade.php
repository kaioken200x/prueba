@extends('layouts.app')

@section('content')
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3>Proyectos</h3>
        @if (Auth::user()->is_admin)
            <a href="#" class="btn btn-outline-primary" data-toggle="modal" data-target="#addProjectModal">
                <i class="fas fa-plus"></i> Añadir Proyecto
            </a>
        @endif
            <a href="#" class="btn btn-outline-primary" data-toggle="modal" data-target="#informeProjectModal">
                <i class="fas fa-file-pdf"></i> Informe Proyecto
            </a>
    </div>

<div class="card-body">
    <div class="row">
        <div class="col-md-4" style="overflow-y: scroll; height: 600px;">
            @foreach($projects as $project)
                <div class="card mb-4 draggable" data-project-id="{{ $project->id }}" data-project-name="{{ $project->name }}">
                    <div class="card-body">
                        <h5 class="card-subtitle mb-1 text-muted">Nombre del Proyecto: {{ $project->name }}</h5>
                        <h6 class="card-subtitle text-muted">Creado por: {{ $project->user->name }}</h6>
                        <p class="card-text"><small class="text-muted">Creado el: {{ $project->created_at->format('d/m/Y') }}</small></p>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="col-md-8">
            <div id="calendar"></div>
        </div>
    </div>
</div>

<!-- Modal para añadir tarea -->

@include('modal.modal_tarea', ['projects' => $projects, 'users' => $users])

<!-- Modal para filtros de informe -->

@include('modal.modal_filtro_informe_tareas', ['projects' => $projects, 'users' => $users])

<script>

    $(document).ready(function() {
        // Hacer las tarjetas de los proyectos arrastrables
        $('.draggable').each(function() {
            $(this).data('event', {
                title: $.trim($(this).data('project-name')),
                projectId: $(this).data('project-id'),
                stick: true
            });

            $(this).draggable({
                zIndex: 999,
                revert: true,
                revertDuration: 0
            });
        });

        // Configurar el calendario
        $('#calendar').fullCalendar({
            locale: 'es',
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            editable: true,
            droppable: true,
            drop: function(date) {
                var originalEventObject = $(this).data('event');
                var copiedEventObject = $.extend({}, originalEventObject);

                copiedEventObject.start = date;
                $('#taskProjectId').val(copiedEventObject.projectId);
                $('#taskStartDate').val(date.format('YYYY-MM-DDTHH:mm'));
                $('#addTaskModal').modal('show');
            },
            events: [
                @foreach($tareas as $tarea)
                    {
                        title: '{{ $tarea->project->name }}',
                        start: '{{ $tarea->start_datetime }}',
                        end: '{{ $tarea->end_datetime }}'
                    },
                @endforeach
            ]
        });

        // Guardar la tarea
        $('#saveTaskButton').on('click', function() {
            var taskName = $('#taskName').val();
            var taskDescription = $('#taskDescription').val();
            var taskProjectId = $('#taskProjectId').val();
            var taskUserId = $('#taskUser').val();
            var taskStartDate = $('#taskStartDate').val();
            var taskEndDate = $('#taskEndDate').val();

            $.ajax({
                url: '{{ route('tasks.store') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    name: taskName,
                    description: taskDescription,
                    project_id: taskProjectId,
                    user_id: taskUserId,
                    start_datetime: taskStartDate,
                    end_datetime: taskEndDate
                },
                success: function(response) {
                    $('#addTaskModal').modal('hide');
                    $('#calendar').fullCalendar('renderEvent', {
                        title: response.name,
                        start: response.start_datetime,
                        end: response.end_datetime
                    }, true);

                    window.location.href = '{{ route('home') }}';
                },
                error: function(xhr, status, error) {
                    console.error('Error al guardar la tarea:', error);
                }
            });
        });

        // Filtrar el informe
        $('#filterButton').on('click', function() {
            var filterStartDate = $('#filterStartDate').val();
            var filterEndDate = $('#filterEndDate').val();
            var filterProject = $('#filterProject').val();
            var filterUser = $('#filterUser').val();

            $.ajax({
                url: '{{ route('tasks.report') }}',
                method: 'GET',
                data: {
                    start_date: filterStartDate,
                    end_date: filterEndDate,
                    project_id: filterProject,
                    user_id: filterUser
                },
                success: function(response) {
                    console.log(response);
                    
                    var blob = new Blob([response], { type: 'application/pdf' });
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = 'informe_proyecto.pdf';
                    link.click();
                    $('#informeProjectModal').modal('hide');
                },
                error: function(xhr, status, error) {
                    console.error('Error al generar el informe:', error);
                }
            });
        });
    });
</script>
@endsection
