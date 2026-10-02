@extends('base')

@section('title', 'Beheer - Rol bewerken')

@section('content')

@include('beheer.menu')

<h2>Rol bewerken</h2>

@if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $error)
            <p class="mb-0">{{ $error }}</p>
        @endforeach
    </div>
@endif

<form method="POST" action="/beheer/roles/update/{{ $role->id }}">
    @csrf

    <div class="form-group mb-3">
        <label for="name">Naam</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $role->name) }}">
    </div>

    <button type="submit" class="btn btn-primary">Opslaan</button>
    <a href="/beheer/roles" class="btn btn-secondary">Terug</a>
</form>

@endsection