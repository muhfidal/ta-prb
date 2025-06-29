<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Medicine;
use App\Models\Kriteria;
use App\Models\PenilaianObatGlobal;

class PenilaianObatGlobalSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'Paracetamol' => [
                'Efikasi Terapi' => [8, 9, 10],
                'Keamanan' => [9, 10, 10],
                'Kepatuhan Penggunaan' => [9, 10, 10],
                'Kesesuaian Pedoman' => [9, 10, 10],
                'Interaksi dan Komorbiditas' => [9, 10, 10],
                'Ketersediaan dan Aksesibilitas' => [10, 10, 10],
            ],
            'Ibuprofen' => [
                'Efikasi Terapi' => [7, 8, 9],
                'Keamanan' => [7, 8, 9],
                'Kepatuhan Penggunaan' => [8, 9, 10],
                'Kesesuaian Pedoman' => [8, 9, 10],
                'Interaksi dan Komorbiditas' => [7, 8, 9],
                'Ketersediaan dan Aksesibilitas' => [9, 10, 10],
            ],
            'Aspirin' => [
                'Efikasi Terapi' => [6, 7, 8],
                'Keamanan' => [5, 6, 7],
                'Kepatuhan Penggunaan' => [6, 7, 8],
                'Kesesuaian Pedoman' => [5, 6, 7],
                'Interaksi dan Komorbiditas' => [5, 6, 7],
                'Ketersediaan dan Aksesibilitas' => [7, 8, 9],
            ],
            'Naproxen' => [
                'Efikasi Terapi' => [7, 8, 9],
                'Keamanan' => [7, 8, 9],
                'Kepatuhan Penggunaan' => [7, 8, 9],
                'Kesesuaian Pedoman' => [7, 8, 9],
                'Interaksi dan Komorbiditas' => [7, 8, 9],
                'Ketersediaan dan Aksesibilitas' => [7, 8, 9],
            ],
            'Decolgen' => [
                'Efikasi Terapi' => [6, 7, 8],
                'Keamanan' => [6, 7, 8],
                'Kepatuhan Penggunaan' => [7, 8, 9],
                'Kesesuaian Pedoman' => [6, 7, 8],
                'Interaksi dan Komorbiditas' => [6, 7, 8],
                'Ketersediaan dan Aksesibilitas' => [8, 9, 10],
            ],
            'Oralit' => [
                'Efikasi Terapi' => [8, 9, 10],
                'Keamanan' => [10, 10, 10],
                'Kepatuhan Penggunaan' => [9, 10, 10],
                'Kesesuaian Pedoman' => [9, 10, 10],
                'Interaksi dan Komorbiditas' => [10, 10, 10],
                'Ketersediaan dan Aksesibilitas' => [9, 10, 10],
            ],
            'Loperamide' => [
                'Efikasi Terapi' => [7, 8, 9],
                'Keamanan' => [6, 7, 8],
                'Kepatuhan Penggunaan' => [6, 7, 8],
                'Kesesuaian Pedoman' => [7, 8, 9],
                'Interaksi dan Komorbiditas' => [6, 7, 8],
                'Ketersediaan dan Aksesibilitas' => [8, 9, 10],
            ],
            'Metronidazole' => [
                'Efikasi Terapi' => [6, 7, 8],
                'Keamanan' => [7, 8, 9],
                'Kepatuhan Penggunaan' => [7, 8, 9],
                'Kesesuaian Pedoman' => [7, 8, 9],
                'Interaksi dan Komorbiditas' => [7, 8, 9],
                'Ketersediaan dan Aksesibilitas' => [7, 8, 9],
            ],
        ];

        foreach ($data as $medicineName => $kriterias) {
            $medicine = Medicine::where('name', $medicineName)->first();
            if (!$medicine) continue;
            foreach ($kriterias as $kriteriaName => $nilai) {
                $kriteria = Kriteria::where('nama_kriteria', $kriteriaName)->first();
                if (!$kriteria) continue;
                PenilaianObatGlobal::updateOrCreate(
                    [
                        'medicine_id' => $medicine->id,
                        'kriteria_id' => $kriteria->id,
                    ],
                    [
                        'nilai_l' => $nilai[0],
                        'nilai_m' => $nilai[1],
                        'nilai_u' => $nilai[2],
                    ]
                );
            }
        }
    }
}
