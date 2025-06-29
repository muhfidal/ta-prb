<?php

namespace App\Http\Controllers;

use App\Models\PenilaianObatGlobal;
use App\Models\Medicine;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class PenilaianObatGlobalController extends Controller
{
    public function index()
    {
        $medicines = Medicine::orderBy('name')->get();
        $penilaian = PenilaianObatGlobal::select('medicine_id')->distinct()->pluck('medicine_id')->toArray();
        return view('penilaian-obat-global.index', compact('medicines', 'penilaian'));
    }

    public function create(Request $request)
    {
        $medicine_id = $request->input('medicine_id');
        $medicines = Medicine::orderBy('name')->get();
        $kriterias = Kriteria::orderBy('nama_kriteria')->get();
        $selectedMedicine = null;

        if ($medicine_id) {
            $selectedMedicine = Medicine::findOrFail($medicine_id);
            $existing = PenilaianObatGlobal::where('medicine_id', $medicine_id)
                ->get()
                ->keyBy('kriteria_id');
        } else {
            $existing = collect();
        }

        return view('penilaian-obat-global.create-mass', compact('medicines', 'kriterias', 'existing', 'medicine_id', 'selectedMedicine'));
    }

    public function createMass()
    {
        $medicines = Medicine::orderBy('name')->get();
        $kriterias = Kriteria::orderBy('nama_kriteria')->get();
        $existing = PenilaianObatGlobal::get()->keyBy(function($item) {
            return $item->medicine_id.'_'.$item->kriteria_id;
        });
        return view('penilaian-obat-global.create-mass', compact('medicines', 'kriterias', 'existing'));
    }

    public function storeMass(Request $request)
    {
        $medicine_id = $request->input('medicine_id');
        $data = $request->input('nilai', []);
        foreach ($data as $kriteria_id => $nilai) {
            if (
                isset($nilai['l'], $nilai['m'], $nilai['u']) &&
                $nilai['l'] !== null && $nilai['m'] !== null && $nilai['u'] !== null
            ) {
                PenilaianObatGlobal::updateOrCreate(
                    [
                        'medicine_id' => $medicine_id,
                        'kriteria_id' => $kriteria_id,
                    ],
                    [
                        'nilai_l' => $nilai['l'],
                        'nilai_m' => $nilai['m'],
                        'nilai_u' => $nilai['u'],
                    ]
                );
            }
        }
        return redirect()->route('penilaian-obat-global.index')->with('success', 'Penilaian obat global massal berhasil disimpan.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'medicine_id' => 'required|exists:medicines,id',
            'kriteria_id' => 'required|exists:kriterias,id',
            'nilai_l' => 'required|numeric|min:1|max:10',
            'nilai_m' => 'required|numeric|min:1|max:10',
            'nilai_u' => 'required|numeric|min:1|max:10',
        ]);
        PenilaianObatGlobal::updateOrCreate(
            [
                'medicine_id' => $request->medicine_id,
                'kriteria_id' => $request->kriteria_id,
            ],
            [
                'nilai_l' => $request->nilai_l,
                'nilai_m' => $request->nilai_m,
                'nilai_u' => $request->nilai_u,
            ]
        );
        return redirect()->route('penilaian-obat-global.index')->with('success', 'Penilaian obat global berhasil disimpan.');
    }

    public function edit(PenilaianObatGlobal $penilaianObatGlobal)
    {
        $medicines = Medicine::orderBy('name')->get();
        $kriterias = Kriteria::orderBy('nama_kriteria')->get();
        return view('penilaian-obat-global.edit', compact('penilaianObatGlobal', 'medicines', 'kriterias'));
    }

    public function update(Request $request, PenilaianObatGlobal $penilaianObatGlobal)
    {
        $request->validate([
            'medicine_id' => 'required|exists:medicines,id',
            'kriteria_id' => 'required|exists:kriterias,id',
            'nilai_l' => 'required|numeric|min:1|max:10',
            'nilai_m' => 'required|numeric|min:1|max:10',
            'nilai_u' => 'required|numeric|min:1|max:10',
        ]);
        $penilaianObatGlobal->update($request->only(['medicine_id', 'kriteria_id', 'nilai_l', 'nilai_m', 'nilai_u']));
        return redirect()->route('penilaian-obat-global.index')->with('success', 'Penilaian obat global berhasil diperbarui.');
    }

    public function destroy(PenilaianObatGlobal $penilaianObatGlobal)
    {
        $penilaianObatGlobal->delete();
        return redirect()->route('penilaian-obat-global.index')->with('success', 'Penilaian obat global berhasil dihapus.');
    }

    public function show($id)
    {
        return redirect()->route('penilaian-obat-global.index');
    }
}
