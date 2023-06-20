<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB as FacadesDB;

class RolePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $adminRole = FacadesDB::table('roles')->where('name', 'admin')->first();
        $jugadorRole = FacadesDB::table('roles')->where('name', 'jugador')->first();

        $adminPermissions = [
            'create_juego',
            'delete_juego',
            'update_juego',
            'create_ganador_individual',
            'delete_ganador_individual',
            'update_ganador_individual',
            'create_ganador_grupal',
            'delete_ganador_grupal',
            'update_ganador_grupal'
        ];

        $jugadorPermissions = [
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
            'update_self_inscripcion_grupal'
        ];

        $this->attachPermissionsToRole($adminRole, $adminPermissions);
        $this->attachPermissionsToRole($jugadorRole, $jugadorPermissions);
    }

    private function attachPermissionsToRole($role, $permissions)
    {
        $permissionIds = FacadesDB::table('permissions')
            ->whereIn('name', $permissions)
            ->pluck('id');

        FacadesDB::table('role_permissions')->insert(
            $permissionIds->map(function ($permissionId) use ($role) {
                return [
                    'role_id' => $role->id,
                    'permission_id' => $permissionId,
                ];
            })->toArray()
        );
    }
}
