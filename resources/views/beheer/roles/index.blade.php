@extends('base')

@section('title', 'Beheer - Rollen')

@section('content')

@include('beheer.menu')

<h2>Rollen</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<a href="/beheer/roles/create" class="btn btn-primary mb-3">Rol toevoegen</a>

<table class="table table-striped">
    <thead class="thead-dark">
        <tr>
            <th>ID</th>
            <th>Naam</th>
            <th>Guard</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        @foreach($roles as $role)
            <tr>
                <td>{{ $role->id }}</td>
                <td>{{ $role->name }}</td>
                <td>{{ $role->guard_name }}</td>
                <td>
                    <a href="/beheer/roles/edit/{{ $role->id }}" class="btn btn-warning btn-sm">Edit</a>
                </td>
                <td>
                    <form method="POST" action="/beheer/roles/destroy/{{ $role->id }}">
                        @csrf
                        <button
                            onclick="return confirm('Weet je het zeker?')"
                            class="btn btn-danger btn-sm"
                            type="submit">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection