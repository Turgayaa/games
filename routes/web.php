<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\Beheer\PermissionController;
use App\Http\Controllers\Beheer\RoleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Profiel (alle ingelogde gebruikers)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin en klant: overzicht en show
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin|klant'])->group(function () {
    Route::get('/games', [GameController::class, 'index']);
    Route::get('/games/show/{id}', [GameController::class, 'show']);
});

/*
|--------------------------------------------------------------------------
| Alleen admin: toevoegen, bewerken, verwijderen
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/games/create', [GameController::class, 'create']);
    Route::post('/games/store', [GameController::class, 'store']);

    Route::get('/games/edit/{id}', [GameController::class, 'edit']);
    Route::post('/games/update/{id}', [GameController::class, 'update']);

    Route::post('/games/destroy/{id}', [GameController::class, 'destroy']);
});

/*
|--------------------------------------------------------------------------
| Beheeromgeving (alleen admin)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->prefix('beheer')->group(function () {

    // CRUD 1: Permissies
    Route::get('/permissions', [PermissionController::class, 'index']);
    Route::get('/permissions/create', [PermissionController::class, 'create']);
    Route::post('/permissions/store', [PermissionController::class, 'store']);
    Route::get('/permissions/edit/{id}', [PermissionController::class, 'edit']);
    Route::post('/permissions/update/{id}', [PermissionController::class, 'update']);
    Route::post('/permissions/destroy/{id}', [PermissionController::class, 'destroy']);

    // CRUD 2: Rollen
    Route::get('/roles', [RoleController::class, 'index']);
    Route::get('/roles/create', [RoleController::class, 'create']);
    Route::post('/roles/store', [RoleController::class, 'store']);
    Route::get('/roles/edit/{id}', [RoleController::class, 'edit']);
    Route::post('/roles/update/{id}', [RoleController::class, 'update']);
    Route::post('/roles/destroy/{id}', [RoleController::class, 'destroy']);

});

Route::get('/geheim', function () {
    return view('geheim');
})->middleware('auth');

require __DIR__.'/auth.php';