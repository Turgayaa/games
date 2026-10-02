@extends('base')

@section('title', 'Beheer - Koppeling toevoegen')

@section('content')

@include('beheer.menu')

<h2>Rol koppelen aan gebruiker</h2>

@if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $error)
            <p class="mb-0">{{ $error }}</p>
        @endforeach
    </div>
@endif

<form method="POST" action="/beheer/user-roles/store">
    @csrf

    <div class="form-group mb-3">
        <label for="role_id">Rol</label>
        <select name="role_id" id="role_id" class="form-control">
            @foreach($roles as $role)
                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                    {{ $role->id }} - {{ $role->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group mb-3">
        <label for="user_id">Gebruiker</label>
        <select name="user_id" id="user_id" class="form-control">
            @foreach($users as $user)
                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                    {{ $user->id }} - {{ $user->name }} ({{ $user->email }})
                </option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Opslaan</button>
    <a href="/beheer/user-roles" class="btn btn-secondary">Terug</a>
</form>

@endsection