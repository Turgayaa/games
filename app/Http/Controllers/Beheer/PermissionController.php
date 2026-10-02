<?php

namespace App\Http\Controllers\Beheer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    // Overzicht van alle permissies
    public function index()
    {
        $permissions = Permission::all();
        return view('beheer.permissions.index', compact('permissions'));
    }

    // Formulier om een permissie toe te voegen
    public function create()
    {
        return view('beheer.permissions.create');
    }

    // Opslaan van een nieuwe permissie
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:permissions,name',
        ]);

        Permission::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        return redirect('/beheer/permissions')->with('success', 'Permissie toegevoegd.');
    }

    // Formulier om een permissie te bewerken
    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        return view('beheer.permissions.edit', compact('permission'));
    }

    // Opslaan van de aanpassing
    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);

        $request->validate([
            'name' => 'required|max:255|unique:permissions,name,' . $permission->id,
        ]);

        $permission->update(['name' => $request->name]);

        return redirect('/beheer/permissions')->with('success', 'Permissie aangepast.');
    }

    // Verwijderen
    public function destroy($id)
    {
        Permission::findOrFail($id)->delete();

        return redirect('/beheer/permissions')->with('success', 'Permissie verwijderd.');
    }
}