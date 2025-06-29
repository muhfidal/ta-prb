<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\PenilaianAlternatif;
use Illuminate\Http\Request;

class PenilaianAlternatifController extends Controller
{
    public function index()
    {
        $alternatifs = Alternatif::all();
        $kriterias = Kriteria::all();
        $penilaian = PenilaianAlternatif::with(['alternatif', 'kriteria'])->get();

        return view('penilaian-alternatif.index', compact('alternatifs', 'kriterias', 'penilaian'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'alternatif_id' => 'required|exists:alternatifs,id',
            'kriteria_id' => 'required|exists:kriterias,id',
            'nilai_l' => 'required|numeric|min:1|max:9',
            'nilai_m' => 'required|numeric|min:1|max:9',
            'nilai_u' => 'required|numeric|min:1|max:9',
        ]);

        // Validasi bahwa nilai_l <= nilai_m <= nilai_u
        if ($request->nilai_l > $request->nilai_m || $request->nilai_m > $request->nilai_u) {
            return back()->with('error', 'Nilai L harus <= M <= U');
        }

        PenilaianAlternatif::create($request->all());
        return redirect()->route('penilaian-alternatif.index')->with('success', 'Penilaian berhasil ditambahkan');
    }

    public function update(Request $request, PenilaianAlternatif $penilaianAlternatif)
    {
        $request->validate([
            'nilai_l' => 'required|numeric|min:1|max:9',
            'nilai_m' => 'required|numeric|min:1|max:9',
            'nilai_u' => 'required|numeric|min:1|max:9',
        ]);

        if ($request->nilai_l > $request->nilai_m || $request->nilai_m > $request->nilai_u) {
            return back()->with('error', 'Nilai L harus <= M <= U');
        }

        $penilaianAlternatif->update($request->all());
        return redirect()->route('penilaian-alternatif.index')->with('success', 'Penilaian berhasil diperbarui');
    }

    public function destroy(PenilaianAlternatif $penilaianAlternatif)
    {
        $penilaianAlternatif->delete();
        return redirect()->route('penilaian-alternatif.index')->with('success', 'Penilaian berhasil dihapus');
    }
}
