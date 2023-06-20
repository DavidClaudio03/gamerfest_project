<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        try {
            $permissions = Permission::all();
            return response()->json($permissions);
        } catch (\Exception $e) {
            return response()->json(['message' => "Error al obtener permisos: " . $e->getMessage()], 500);
        }
    }

    public function show(Permission $permission)
    {
        try {
            return response()->json($permission->load('roles'));
        } catch (\Exception $e) {
            return response()->json(['message' => "Error al obtener el permiso: " . $e->getMessage()], 500);
        }
    }
}
