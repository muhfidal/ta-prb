<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Disease;
use App\Services\FuzzyAHP;
use Illuminate\Http\Request;

class MedicineRecommendationController extends Controller
{
    protected $fuzzyAHP;

    public function __construct(FuzzyAHP $fuzzyAHP)
    {
        $this->fuzzyAHP = $fuzzyAHP;
    }

    public function getRecommendations(Request $request)
    {
        $request->validate([
            'disease_id' => 'required|exists:diseases,id',
            'symptoms' => 'required|array',
            'symptoms.*.id' => 'required|exists:symptoms,id',
            'symptoms.*.severity' => 'required|numeric|min:1|max:10'
        ]);

        $disease = Disease::findOrFail($request->disease_id);
        $medicines = Medicine::where('disease_id', $disease->id)->get();

        $recommendations = [];
        foreach ($medicines as $medicine) {
            $score = $this->fuzzyAHP->calculateMedicineScore($medicine, $request->symptoms);

            $recommendations[] = [
                'medicine' => $medicine,
                'score' => $score,
                'dose' => $medicine->dose,
                'reason' => $medicine->reason
            ];
        }

        // Urutkan berdasarkan skor tertinggi
        usort($recommendations, function($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        return response()->json([
            'success' => true,
            'data' => $recommendations
        ]);
    }
}
