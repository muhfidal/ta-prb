<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Kriteria extends Model
{
    use HasFactory;

    // Specify the table name if it doesn't follow Laravel's naming convention
    protected $table = 'kriterias';

    // Define the fillable fields
    protected $fillable = [
        'nama_kriteria',
        'deskripsi',
        'tipe_kriteria',
        'bobot_l',
        'bobot_m',
        'bobot_u',
        'bobot_defuzzifikasi'
    ];

    protected $casts = [
        'bobot' => 'float',
        'status' => 'boolean'
    ];

    /**
     * Define a relationship with the PairwiseComparison model.
     * Assuming you have a PairwiseComparison model.
     */
    public function pairwiseComparisonsAsFirst(): HasMany
    {
        return $this->hasMany(PairwiseComparison::class, 'kriteria_id_1');
    }

    public function pairwiseComparisonsAsSecond(): HasMany
    {
        return $this->hasMany(PairwiseComparison::class, 'kriteria_id_2');
    }

    public function pengaturanFuzzy(): HasOne
    {
        return $this->hasOne(PengaturanFuzzy::class);
    }

    public function gejalaTambahan(): HasMany
    {
        return $this->hasMany(GejalaTambahan::class);
    }

    public function getAllComparisons()
    {
        return $this->pairwiseComparisonsAsFirst()
            ->union($this->pairwiseComparisonsAsSecond())
            ->get();
    }

    public function getFuzzyWeight()
    {
        $comparisons = $this->getAllComparisons();
        $fuzzySum = [0, 0, 0];

        foreach ($comparisons as $comparison) {
            $scale = $this->getFuzzyScale($comparison->nilai);
            if ($comparison->kriteria_id_1 == $this->id) {
                $fuzzySum = [
                    $fuzzySum[0] + $scale[0],
                    $fuzzySum[1] + $scale[1],
                    $fuzzySum[2] + $scale[2]
                ];
            }
        }

        return $fuzzySum;
    }

    private function getFuzzyScale($value)
    {
        $scale = [
            '1' => [1, 1, 1],
            '2' => [1, 2, 3],
            '3' => [2, 3, 4],
            '4' => [3, 4, 5],
            '5' => [4, 5, 6],
            '6' => [5, 6, 7],
            '7' => [6, 7, 8],
            '8' => [7, 8, 9],
            '9' => [9, 9, 9]
        ];

        return $scale[$value] ?? [1, 1, 1];
    }

    public function matriksKriteria1()
    {
        return $this->hasMany(MatriksKriteria::class, 'kriteria1_id');
    }

    public function matriksKriteria2()
    {
        return $this->hasMany(MatriksKriteria::class, 'kriteria2_id');
    }

    public function matriksObat()
    {
        return $this->hasMany(MatriksObat::class);
    }
}
