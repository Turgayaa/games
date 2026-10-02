<?php

namespace App\Http\Controllers\Beheer;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserRoleController extends Controller
{
    // Overzicht van alle koppelingen
    public function index()
    {
        $koppelingen = DB::table('model_has_roles')
            ->join('users', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('model_has_roles.model_type', User::class)
            ->select(
                'model_has_roles.role_id',
                'model_has_roles.model_id as user_id',
                'roles.name as role_name',
                'users.name as user_name',
                'users.email as user_email'
            )
            ->orderBy('users.name')
            ->get();

        return view('beheer.user_roles.index', compact('koppelingen'));
    }

    // Formulier om een koppeling te maken
    public function create()
    {
        $roles = Role::all();
        $users = User::all();

        return view('beheer.user_roles.create', compact('roles', 'users'));
    }

    // Opslaan van een nieuwe koppeling
    public function store(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $role = Role::findOrFail($request->role_id);
        $user = User::findOrFail($request->user_id);

        if ($user->hasRole($role->name)) {
            return back()->withInput()->withErrors(['user_id' => 'Deze gebruiker heeft deze rol al.']);
        }

        $user->assignRole($role);

        return redirect('/beheer/user-roles')->with('success', 'Rol gekoppeld aan gebruiker.');
    }

    // Formulier om een koppeling te wijzigen
    public function edit($role_id, $user_id)
    {
        $roles = Role::all();
        $users = User::all();

        return view('beheer.user_roles.edit', compact('roles', 'users', 'role_id', 'user_id'));
    }

    // Opslaan van de wijziging
    public function update(Request $request, $role_id, $user_id)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $oldRole = Role::findOrFail($role_id);
        $oldUser = User::findOrFail($user_id);
        $newRole = Role::findOrFail($request->role_id);
        $newUser = User::findOrFail($request->user_id);

        $isZelfde = ($request->role_id == $role_id && $request->user_id == $user_id);

        if (!$isZelfde && $newUser->hasRole($newRole->name)) {
            return back()->withInput()->withErrors(['user_id' => 'Deze gebruiker heeft deze rol al.']);
        }

        // Je mag je eigen admin-rol niet kwijtraken
        if (!$isZelfde && $oldUser->id == auth()->id() && $oldRole->name == 'admin') {
            return back()->withInput()->withErrors(['role_id' => 'Je kunt je eigen admin-rol niet wijzigen.']);
        }

        $oldUser->removeRole($oldRole);
        $newUser->assignRole($newRole);

        return redirect('/beheer/user-roles')->with('success', 'Koppeling aangepast.');
    }

    // Koppeling verwijderen
    public function destroy($role_id, $user_id)
    {
        $role = Role::findOrFail($role_id);
        $user = User::findOrFail($user_id);

        // Je mag je eigen admin-rol niet verwijderen
        if ($user->id == auth()->id() && $role->name == 'admin') {
            return redirect('/beheer/user-roles')->with('error', 'Je kunt je eigen admin-rol niet verwijderen.');
        }

        $user->removeRole($role);

        return redirect('/beheer/user-roles')->with('success', 'Koppeling verwijderd.');
    }
}