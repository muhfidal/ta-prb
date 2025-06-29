<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Patient;
use App\Models\User;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $patients = [
            [
                'name' => 'Bambang Suryanto',
                'gender' => 'L',
                'address' => 'Jl. Mawar No. 10, Jakarta Selatan',
                'birth_date' => '1965-03-15',
                'no_bpjs' => '0001234567890',
                'created_by' => User::where('role', 'staff')->first()->id
            ],
            [
                'name' => 'Sri Wahyuni',
                'gender' => 'P',
                'address' => 'Jl. Melati No. 23, Jakarta Timur',
                'birth_date' => '1970-08-22',
                'no_bpjs' => '0001234567891',
                'created_by' => User::where('role', 'staff')->first()->id
            ],
            [
                'name' => 'Agus Darmawan',
                'gender' => 'L',
                'address' => 'Jl. Anggrek No. 45, Jakarta Barat',
                'birth_date' => '1958-11-30',
                'no_bpjs' => '0001234567892',
                'created_by' => User::where('role', 'staff')->first()->id
            ],
            [
                'name' => 'Siti Aminah',
                'gender' => 'P',
                'address' => 'Jl. Dahlia No. 17, Jakarta Utara',
                'birth_date' => '1962-05-10',
                'no_bpjs' => '0001234567893',
                'created_by' => User::where('role', 'staff')->first()->id
            ],
            [
                'name' => 'Hadi Santoso',
                'gender' => 'L',
                'address' => 'Jl. Kenanga No. 8, Jakarta Pusat',
                'birth_date' => '1968-09-25',
                'no_bpjs' => '0001234567894',
                'created_by' => User::where('role', 'staff')->first()->id
            ]
        ];

        foreach ($patients as $patient) {
            Patient::create($patient);
        }
    }
}
