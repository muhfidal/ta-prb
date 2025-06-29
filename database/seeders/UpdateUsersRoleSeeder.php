<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UpdateUsersRoleSeeder extends Seeder
{
    public function run()
    {
        // Update existing admin user
        User::where('email', 'admin@admin.com')
            ->update(['role' => 'admin']);

        // Create doctor users
        $doctors = [
            [
                'name' => 'Dr. Budi Santoso',
                'email' => 'budi.santoso@example.com',
                'password' => Hash::make('password123'),
                'role' => 'doctor'
            ],
            [
                'name' => 'Dr. Siti Rahayu',
                'email' => 'siti.rahayu@example.com',
                'password' => Hash::make('password123'),
                'role' => 'doctor'
            ]
        ];

        foreach ($doctors as $doctor) {
            User::create($doctor);
        }

        // Update remaining users as staff
        User::whereNull('role')
            ->update(['role' => 'staff']);
    }
}
