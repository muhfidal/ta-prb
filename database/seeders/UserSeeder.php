<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin'
        ]);

        // Create Doctors
        $doctors = [
            [
                'name' => 'Dr. Budi Santoso',
                'email' => 'budi.santoso@example.com',
                'password' => Hash::make('doctor123'),
                'role' => 'doctor'
            ],
            [
                'name' => 'Dr. Siti Rahayu',
                'email' => 'siti.rahayu@example.com',
                'password' => Hash::make('doctor123'),
                'role' => 'doctor'
            ],
            [
                'name' => 'Dr. Ahmad Wijaya',
                'email' => 'ahmad.wijaya@example.com',
                'password' => Hash::make('doctor123'),
                'role' => 'doctor'
            ]
        ];

        foreach ($doctors as $doctor) {
            User::create($doctor);
        }

        // Create Staff
        $staffs = [
            [
                'name' => 'Rina Wati',
                'email' => 'rina.wati@example.com',
                'password' => Hash::make('staff123'),
                'role' => 'staff'
            ],
            [
                'name' => 'Joko Susilo',
                'email' => 'joko.susilo@example.com',
                'password' => Hash::make('staff123'),
                'role' => 'staff'
            ]
        ];

        foreach ($staffs as $staff) {
            User::create($staff);
        }
    }
}
