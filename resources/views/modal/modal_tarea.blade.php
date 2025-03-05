<!-- Modal para añadir/editar tarea -->
<div class="modal fade" id="taskModal" tabindex="-1" role="dialog" aria-labelledby="taskModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="taskModalLabel">Añadir Tarea</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="taskForm">
                    @csrf
                    <input type="hidden" id="taskMethod" name="_method" value="POST">
                    <input type="hidden" id="taskId" name="id">
                    <div class="form-group">
                        <label for="taskName">Nombre de la Tarea</label>
                        <input type="text" class="form-control" id="taskName" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="taskDescription">Descripción</label>
                        <textarea class="form-control" id="taskDescription" name="description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="taskProjectId">Proyecto</label>
                        <select class="form-control" id="taskProjectId" name="project_id">
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="taskUserId">Usuario</label>
                        <select class="form-control" id="taskUserId" name="user_id">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="taskStartDate">Fecha de Inicio</label>
                        <input type="datetime-local" class="form-control" id="taskStartDate" name="start_datetime" required>
                    </div>
                    <div class="form-group">
                        <label for="taskEndDate">Fecha de Fin</label>
                        <input type="datetime-local" class="form-control" id="taskEndDate" name="end_datetime" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    <button type="button" id="taskDeleteButton" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>