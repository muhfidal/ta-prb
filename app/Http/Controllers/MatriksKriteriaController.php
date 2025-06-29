<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\MatriksKriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MatriksKriteriaController extends Controller
{
    public function index()
    {
        $kriteria = Kriteria::all();
        $matriks = MatriksKriteria::with(['kriteria1', 'kriteria2'])->get();
        return view('matriks-kriteria.index', compact('kriteria', 'matriks'));
    }

    public function create()
    {
        $kriteria = Kriteria::all();
        return view('matriks-kriteria.create', compact('kriteria'));
    }

    public function store(Request $request)
    {
        // Pisahkan value gabungan menjadi dua id
        [$kriteria1_id, $kriteria2_id] = explode('-', $request->kriteria1_id);
        $request->merge([
            'kriteria1_id' => $kriteria1_id,
            'kriteria2_id' => $kriteria2_id
        ]);

        $request->validate([
            'kriteria1_id' => 'required|exists:kriterias,id|different:kriteria2_id',
            'kriteria2_id' => 'required|exists:kriterias,id',
            'nilai_l' => 'required|numeric|gt:0',
            'nilai_m' => 'required|numeric|gt:0',
            'nilai_u' => 'required|numeric|gt:0',
        ], [
            'kriteria1_id.different' => 'Kriteria 1 dan Kriteria 2 tidak boleh sama.',
            'nilai_l.gt' => 'Nilai L harus lebih dari 0.',
            'nilai_m.gt' => 'Nilai M harus lebih dari 0.',
            'nilai_u.gt' => 'Nilai U harus lebih dari 0.'
        ]);

        // Cek apakah perbandingan sudah ada (A-B atau B-A)
        $exists = \App\Models\MatriksKriteria::where(function($q) use ($request) {
            $q->where('kriteria1_id', $request->kriteria1_id)
              ->where('kriteria2_id', $request->kriteria2_id);
        })->orWhere(function($q) use ($request) {
            $q->where('kriteria1_id', $request->kriteria2_id)
              ->where('kriteria2_id', $request->kriteria1_id);
        })->exists();

        if ($exists) {
            return back()->with('error', 'Perbandingan antara kriteria ini sudah ada.');
        }

        MatriksKriteria::create($request->all());

        return redirect()->route('matriks-kriteria.index')
            ->with('success', 'Matriks perbandingan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $matriksKriteria = MatriksKriteria::find($id);

        if (!$matriksKriteria) {
            abort(404, 'Matriks Kriteria tidak ditemukan.');
        }

        $kriteria = Kriteria::all();
        return view('matriks-kriteria.edit', compact('matriksKriteria', 'kriteria'));
    }

    public function update(Request $request, $id)
    {
        $matriksKriteria = MatriksKriteria::find($id); // Ambil model secara manual

        if (!$matriksKriteria) {
            abort(404, 'Matriks Kriteria tidak ditemukan.');
        }

        $request->validate([
            'nilai_l' => 'required|numeric|gt:0',
            'nilai_m' => 'required|numeric|gt:0',
            'nilai_u' => 'required|numeric|gt:0',
        ], [
            'nilai_l.gt' => 'Nilai L harus lebih dari 0.',
            'nilai_m.gt' => 'Nilai M harus lebih dari 0.',
            'nilai_u.gt' => 'Nilai U harus lebih dari 0.'
        ]);

        // Pisahkan value gabungan menjadi dua id (jika kriteria1_id dan kriteria2_id juga bisa diupdate)
        // Jika kriteria1_id dan kriteria2_id tidak boleh diupdate, Anda bisa menghapus bagian ini
        // Asumsi hanya nilai_l, nilai_m, nilai_u yang diupdate
        // Jika perlu update kriteria1_id dan kriteria2_id, uncomment dan sesuaikan:
        // [$kriteria1_id, $kriteria2_id] = explode('-', $request->kriteria1_id);
        // $request->merge([
        //     'kriteria1_id' => $kriteria1_id,
        //     'kriteria2_id' => $kriteria2_id
        // ]);

        $matriksKriteria->update($request->only(['nilai_l', 'nilai_m', 'nilai_u'])); // Update hanya field yang relevan

        return redirect()->route('matriks-kriteria.index')
            ->with('success', 'Matriks perbandingan berhasil diperbarui');
    }

    public function destroy(MatriksKriteria $matriksKriteria)
    {
        // Hapus matriks perbandingan invers
        MatriksKriteria::where('kriteria1_id', $matriksKriteria->kriteria2_id)
            ->where('kriteria2_id', $matriksKriteria->kriteria1_id)
            ->delete();

        $matriksKriteria->delete();

        return redirect()->route('matriks-kriteria.index')
            ->with('success', 'Matriks perbandingan berhasil dihapus');
    }

    public function cekKelengkapan()
    {
        $kriteria = \App\Models\Kriteria::all();
        $matriks = \App\Models\MatriksKriteria::all();
        $kelengkapan = [];
        foreach ($kriteria as $k1) {
            $missing = [];
            foreach ($kriteria as $k2) {
                if ($k1->id != $k2->id) {
                    $exists = $matriks->where('kriteria1_id', $k1->id)->where('kriteria2_id', $k2->id)->first();
                    if (!$exists) {
                        $missing[] = $k2->nama_kriteria;
                    }
                }
            }
            $kelengkapan[$k1->nama_kriteria] = $missing;
        }
        return view('matriks-kriteria.cek-kelengkapan', compact('kelengkapan'));
    }
}
