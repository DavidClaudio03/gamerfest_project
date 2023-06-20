<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Permission;
use App\Models\Role;
use Carbon\Carbon;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crear algunos permisos
        $permisos = [
            'register_user',
            'login_user',
            'view_juegos',
            'view_self_user',
            'logout_self',
            'view_participantes',
            'view_self_participante',
            'create_participante',
            'delete_self_participante',
            'update_self_participante',
            'view_equipos',
            'view_self_equipo',
            'create_equipo',
            'delete_self_equipo',
            'update_self_equipo',
            'view_ganadores_individuales',
            'view_self_ganador_individual',
            'view_ganadores_grupales',
            'view_self_ganador_grupal',
            'view_inscripciones_individuales',
            'view_self_inscripcion_individual',
            'create_inscripcion_individual',
            'delete_self_inscripcion_individual',
            'update_self_inscripcion_individual',
            'view_inscripciones_grupales',
            'view_self_inscripcion_grupal',
            'create_inscripcion_grupal',
            'delete_self_inscripcion_grupal',
            'update_self_inscripcion_grupal',
            'create_juego',
            'delete_juego',
            'update_juego',
            'create_ganador_individual',
            'delete_ganador_individual',
            'update_ganador_individual',
            'create_ganador_grupal',
            'delete_ganador_grupal',
            'update_ganador_grupal',
        ];

        foreach ($permisos as $permiso) {
            Permission::create([
                'name' => $permiso,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        // Asignar todos los permisos al rol de administrador
        // $administrador = Role::where('name', 'admin')->firstOrFail();
        // $todosPermisos = Permission::all();
        // $administrador->permissions()->attach($todosPermisos);
    }
}
