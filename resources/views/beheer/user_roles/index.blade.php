@extends('base')

@section('title', 'Beheer - Rol aan gebruiker')

@section('content')

@include('beheer.menu')

<h2>Rollen gekoppeld aan gebruikers</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<a href="/beheer/user-roles/create" class="btn btn-primary mb-3">Koppeling toevoegen</a>

<table class="table table-striped">
    <thead class="thead-dark">
        <tr>
            <th>Gebruiker ID</th>
            <th>Naam</th>
            <th>E-mail</th>
            <th>Rol ID</th>
            <th>Rol</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        @foreach($koppelingen as $k)
            <tr>
                <td>{{ $k->user_id }}</td>
                <td>{{ $k->user_name }}</td>
                <td>{{ $k->user_email }}</td>
                <td>{{ $k->role_id }}</td>
                <td>{{ $k->role_name }}</td>
                <td>
                    <a href="/beheer/user-roles/edit/{{ $k->role_id }}/{{ $k->user_id }}" class="btn btn-warning btn-sm">Edit</a>
                </td>
                <td>
                    <form method="POST" action="/beheer/user-roles/destroy/{{ $k->role_id }}/{{ $k->user_id }}">
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