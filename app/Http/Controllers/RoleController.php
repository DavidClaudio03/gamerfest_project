<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        try {
            $roles = Role::all();
            return response()->json($roles);
        } catch (\Exception $e) {
            return response()->json(['message' => "Error al obtener roles: " . $e->getMessage()], 500);
        }
    }

    public function show(Role $role)
    {
        try {
            return response()->json($role->load('permissions'));
        } catch (\Exception $e) {
            return response()->json(['message' => "Error al obtener el rol: " . $e->getMessage()], 500);
        }
    }

    public function hasPermission(Role $role, string $permissionName)
    {
        try {
            $hasPermission = $role->permissions->contains('name', $permissionName);
            return response()->json(['hasPermission' => $hasPermission]);
        } catch (\Exception $e) {
            return response()->json(['message' => "Error al validar permiso: " . $e->getMessage()], 500);
        }
    }
}
