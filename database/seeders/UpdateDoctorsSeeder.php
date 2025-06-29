<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Doctor;

class UpdateDoctorsSeeder extends Seeder
{
    public function run(): void
    {
        $doctors = User::where('role', 'doctor')->get();

        foreach ($doctors as $user) {
            Doctor::updateOrCreate(
                ['name' => $user->name],
                [
                    'user_id' => $user->id,
                    'specialization' => 'Umum'
                ]
            );
        }
    }
}
