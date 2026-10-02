@extends('base')

@section('title', 'Beheer - Koppeling bewerken')

@section('content')

@include('beheer.menu')

<h2>Koppeling bewerken</h2>

@if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $error)
            <p class="mb-0">{{ $error }}</p>
        @endforeach
    </div>
@endif

<form method="POST" action="/beheer/role-permissions/update/{{ $permission_id }}/{{ $role_id }}">
    @csrf

    <div class="form-group mb-3">
        <label for="permission_id">Permissie</label>
        <select name="permission_id" id="permission_id" class="form-control">
            @foreach($permissions as $permission)
                <option value="{{ $permission->id }}" {{ old('permission_id', $permission_id) == $permission->id ? 'selected' : '' }}>
                    {{ $permission->id }} - {{ $permission->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group mb-3">
        <label for="role_id">Rol</label>
        <select name="role_id" id="role_id" class="form-control">
            @foreach($roles as $role)
                <option value="{{ $role->id }}" {{ old('role_id', $role_id) == $role->id ? 'selected' : '' }}>
                    {{ $role->id }} - {{ $role->name }}
                </option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Opslaan</button>
    <a href="/beheer/role-permissions" class="btn btn-secondary">Terug</a>
</form>

@endsection