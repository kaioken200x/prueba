@extends('layouts.app')

@section('content')
<style>

    #volver {
        border-radius: 20px;
    }

</style>
<div class="card-header">
    <a id="volver" href="{{ route('users.index') }}" class="btn btn-primary" title="Volver Usuario">
        <i class="fas fa-arrow-left"></i>
    </a>
    {{ __('Volver') }}

    <div class="container mt-4">
        <form action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}" method="POST">
            @csrf
            @if(isset($user))
                @method('PUT')
            @endif
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" name="name" class="form-control" value="{{ isset($user) ? $user->name : '' }}" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" value="{{ isset($user) ? $user->email : '' }}" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" name="password" class="form-control" {{ isset($user) ? '' : 'required' }}>
            </div>
            <div class="form-group">
                <label for="is_admin">Administrador</label>
                <select name="is_admin" class="form-control" required>
                    <option value="0" {{ isset($user) && $user->is_admin == 0 ? 'selected' : '' }}>No</option>
                    <option value="1" {{ isset($user) && $user->is_admin == 1 ? 'selected' : '' }}>Sí</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">{{ isset($user) ? 'Actualizar' : 'Guardar' }}</button>
        </form>
    </div>
</div>
@endsection