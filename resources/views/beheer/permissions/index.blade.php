@extends('base')

@section('title', 'Beheer - Permissies')

@section('content')

@include('beheer.menu')

<h2>Permissies</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<a href="/beheer/permissions/create" class="btn btn-primary mb-3">Permissie toevoegen</a>

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
        @foreach($permissions as $permission)
            <tr>
                <td>{{ $permission->id }}</td>
                <td>{{ $permission->name }}</td>
                <td>{{ $permission->guard_name }}</td>
                <td>
                    <a href="/beheer/permissions/edit/{{ $permission->id }}" class="btn btn-warning btn-sm">Edit</a>
                </td>
                <td>
                    <form method="POST" action="/beheer/permissions/destroy/{{ $permission->id }}">
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