<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Kriteria;
use App\Models\MatriksKriteria;

class IsiMatriksKriteriaOtomatis extends Command
{
    protected $signature = 'matriks:isi-otomatis';
    protected $description = 'Mengisi matriks_kriterias secara otomatis dengan matriks perbandingan Fuzzy AHP yang benar-benar seimbang dan tidak ada bobot 0';

    public function handle()
    {
        $this->info('Mengisi matriks_kriterias dengan pola benar-benar seimbang (no bobot 0)...');
        $kriteria = Kriteria::all();
        $n = count($kriteria);
        foreach ($kriteria as $i => $k1) {
            foreach ($kriteria as $j => $k2) {
                if ($i < $j) {
                    // Pola rotasi: setiap kriteria dapat giliran mendapat nilai lebih besar
                    if ($j == ($i+1)%$n || $j == ($i+2)%$n) {
                        $nilai = [2,3,4];
                    } elseif ($j == ($i+3)%$n) {
                        $nilai = [1,2,3];
                    } else {
                        $nilai = [0.5,1,2];
                    }
                    MatriksKriteria::updateOrCreate([
                        'kriteria1_id' => $k1->id,
                        'kriteria2_id' => $k2->id
                    ], [
                        'nilai_l' => $nilai[0],
                        'nilai_m' => $nilai[1],
                        'nilai_u' => $nilai[2]
                    ]);
                    // Invers
                    MatriksKriteria::updateOrCreate([
                        'kriteria1_id' => $k2->id,
                        'kriteria2_id' => $k1->id
                    ], [
                        'nilai_l' => round(1/$nilai[2], 4),
                        'nilai_m' => round(1/$nilai[1], 4),
                        'nilai_u' => round(1/$nilai[0], 4)
                    ]);
                }
            }
        }
        $this->info('Matriks perbandingan berhasil diisi otomatis dengan pola benar-benar seimbang (no bobot 0)!');
    }
}
