@extends('layouts.app')

@section('content')
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3>Proyectos</h3>
        @if (Auth::user()->is_admin)
            <a href="#" class="btn btn-outline-success" data-toggle="modal" data-target="#addProjectModal">
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
                        @if (Auth::user()->is_admin)
                           
                            <a href="{{ route('projects.destroy', $project->id) }}" class="btn btn-outline-danger btn-sm" onclick="event.preventDefault(); document.getElementById('deleteProjectForm{{ $project->id }}').submit();">
                                <i class="fas fa-trash"></i> Eliminar
                            </a>
                            <form id="deleteProjectForm{{ $project->id }}" action="{{ route('projects.destroy', $project->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        @endif
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
                $('#taskForm').trigger('reset');
                $('#taskModalLabel').text('Añadir Tarea');
                $('#taskForm').attr('action', '{{ route('tasks.store') }}');
                $('#taskMethod').val('POST');
                $('#taskProjectId').val(copiedEventObject.projectId);
                $('#taskStartDate').val(date.format('YYYY-MM-DDTHH:mm'));
                $('#taskModal').modal('show');
            },
            events: [
                @foreach($tasks as $task)
                    {
                        title: '{{ $task->project->name }}',
                        name: '{{ $task->name }}',
                        start: '{{ $task->start_datetime }}',
                        end: '{{ $task->end_datetime }}',
                        id: '{{ $task->id }}',
                        description: '{{ $task->description }}',
                        project_id: '{{ $task->project_id }}',
                        user_id: '{{ $task->project->user_id }}'
                    },
                @endforeach
            ],
            eventClick: function(event) {
                $('#taskForm').trigger('reset');
                $('#taskModalLabel').text('Editar Tarea');
                $('#taskForm').attr('action', '{{ route('tasks.update', '') }}/' + event.id);
                $('#taskMethod').val('PUT');
                $('#taskId').val(event.id);
                $('#taskName').val(event.name);
                $('#taskDescription').val(event.description);
                $('#taskProjectId').val(event.project_id);
                $('#taskUserId').val(event.user_id);
                $('#taskStartDate').val(moment(event.start).format('YYYY-MM-DD HH:mm'));
                $('#taskEndDate').val(moment(event.end).format('YYYY-MM-DD HH:mm'));
                $('#taskModal').modal('show');
                
                $('#taskDeleteButton').off('click').on('click', function() {
                    if (confirm('¿Estás seguro de que deseas eliminar esta tarea?')) {
                        $.ajax({
                            url: '{{ route('tasks.destroy', '') }}/' + event.id,
                            method: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                $('#taskModal').modal('hide');
                                $('#calendar').fullCalendar('removeEvents', event.id);
                                window.location.href = '{{ route('home') }}';
                            },
                            error: function(xhr, status, error) {
                                console.error('Error al eliminar la tarea:', error);
                            }
                        });
                    }
                });
            }
        });

        // Guardar la tarea
        $('#taskForm').on('submit', function(e) {
            e.preventDefault();

            var form = $(this);
            var url = form.attr('action');
            var method = $('#taskMethod').val();

            $.ajax({
                url: url,
                method: method,
                data: form.serialize(),
                success: function(response) {
                    $('#taskModal').modal('hide');
                    $('#calendar').fullCalendar('refetchEvents');
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
