<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Spatie\Permission\Contracts\Role as ContractsRole;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
{
    // Crear permiso
    $permission = Permission::updateOrCreate([
        'name' => 'manage-roles',
        'guard_name' => 'web'
    ]);

    // Asignar permiso al rol "admin"
    $adminRole = Role::where('name', 'admin')->first();
    
    if ($adminRole) {
        $adminRole->givePermissionTo($permission);
    } else {
        $this->command->error('Rol "admin" no encontrado.');
    }
}
}



