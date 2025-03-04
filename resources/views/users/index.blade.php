@extends('layouts.app')

@section('content')
<style>

#volver {
        border-radius: 20px;
    }

</style>
<div class="card-header">{{ __('Usuarios') }}
    <a id="volver" href="{{ route('users.create') }}" class="btn btn-primary" title="Crear Usuario">
        <i class="fas fa-plus"></i>
    </a>

    @if(session('message'))
        <div class="alert alert-success mt-3">
            {{ session('message') }}
        </div>
    @endif


    <div class="container mt-4">
        
        <table class="table mt-6">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Administrador</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->is_admin ? 'Sí' : 'No' }}</td>
                        <td>
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-warning"><i class="fas fa-pen"></i> Editar</a>
                            <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-center mt-4">
            <div>
                {{ $users->links() }}
            </div>
            <div>
                Mostrando {{ $users->firstItem() }} a {{ $users->lastItem() }} de {{ $users->total() }} registros
            </div>
        </div>
    </div>
</div>
@endsection