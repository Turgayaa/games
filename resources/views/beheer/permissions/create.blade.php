@extends('base')

@section('title', 'Beheer - Permissie toevoegen')

@section('content')

@include('beheer.menu')

<h2>Permissie toevoegen</h2>

@if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $error)
            <p class="mb-0">{{ $error }}</p>
        @endforeach
    </div>
@endif

<form method="POST" action="/beheer/permissions/store">
    @csrf

    <div class="form-group mb-3">
        <label for="name">Naam</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
    </div>

    <button type="submit" class="btn btn-primary">Opslaan</button>
    <a href="/beheer/permissions" class="btn btn-secondary">Terug</a>
</form>

@endsection