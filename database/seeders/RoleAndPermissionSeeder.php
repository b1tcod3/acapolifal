<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Dashboard
            'dashboard.view',

            // Users
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',

            // Roles & Permissions
            'roles.view',
            'roles.create',
            'roles.edit',
            'roles.delete',
            'permissions.view',
            'permissions.create',
            'permissions.edit',
            'permissions.delete',

            // Docentes Module
            'docentes.view',
            'docentes.create',
            'docentes.edit',
            'docentes.delete',
            'docentes.horarios.view',
            'docentes.horarios.create',
            'docentes.horarios.edit',
            'docentes.horarios.delete',
            'docentes.ausencias.view',
            'docentes.ausencias.create',
            'docentes.ausencias.edit',
            'docentes.ausencias.delete',
            'docentes.asignacion.view',
            'docentes.asignacion.create',
            'docentes.asignacion.edit',
            'docentes.asignacion.delete',
            'docentes.notas.view',
            'docentes.notas.create',
            'docentes.notas.edit',
            'docentes.notas.delete',
            'docentes.informes.view',
            'docentes.informes.create',
            'docentes.informes.edit',
            'docentes.informes.delete',
            'docentes.buscar',

            // Estudiantes Module
            'estudiantes.view',
            'estudiantes.create',
            'estudiantes.edit',
            'estudiantes.delete',
            'estudiantes.horarios.view',
            'estudiantes.asistencias.view',
            'estudiantes.asistencias.create',
            'estudiantes.asistencias.edit',
            'estudiantes.asistencias.delete',
            'estudiantes.notas.view',
            'estudiantes.informes.view',
            'estudiantes.buscar',

            // Instructores Module
            'instructores.view',
            'instructores.create',
            'instructores.edit',
            'instructores.delete',
            'instructores.matricula.view',
            'instructores.informes.view',

            // Horarios Module
            'horarios.view',
            'horarios.create',
            'horarios.edit',
            'horarios.delete',
            'horarios.periodos.view',
            'horarios.periodos.create',
            'horarios.periodos.edit',
            'horarios.periodos.delete',
            'horarios.aulas.view',
            'horarios.aulas.create',
            'horarios.aulas.edit',
            'horarios.aulas.delete',
            'horarios.asignaturas.view',
            'horarios.asignaturas.create',
            'horarios.asignaturas.edit',
            'horarios.asignaturas.delete',
            'horarios.asistencias.view',
            'horarios.asistencias.create',
            'horarios.asistencias.edit',
            'horarios.asistencias.delete',
            'horarios.estadisticas.view',

            // Export & Print
            'exportar',
            'imprimir',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'director']);
        $role->givePermissionTo([
            'dashboard.view',
            'users.view',
            'docentes.view',
            'docentes.create',
            'docentes.edit',
            'docentes.delete',
            'docentes.horarios.view',
            'docentes.ausencias.view',
            'docentes.asignacion.view',
            'docentes.notas.view',
            'docentes.informes.view',
            'docentes.buscar',
            'estudiantes.view',
            'estudiantes.create',
            'estudiantes.edit',
            'estudiantes.delete',
            'estudiantes.horarios.view',
            'estudiantes.asistencias.view',
            'estudiantes.notas.view',
            'estudiantes.informes.view',
            'estudiantes.buscar',
            'instructores.view',
            'instructores.create',
            'instructores.edit',
            'instructores.delete',
            'instructores.matricula.view',
            'instructores.informes.view',
            'horarios.view',
            'horarios.periodos.view',
            'horarios.periodos.create',
            'horarios.periodos.edit',
            'horarios.periodos.delete',
            'horarios.aulas.view',
            'horarios.aulas.create',
            'horarios.aulas.edit',
            'horarios.aulas.delete',
            'horarios.asignaturas.view',
            'horarios.asignaturas.create',
            'horarios.asignaturas.edit',
            'horarios.asignaturas.delete',
            'horarios.estadisticas.view',
            'exportar',
            'imprimir',
        ]);

        $role = Role::create(['name' => 'docente']);
        $role->givePermissionTo([
            'dashboard.view',
            'docentes.horarios.view',
            'docentes.ausencias.view',
            'docentes.ausencias.create',
            'docentes.notas.view',
            'docentes.notas.create',
            'docentes.notas.edit',
            'docentes.informes.view',
            'estudiantes.view',
            'estudiantes.horarios.view',
            'estudiantes.asistencias.view',
            'estudiantes.notas.view',
            'exportar',
            'imprimir',
        ]);

        $role = Role::create(['name' => 'estudiante']);
        $role->givePermissionTo([
            'dashboard.view',
            'estudiantes.horarios.view',
            'estudiantes.notas.view',
            'estudiantes.informes.view',
            'exportar',
            'imprimir',
        ]);

        $role = Role::create(['name' => 'instructor']);
        $role->givePermissionTo([
            'dashboard.view',
            'instructores.matricula.view',
            'instructores.informes.view',
            'estudiantes.view',
            'estudiantes.notas.view',
            'exportar',
            'imprimir',
        ]);
    }
}
