<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleAndPermissionSeeder::class,
        ]);

        // Create admin user
        $admin = User::factory()->create([
            'name' => 'Administrador',
            'email' => 'admin@acapolifal.com',
            'password' => bcrypt('admin123'),
        ]);
        $admin->assignRole('admin');

        // Create director user
        $director = User::factory()->create([
            'name' => 'Director',
            'email' => 'director@acapolifal.com',
            'password' => bcrypt('director123'),
        ]);
        $director->assignRole('director');

        // Create docente user
        $docente = User::factory()->create([
            'name' => 'Docente',
            'email' => 'docente@acapolifal.com',
            'password' => bcrypt('docente123'),
        ]);
        $docente->assignRole('docente');

        // Create estudiante user
        $estudiante = User::factory()->create([
            'name' => 'Estudiante',
            'email' => 'estudiante@acapolifal.com',
            'password' => bcrypt('estudiante123'),
        ]);
        $estudiante->assignRole('estudiante');

        // Create instructor user
        $instructor = User::factory()->create([
            'name' => 'Instructor',
            'email' => 'instructor@acapolifal.com',
            'password' => bcrypt('instructor123'),
        ]);
        $instructor->assignRole('instructor');
    }
}
