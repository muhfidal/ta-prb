<?php
namespace App\Http\Controllers;

use App\Models\Penyakit;
use App\Models\Medicine;
use Illuminate\Http\Request;

class PenyakitObatController extends Controller
{
    public function index(Request $request)
    {
        $penyakits = Penyakit::orderBy('nama_penyakit')->get();
        $selectedPenyakit = null;
        $medicines = collect();
        $selectedMedicines = [];
        if ($request->penyakit_id) {
            $selectedPenyakit = Penyakit::find($request->penyakit_id);
            $medicines = Medicine::orderBy('name')->get();
            $selectedMedicines = $selectedPenyakit->medicines->pluck('id')->toArray();
        }
        return view('penyakits.mapping', compact('penyakits', 'selectedPenyakit', 'medicines', 'selectedMedicines'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'penyakit_id' => 'required|exists:penyakits,id',
            'medicine_ids' => 'array',
            'medicine_ids.*' => 'exists:medicines,id',
        ]);
        $penyakit = Penyakit::findOrFail($request->penyakit_id);
        $penyakit->medicines()->sync($request->medicine_ids ?? []);
        return redirect()->route('penyakits.mapping', ['penyakit_id' => $penyakit->id])
            ->with('success', 'Mapping obat ke penyakit berhasil disimpan.');
    }

    public function create()
    {
        $penyakits = Penyakit::orderBy('nama_penyakit')->get();
        $medicines = Medicine::orderBy('name')->get();
        return view('penyakits.mapping-create', compact('penyakits', 'medicines'));
    }

    public function edit($id)
    {
        $penyakit = Penyakit::with('medicines')->findOrFail($id);
        $penyakits = Penyakit::orderBy('nama_penyakit')->get();
        $medicines = Medicine::orderBy('name')->get();
        $selectedMedicines = $penyakit->medicines->pluck('id')->toArray();
        return view('penyakits.mapping-edit', compact('penyakit', 'penyakits', 'medicines', 'selectedMedicines'));
    }
}
