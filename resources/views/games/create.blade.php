<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Game</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <h1>🎮 Add Game</h1>

    <form action="/games/store" method="POST">
        @csrf

        <div class="form-group">
            <label>Game Name</label>
            <input type="text" class="form-control" name="game_name">
        </div>

        <div class="form-group">
            <label>Platform</label>
            <input type="text" class="form-control" name="platform">
        </div>

        <div class="form-group">
            <label>Genre</label>
            <input type="text" class="form-control" name="genre">
        </div>

        <div class="form-group">
            <label>Rating</label>
            <input type="number" step="0.1" min="0" max="10" class="form-control" name="rating">
        </div>

        <button type="submit" class="btn btn-success">
            Add Game
        </button>
    </form>
</div>

</body>
</html>