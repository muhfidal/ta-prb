<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Disease;

class DiseaseSeeder extends Seeder
{
    public function run(): void
    {
        $diseases = [
            [
                'name' => 'Diabetes Melitus',
                'description' => 'Penyakit metabolik yang ditandai dengan kadar gula darah tinggi'
            ],
            [
                'name' => 'Hipertensi',
                'description' => 'Tekanan darah tinggi yang dapat menyebabkan masalah kesehatan serius'
            ],
            [
                'name' => 'Asma',
                'description' => 'Penyakit pernapasan kronis yang menyebabkan peradangan dan penyempitan saluran udara'
            ],
            [
                'name' => 'Epilepsi',
                'description' => 'Gangguan sistem saraf yang menyebabkan kejang'
            ],
            [
                'name' => 'Jantung Koroner',
                'description' => 'Penyakit jantung yang disebabkan oleh penyempitan pembuluh darah koroner'
            ]
        ];

        foreach ($diseases as $disease) {
            Disease::create($disease);
        }
    }
}
