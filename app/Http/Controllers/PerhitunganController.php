<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\MatriksKriteria;
use App\Models\MatriksObat;
use App\Models\Medicine;
use App\Models\Disease;
use Illuminate\Http\Request;
use App\Services\FuzzyAHP;
use App\Models\PenilaianAlternatif;
use App\Models\Penyakit;
use App\Models\SpkRecommendationHistory;

class PerhitunganController extends Controller
{
    private $fuzzyAHP;

    public function __construct(FuzzyAHP $fuzzyAHP)
    {
        $this->fuzzyAHP = $fuzzyAHP;
    }

    public function bobot()
    {
        $kriteria = Kriteria::all();
        $matriks = MatriksKriteria::with(['kriteria1', 'kriteria2'])->get();
        return view('perhitungan.bobot', compact('kriteria', 'matriks'));
    }

    public function hitungBobot(Request $request)
    {
        $kriteria = Kriteria::all();
        $matriks = MatriksKriteria::with(['kriteria1', 'kriteria2'])->get();

        // Gunakan service FuzzyAHP untuk menghitung bobot
        $bobot = $this->fuzzyAHP->calculateCriteriaWeights($matriks);

        // Simpan bobot ke database
        foreach ($bobot as $id => $nilai) {
            Kriteria::where('id', $id)->update(['bobot' => $nilai]);
        }

        return view('perhitungan.bobot', compact('kriteria', 'matriks', 'bobot'))
            ->with('success', 'Perhitungan bobot berhasil dilakukan');
    }

    public function skor(Request $request)
    {
        $penyakitId = $request->input('penyakit_id');
        $penyakits = \App\Models\Penyakit::orderBy('nama_penyakit')->get();
        $selectedPenyakit = null;
        $obatIds = [];
        if ($penyakitId) {
            $selectedPenyakit = \App\Models\Penyakit::find($penyakitId);
            $obatIds = $selectedPenyakit ? $selectedPenyakit->medicines()->pluck('medicines.id')->toArray() : [];
        }
        $penilaian = \App\Models\PenilaianObatGlobal::with(['medicine', 'kriteria'])
            ->when($penyakitId, function($q) use ($obatIds) {
                return $q->whereIn('medicine_id', $obatIds);
            })
            ->get();
        $bobot = \App\Models\Kriteria::pluck('bobot', 'id')->toArray();
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
        return view('spk.perhitungan-skor', compact('skor', 'normal', 'crisp', 'bobotNama', 'penyakits', 'selectedPenyakit', 'penilaian'));
    }

    public function hitungSkor(Request $request)
    {
        $disease_id = $request->disease_id;
        $kriteria = Kriteria::all();
        $medicines = Medicine::all();
        $matriks = MatriksObat::where('disease_id', $disease_id)
            ->with(['disease', 'medicine1', 'medicine2', 'kriteria'])
            ->get();

        // Gunakan service FuzzyAHP untuk menghitung skor
        $skor = $this->fuzzyAHP->calculateMedicineScore($medicines, $matriks);

        return view('perhitungan.skor', compact('diseases', 'medicines', 'kriteria', 'matriks', 'skor'))
            ->with('success', 'Perhitungan skor berhasil dilakukan');
    }

    public function riwayatRekomendasi()
    {
        $riwayat = SpkRecommendationHistory::with(['patient', 'user'])->orderByDesc('created_at')->paginate(20);
        return view('spk.riwayat-rekomendasi', compact('riwayat'));
    }
}
