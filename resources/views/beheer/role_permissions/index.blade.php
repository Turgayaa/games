@extends('base')

@section('title', 'Beheer - Permissie aan rol')

@section('content')

@include('beheer.menu')

<h2>Permissies gekoppeld aan rollen</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<a href="/beheer/role-permissions/create" class="btn btn-primary mb-3">Koppeling toevoegen</a>

<table class="table table-striped">
    <thead class="thead-dark">
        <tr>
            <th>Permissie ID</th>
            <th>Permissie</th>
            <th>Rol ID</th>
            <th>Rol</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        @foreach($koppelingen as $k)
            <tr>
                <td>{{ $k->permission_id }}</td>
                <td>{{ $k->permission_name }}</td>
                <td>{{ $k->role_id }}</td>
                <td>{{ $k->role_name }}</td>
                <td>
                    <a href="/beheer/role-permissions/edit/{{ $k->permission_id }}/{{ $k->role_id }}" class="btn btn-warning btn-sm">Edit</a>
                </td>
                <td>
                    <form method="POST" action="/beheer/role-permissions/destroy/{{ $k->permission_id }}/{{ $k->role_id }}">
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