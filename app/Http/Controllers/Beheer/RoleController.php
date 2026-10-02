<?php

namespace App\Http\Controllers\Beheer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    // Overzicht van alle rollen
    public function index()
    {
        $roles = Role::all();
        return view('beheer.roles.index', compact('roles'));
    }

    // Formulier om een rol toe te voegen
    public function create()
    {
        return view('beheer.roles.create');
    }

    // Opslaan van een nieuwe rol
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:roles,name',
        ]);

        Role::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        return redirect('/beheer/roles')->with('success', 'Rol toegevoegd.');
    }

    // Formulier om een rol te bewerken
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('beheer.roles.edit', compact('role'));
    }

    // Opslaan van de aanpassing
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'name' => 'required|max:255|unique:roles,name,' . $role->id,
        ]);

        $role->update(['name' => $request->name]);

        return redirect('/beheer/roles')->with('success', 'Rol aangepast.');
    }

    // Verwijderen (admin en klant mogen niet weg)
    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        if (in_array($role->name, ['admin', 'klant'])) {
            return redirect('/beheer/roles')->with('error', 'De rollen admin en klant kun je niet verwijderen.');
        }

        $role->delete();

        return redirect('/beheer/roles')->with('success', 'Rol verwijderd.');
    }
}