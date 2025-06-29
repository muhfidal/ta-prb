<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\PengaturanFuzzy;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function index()
    {
        $kriteria = Kriteria::with('pengaturanFuzzy')->get();
        return view('kriteria.index', compact('kriteria'));
    }

    public function create()
    {
        return view('kriteria.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kriteria' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tipe_kriteria' => 'required|in:benefit,cost',
            'min_value' => 'required|numeric',
            'max_value' => 'required|numeric|gt:min_value',
            'fuzzy_set' => 'required|string'
        ]);

        $kriteria = Kriteria::create([
            'nama_kriteria' => $request->nama_kriteria,
            'deskripsi' => $request->deskripsi,
            'tipe_kriteria' => $request->tipe_kriteria,
            'status' => true
        ]);

        PengaturanFuzzy::create([
            'kriteria_id' => $kriteria->id,
            'min_value' => $request->min_value,
            'max_value' => $request->max_value,
            'fuzzy_set' => $request->fuzzy_set
        ]);

        return redirect()->route('kriteria.index')
            ->with('success', 'Kriteria berhasil ditambahkan');
    }

    public function edit(Kriteria $kriteria)
    {
        $kriteria->load('pengaturanFuzzy');
        return view('kriteria.edit', compact('kriteria'));
    }

    public function update(Request $request, Kriteria $kriteria)
    {
        $request->validate([
            'nama_kriteria' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tipe_kriteria' => 'required|in:benefit,cost',
            'min_value' => 'required|numeric',
            'max_value' => 'required|numeric|gt:min_value',
            'fuzzy_set' => 'required|string'
        ]);

        $kriteria->update([
            'nama_kriteria' => $request->nama_kriteria,
            'deskripsi' => $request->deskripsi,
            'tipe_kriteria' => $request->tipe_kriteria
        ]);

        $kriteria->pengaturanFuzzy->update([
            'min_value' => $request->min_value,
            'max_value' => $request->max_value,
            'fuzzy_set' => $request->fuzzy_set
        ]);

        return redirect()->route('kriteria.index')
            ->with('success', 'Kriteria berhasil diperbarui');
    }

    public function destroy(Kriteria $kriteria)
    {
        $kriteria->pengaturanFuzzy()->delete();
        $kriteria->delete();

        return redirect()->route('kriteria.index')
            ->with('success', 'Kriteria berhasil dihapus');
    }
}
