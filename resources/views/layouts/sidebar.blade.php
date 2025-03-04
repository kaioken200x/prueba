<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link">
        <span class="brand-text font-weight-light float-center">Painel {{ Auth::user()->is_admin ? 'Admin' : 'User' }}</span>
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column">
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link">
                        <i class="nav-icon fas fa-plus-circle"></i>
                        <p>Proyectos</p>
                    </a>
                </li>
                @if (Route::has('users.index'))                    
                    <li class="nav-item">
                        <a href="{{ route('users.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Users</p>
                        </a>
                    </li>
                @endif
                
            </ul>
        </nav>
    </div>
</aside>

<div class="modal fade" id="addProjectModal" tabindex="-1" role="dialog" aria-labelledby="addProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProjectModalLabel">Añadir Proyecto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addProjectForm">
                    <div class="form-group">
                        <label for="projectName">Nombre del Proyecto</label>
                        <input type="text" class="form-control" id="projectName" name="projectName" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="saveProjectButton">Guardar Proyecto</button>
            </div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function() {
        $('#saveProjectButton').on('click', function() {
            var projectName = $('#projectName').val();
            $.ajax({
                url: '{{ route('projects.store') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    name: projectName
                },
                success: function(response) {
                    if(response.id) {
                    window.location.href = '{{ route('home') }}';
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Erro ao salvar o projeto:', error);
                }
            });
        });
    });
        
</script>