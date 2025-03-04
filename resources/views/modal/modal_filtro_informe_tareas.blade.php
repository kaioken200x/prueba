<!-- Modal para filtros de informe -->
<div class="modal fade" id="informeProjectModal" tabindex="-1" role="dialog" aria-labelledby="informeProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="informeProjectModalLabel">Informe Proyecto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="informeProjectForm">
                    <div class="form-group">
                        <label for="filterStartDate">Fecha de Inicio</label>
                        <input type="date" class="form-control" id="filterStartDate" name="filterStartDate" required>
                    </div>
                    <div class="form-group">
                        <label for="filterEndDate">Fecha de Fin</label>
                        <input type="date" class="form-control" id="filterEndDate" name="filterEndDate" required>
                    </div>
                    <div class="form-group">
                        <label for="filterProject">Proyecto</label>
                        <select class="form-control" id="filterProject" name="filterProject">
                            <option value="">Todos los Proyectos</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="filterUser">Usuario</label>
                        <select class="form-control" id="filterUser" name="filterUser">
                            <option value="">Todos los Usuarios</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="filterButton">Filtrar</button>
            </div>
        </div>
    </div>
</div>