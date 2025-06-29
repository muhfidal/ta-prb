<?php

namespace App\Services;

use App\Models\Medicine;
use App\Models\Disease;
use App\Models\Kriteria;
use App\Models\MatriksKriteria;
use App\Models\MatriksObat;

class FuzzyAHP
{
    private $fuzzyScale = [
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

    public function calculateCriteriaWeights($matriks)
    {
        $weights = [];
        $total = 0;
        $kriteriaIds = Kriteria::pluck('id')->toArray();

        // Step 1: Hitung Synthetic Extent untuk setiap kriteria
        $syntheticExtent = [];
        foreach ($kriteriaIds as $kriteriaId) {
            $fuzzySum = [1, 1, 1]; // Mulai dari (1,1,1) untuk diagonal
            $matriksForKriteria = $matriks->filter(function($item) use ($kriteriaId) {
                return $item->kriteria1_id == $kriteriaId && $item->kriteria2_id != $kriteriaId;
            });

            foreach ($matriksForKriteria as $row) {
                $fuzzySum[0] += $row->nilai_l;
                $fuzzySum[1] += $row->nilai_m;
                $fuzzySum[2] += $row->nilai_u;
            }

            $syntheticExtent[$kriteriaId] = $fuzzySum;
            info("Synthetic Extent Kriteria $kriteriaId: [" . implode(", ", $fuzzySum) . "]");
        }

        // Step 2: Normalisasi nilai fuzzy
        $totalSum = [0, 0, 0];
        foreach ($syntheticExtent as $fuzzyValues) {
            $totalSum[0] += $fuzzyValues[0];
            $totalSum[1] += $fuzzyValues[1];
            $totalSum[2] += $fuzzyValues[2];
        }

        foreach ($syntheticExtent as $kriteriaId => $fuzzyValues) {
            $syntheticExtent[$kriteriaId] = [
                $fuzzyValues[0] / $totalSum[2],
                $fuzzyValues[1] / $totalSum[1],
                $fuzzyValues[2] / $totalSum[0]
            ];
            info("Normalized Synthetic Extent Kriteria $kriteriaId: [" . implode(", ", $syntheticExtent[$kriteriaId]) . "]");
        }

        // Step 3: Hitung derajat kemungkinan
        $weights = [];
        foreach ($kriteriaIds as $kriteriaId) {
            $minDegree = PHP_FLOAT_MAX;
            foreach ($kriteriaIds as $compareId) {
                if ($kriteriaId != $compareId) {
                    $degree = $this->calculatePossibilityDegree(
                        $syntheticExtent[$kriteriaId],
                        $syntheticExtent[$compareId]
                    );
                    info("Possibility Degree $kriteriaId vs $compareId: $degree");
                    $minDegree = min($minDegree, $degree);
                }
            }
            $weights[$kriteriaId] = $minDegree;
            info("Min Possibility Degree Kriteria $kriteriaId: $minDegree");
        }

        // Step 4: Normalisasi bobot
        $total = array_sum($weights);
        if ($total > 0) {
            foreach ($weights as &$weight) {
                $weight = $weight / $total;
            }
        }

        info('Final Weights: ' . json_encode($weights));
        return $weights;
    }

    public function calculateMedicineScore($medicines, $matriks)
    {
        $scores = [];
        $kriteriaBobot = Kriteria::pluck('bobot', 'id')->toArray();

        foreach ($medicines as $medicine) {
            $totalScore = 0;
            foreach ($kriteriaBobot as $kriteriaId => $bobot) {
                $matriksForMedicine = $matriks->filter(function($item) use ($medicine, $kriteriaId) {
                    return $item->medicine1_id == $medicine->id && $item->kriteria_id == $kriteriaId;
                });

                $fuzzySum = [0, 0, 0];
                foreach ($matriksForMedicine as $row) {
                    $fuzzySum[0] += $row->nilai_l;
                    $fuzzySum[1] += $row->nilai_m;
                    $fuzzySum[2] += $row->nilai_u;
                }

                // Defuzzifikasi menggunakan metode centroid
                $score = ($fuzzySum[0] + $fuzzySum[1] + $fuzzySum[2]) / 3;
                $totalScore += $score * $bobot;
            }
            $scores[$medicine->id] = $totalScore;
        }

        return $scores;
    }

    private function calculatePossibilityDegree($fuzzy1, $fuzzy2)
    {
        if ($fuzzy1[1] >= $fuzzy2[1]) {
            return 1;
        }
        if ($fuzzy2[0] >= $fuzzy1[2]) {
            return 0;
        }
        $denominator = (($fuzzy1[1] - $fuzzy1[2]) - ($fuzzy2[1] - $fuzzy2[0]));
        if ($denominator == 0) {
            return 0;
        }
        $result = ($fuzzy2[0] - $fuzzy1[2]) / $denominator;
        return max(0, min(1, $result)); // pastikan hasil di antara 0 dan 1
    }
}
