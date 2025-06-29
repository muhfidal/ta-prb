<?php

namespace App\Http\Controllers;

use App\Models\Disease;
use Illuminate\Http\Request;

class DiseaseController extends Controller
{
    public function index()
    {
        $diseases = Disease::with('medicines')->latest()->paginate(10);
        return view('diseases.index', compact('diseases'));
    }

    public function create()
    {
        return view('diseases.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        Disease::create($validated);

        return redirect()
            ->route('diseases.index')
            ->with('success', 'Data penyakit berhasil ditambahkan');
    }

    public function edit(Disease $disease)
    {
        return view('diseases.edit', compact('disease'));
    }

    public function update(Request $request, Disease $disease)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $disease->update($validated);

        return redirect()
            ->route('diseases.index')
            ->with('success', 'Data penyakit berhasil diperbarui');
    }

    public function destroy(Disease $disease)
    {
        $disease->delete();

        return redirect()
            ->route('diseases.index')
            ->with('success', 'Penyakit berhasil dihapus');
    }
}
