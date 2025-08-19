<?php
namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder {
    
public function run(): void {
    $roles = [
        [
            'id' => 1, // Fuerza el ID 1
            'name_rol' => 'Administrador',
            'slug' => 'admin', // ¡Debe coincidir exactamente con la constante!
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'id' => 2, // Fuerza el ID 2
            'name_rol' => 'Usuario',
            'slug' => 'usuario', // Coincide con Role::USUARIO
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'id' => 3, // Fuerza el ID 2
            'name_rol' => 'Instructor',
            'slug' => 'instructor',
            'created_at' => now(),
            'updated_at' => now()
        ]

        
    ];

    foreach ($roles as $role) {
        Role::updateOrCreate(
            ['slug' => $role['slug']],
            $role
        );
    }
}
}