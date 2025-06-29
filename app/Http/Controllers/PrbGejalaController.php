<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SpkRecommendationHistory;
use Illuminate\Support\Facades\Auth;
use App\Models\Patient;
use App\Models\Penyakit;

class PrbGejalaController extends Controller
{
    public function resep()
    {
        $patients = Patient::all();
        $penyakits = Penyakit::all();
        $medicines = \App\Models\Medicine::all(['name', 'dose', 'quantity', 'description']);
        return view('prb-gejala.resep', compact('patients', 'penyakits', 'medicines'));
    }

    public function rekomendasiAjax(Request $request)
    {
        $request->validate([
            'penyakit_ids' => 'required|array',
            'penyakit_ids.*' => 'exists:penyakits,id',
        ]);
        $penyakitIds = $request->input('penyakit_ids');
        $obatIds = [];
        foreach ($penyakitIds as $pid) {
            $penyakit = \App\Models\Penyakit::find($pid);
            if ($penyakit) {
                $obatIds = array_merge($obatIds, $penyakit->medicines()->pluck('medicines.id')->toArray());
            }
        }
        $obatIds = array_unique($obatIds);
        $penilaian = \App\Models\PenilaianObatGlobal::with(['medicine', 'kriteria'])
            ->whereIn('medicine_id', $obatIds)
            ->get();
        $bobotNama = \App\Models\Kriteria::pluck('bobot', 'nama_kriteria')->toArray();
        $crisp = [];
        foreach ($penilaian as $p) {
            $crisp[$p->medicine->name][$p->kriteria->nama_kriteria] = ($p->nilai_l + 4 * $p->nilai_m + $p->nilai_u) / 6;
        }
        $max = [];
        foreach ($crisp as $obat) {
            foreach ($obat as $kriteria => $nilai) {
                $max[$kriteria] = max($max[$kriteria] ?? 0, $nilai);
            }
        }
        $normal = [];
        foreach ($crisp as $obat => $kriteriaArr) {
            foreach ($kriteriaArr as $kriteria => $nilai) {
                $normal[$obat][$kriteria] = $nilai / ($max[$kriteria] ?: 1);
            }
        }
        $skor = [];
        foreach ($normal as $obat => $kriteriaArr) {
            $skor[$obat] = 0;
            foreach ($kriteriaArr as $kriteria => $nilai) {
                $skor[$obat] += $nilai * ($bobotNama[$kriteria] ?? 0);
            }
        }
        arsort($skor);
        $result = [];
        foreach ($skor as $obat => $nilai) {
            $result[] = [
                'obat' => $obat,
                'skor' => $nilai,
            ];
        }
        return response()->json([
            'success' => true,
            'data' => $result,
        ]);
    }

    public function simpanRiwayatRekomendasi(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'penyakit_ids' => 'required|array',
            'penyakit_ids.*' => 'exists:penyakits,id',
            'taken_medicines' => 'nullable|array',
        ]);

        $penyakitIds = $request->input('penyakit_ids');

        $obatIds = [];
        foreach ($penyakitIds as $pid) {
            $penyakit = \App\Models\Penyakit::find($pid);
            if ($penyakit) {
                $obatIds = array_merge($obatIds, $penyakit->medicines()->pluck('medicines.id')->toArray());
            }
        }
        $obatIds = array_unique($obatIds);

        $penilaian = \App\Models\PenilaianObatGlobal::with(['medicine', 'kriteria'])
            ->whereIn('medicine_id', $obatIds)
            ->get();

        $bobotNama = \App\Models\Kriteria::pluck('bobot', 'nama_kriteria')->toArray();

        $crisp = [];
        foreach ($penilaian as $p) {
            $crisp[$p->medicine->name][$p->kriteria->nama_kriteria] = ($p->nilai_l + 4 * $p->nilai_m + $p->nilai_u) / 6;
        }

        $max = [];
        foreach ($crisp as $obat) {
            foreach ($obat as $kriteria => $nilai) {
                $max[$kriteria] = max($max[$kriteria] ?? 0, $nilai);
            }
        }

        $normal = [];
        foreach ($crisp as $obat => $kriteriaArr) {
            foreach ($kriteriaArr as $kriteria => $nilai) {
                $normal[$obat][$kriteria] = $nilai / ($max[$kriteria] ?: 1);
            }
        }

        $skor = [];
        foreach ($normal as $obat => $kriteriaArr) {
            $skor[$obat] = 0;
            foreach ($kriteriaArr as $kriteria => $nilai) {
                $skor[$obat] += $nilai * ($bobotNama[$kriteria] ?? 0);
            }
        }

        arsort($skor);

        $recalculatedRecommendations = [];
        foreach ($skor as $obat => $nilai) {
            $recalculatedRecommendations[] = [
                'obat' => $obat,
                'skor' => $nilai,
            ];
        }

        $riwayat = SpkRecommendationHistory::create([
            'patient_id' => $request->patient_id,
            'user_id' => Auth::id(),
            'penyakit_ids' => $request->penyakit_ids,
            'rekomendasi' => $recalculatedRecommendations,
            'taken_medicines' => $request->taken_medicines,
        ]);

        return response()->json(['success' => true, 'id' => $riwayat->id]);
    }

    public function printView(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'penyakit_ids' => 'required',
            'rekomendasi' => 'required',
            'resep' => 'required',
        ]);
        $patient = \App\Models\Patient::find($request->patient_id);
        $penyakitIds = json_decode($request->penyakit_ids, true);
        $penyakits = \App\Models\Penyakit::whereIn('id', $penyakitIds)->get();
        $rekomendasi = json_decode($request->rekomendasi, true);
        $resep = json_decode($request->resep, true);
        return view('prb-gejala.print', compact('patient', 'penyakits', 'rekomendasi', 'resep'));
    }
}
