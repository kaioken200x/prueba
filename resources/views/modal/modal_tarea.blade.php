<div class="modal fade" id="addTaskModal" tabindex="-1" role="dialog" aria-labelledby="addTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTaskModalLabel">Añadir Tarea</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addTaskForm">
                    <div class="form-group">
                        <label for="taskName">Nombre de la Tarea</label>
                        <input type="text" class="form-control" id="taskName" name="taskName" required>
                    </div>
                    <div class="form-group">
                        <label for="taskDescription">Descripción de la Tarea</label>
                        <textarea class="form-control" id="taskDescription" name="taskDescription" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="taskUser">Asignar a Usuario</label>
                        <select class="form-control" id="taskUser" name="taskUser">
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
                    <input type="hidden" id="taskProjectId" name="taskProjectId">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="saveTaskButton">Guardar Tarea</button>
            </div>
        </div>
    </div>
</div>