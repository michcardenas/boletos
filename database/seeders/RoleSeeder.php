<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Permisos
        $permissions = [
            // Usuarios
            'users.index',
            'users.create',
            'users.edit',
            'users.delete',

            // Registros / Asistentes
            'registros.index',
            'registros.create',
            'registros.edit',
            'registros.delete',
            'registros.export',

            // Boletas / Entradas
            'boletas.index',
            'boletas.create',
            'boletas.edit',
            'boletas.delete',

            // Donaciones
            'donaciones.index',
            'donaciones.create',
            'donaciones.edit',
            'donaciones.delete',

            // Aliados
            'aliados.index',
            'aliados.create',
            'aliados.edit',
            'aliados.delete',

            // Contacto
            'contactos.index',
            'contactos.delete',

            // Configuración
            'settings.index',
            'settings.edit',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Roles
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());

        $editor = Role::create(['name' => 'editor']);
        $editor->givePermissionTo([
            'registros.index',
            'registros.create',
            'registros.edit',
            'registros.export',
            'boletas.index',
            'boletas.create',
            'boletas.edit',
            'donaciones.index',
            'aliados.index',
            'contactos.index',
        ]);

        $viewer = Role::create(['name' => 'viewer']);
        $viewer->givePermissionTo([
            'registros.index',
            'boletas.index',
            'donaciones.index',
            'aliados.index',
            'contactos.index',
        ]);
    }
}