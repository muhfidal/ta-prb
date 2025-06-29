<?php
namespace App\Http\Controllers;

use App\Models\Penyakit;
use Illuminate\Http\Request;

class PenyakitController extends Controller
{
    public function index()
    {
        $penyakits = Penyakit::orderBy('nama_penyakit')->get();
        return view('penyakits.index', compact('penyakits'));
    }

    public function create()
    {
        return view('penyakits.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_penyakit' => 'required|string|max:255',
        ]);
        Penyakit::create($request->only('nama_penyakit'));
        return redirect()->route('penyakits.index')->with('success', 'Penyakit berhasil ditambahkan.');
    }

    public function edit(Penyakit $penyakit)
    {
        return view('penyakits.edit', compact('penyakit'));
    }

    public function update(Request $request, Penyakit $penyakit)
    {
        $request->validate([
            'nama_penyakit' => 'required|string|max:255',
        ]);
        $penyakit->update($request->only('nama_penyakit'));
        return redirect()->route('penyakits.index')->with('success', 'Penyakit berhasil diperbarui.');
    }

    public function destroy(Penyakit $penyakit)
    {
        $penyakit->delete();
        return redirect()->route('penyakits.index')->with('success', 'Penyakit berhasil dihapus.');
    }
}
