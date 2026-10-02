@extends('base')

@section('title', '🎮 Game Collection')

@section('content')

{{-- Tijdelijk: laat zien wie is ingelogd (handig voor je filmpje) --}}
<p>Ingelogd als: {{ auth()->user()->email }} ({{ auth()->user()->getRoleNames()->implode(', ') }})</p>

@role('admin')
    <a href="/games/create" class="btn btn-primary mb-3">Add Game</a>
@endrole

<table class="table table-striped">
    <thead class="thead-dark">
        <tr>
            <th>ID</th>
            <th>Game</th>
            <th>Platform</th>
            <th>Genre</th>
            <th>Rating</th>
            <th>Show</th>

            @role('admin')
                <th>Edit</th>
                <th>Delete</th>
            @endrole
        </tr>
    </thead>

    <tbody>

        @php($sum = 0)

        @foreach($games as $game)

            @php($sum += $game->rating)

            <tr>
                <td>{{ $game->id }}</td>
                <td>{{ $game->game_name }}</td>
                <td>{{ $game->platform }}</td>
                <td>{{ $game->genre }}</td>
                <td>{{ $game->rating }}/10</td>

                <td>
                    <a href="/games/show/{{ $game->id }}" class="btn btn-info btn-sm">Show</a>
                </td>

                @role('admin')
                    <td>
                        <a href="/games/edit/{{ $game->id }}" class="btn btn-warning btn-sm">Edit</a>
                    </td>

                    <td>
                        <form method="POST" action="/games/destroy/{{ $game->id }}">
                            @csrf
                            <button
                                onclick="return confirm('Weet je het zeker?')"
                                class="btn btn-danger btn-sm"
                                type="submit">
                                Delete
                            </button>
                        </form>
                    </td>
                @endrole
            </tr>

        @endforeach

        <tr>
            <td colspan="4">
                <strong>Gemiddelde rating:</strong>
            </td>

            <td>
                <strong>
                    {{ count($games) > 0 ? number_format($sum / count($games), 1) : 0 }}/10
                </strong>
            </td>

            <td></td>

            @role('admin')
                <td></td>
                <td></td>
            @endrole
        </tr>

    </tbody>
</table>

@endsection