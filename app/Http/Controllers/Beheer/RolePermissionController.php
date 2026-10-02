<?php

namespace App\Http\Controllers\Beheer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    // Overzicht van alle koppelingen
    public function index()
    {
        $koppelingen = DB::table('role_has_permissions')
            ->join('permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
            ->join('roles', 'roles.id', '=', 'role_has_permissions.role_id')
            ->select(
                'role_has_permissions.permission_id',
                'role_has_permissions.role_id',
                'permissions.name as permission_name',
                'roles.name as role_name'
            )
            ->orderBy('roles.name')
            ->get();

        return view('beheer.role_permissions.index', compact('koppelingen'));
    }

    // Formulier om een koppeling te maken
    public function create()
    {
        $permissions = Permission::all();
        $roles = Role::all();

        return view('beheer.role_permissions.create', compact('permissions', 'roles'));
    }

    // Opslaan van een nieuwe koppeling
    public function store(Request $request)
    {
        $request->validate([
            'permission_id' => 'required|exists:permissions,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        $role = Role::findOrFail($request->role_id);
        $permission = Permission::findOrFail($request->permission_id);

        if ($role->hasPermissionTo($permission)) {
            return back()->withInput()->withErrors(['role_id' => 'Deze koppeling bestaat al.']);
        }

        $role->givePermissionTo($permission);

        return redirect('/beheer/role-permissions')->with('success', 'Koppeling toegevoegd.');
    }

    // Formulier om een koppeling te wijzigen
    public function edit($permission_id, $role_id)
    {
        $permissions = Permission::all();
        $roles = Role::all();

        return view('beheer.role_permissions.edit', compact('permissions', 'roles', 'permission_id', 'role_id'));
    }

    // Opslaan van de wijziging
    public function update(Request $request, $permission_id, $role_id)
    {
        $request->validate([
            'permission_id' => 'required|exists:permissions,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        $newRole = Role::findOrFail($request->role_id);
        $newPermission = Permission::findOrFail($request->permission_id);

        $isZelfde = ($request->permission_id == $permission_id && $request->role_id == $role_id);

        if (!$isZelfde && $newRole->hasPermissionTo($newPermission)) {
            return back()->withInput()->withErrors(['role_id' => 'Deze koppeling bestaat al.']);
        }

        // Oude koppeling weghalen, nieuwe maken
        $oldRole = Role::findOrFail($role_id);
        $oldPermission = Permission::findOrFail($permission_id);
        $oldRole->revokePermissionTo($oldPermission);

        $newRole->givePermissionTo($newPermission);

        return redirect('/beheer/role-permissions')->with('success', 'Koppeling aangepast.');
    }

    // Koppeling verwijderen
    public function destroy($permission_id, $role_id)
    {
        $role = Role::findOrFail($role_id);
        $permission = Permission::findOrFail($permission_id);

        $role->revokePermissionTo($permission);

        return redirect('/beheer/role-permissions')->with('success', 'Koppeling verwijderd.');
    }
}