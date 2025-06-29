<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;
use App\Models\Prescription;

class MedicineController extends Controller
{
    public function index(Request $request)
    {
        $query = Medicine::query();

        // Filter pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('code', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%") ;
            });
        }

        // Filter satuan
        if ($request->filled('unit') && $request->unit !== 'all') {
            $query->where('unit', $request->unit);
        }

        // Filter gejala tambahan
        if ($request->filled('is_prb') && in_array($request->is_prb, ['0','1'])) {
            $query->where('is_prb', $request->is_prb);
        }

        // Sorting
        if ($request->filled('sort')) {
            if ($request->sort === 'code') {
                $query->orderBy('code');
            } elseif ($request->sort === 'name') {
                $query->orderBy('name');
            } elseif ($request->sort === 'latest') {
                $query->latest();
            }
        } else {
            $query->latest();
        }

        $medicines = $query->paginate(10)->appends($request->all());
        return view('medicines.index', compact('medicines'));
    }

    public function create()
    {
        return view('medicines.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'unit' => 'required|string|max:50',
            'is_prb' => 'required|in:0,1',
            'dose' => 'nullable|string|max:255',
            'quantity' => 'nullable|integer|min:0',
        ]);

        // Generate kode obat otomatis format inisial nama + 3 digit angka
        $name = strtoupper(preg_replace('/[^A-Z]/', '', substr($validated['name'], 0, 3)));
        if (strlen($name) < 3) {
            $name = str_pad($name, 3, 'X'); // Jika nama kurang dari 3 huruf, tambahkan X
        }
        $lastMedicine = Medicine::where('code', 'like', $name.'%')->orderBy('id', 'desc')->first();
        $nextNumber = $lastMedicine ? ((int) substr($lastMedicine->code, 3)) + 1 : 1;
        $validated['code'] = $name . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        Medicine::create($validated);

        return redirect()
            ->route('medicines.index')
            ->with('success', 'Obat berhasil ditambahkan');
    }

    public function edit(Medicine $medicine)
    {
        return view('medicines.edit', compact('medicine'));
    }

    public function update(Request $request, Medicine $medicine)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:medicines,code,' . $medicine->id,
            'description' => 'nullable|string',
            'unit' => 'required|string',
            'is_prb' => 'required|in:0,1',
            'dose' => 'nullable|string|max:255',
            'quantity' => 'nullable|integer|min:0',
        ]);

        $medicine->update($validated);

        return redirect()
            ->route('medicines.index')
            ->with('success', 'Data obat berhasil diperbarui');
    }

    public function destroy(Medicine $medicine)
    {
        $medicine->delete();

        return redirect()
            ->route('medicines.index')
            ->with('success', 'Obat berhasil dihapus');
    }

    public function show(Medicine $medicine)
    {
        return view('medicines.show', compact('medicine'));
    }

    public function take($id)
    {
        $prescription = Prescription::with(['patient', 'medicines'])->where('patient_id', $id)->first();

        if (!$prescription) {
            return redirect()->route('prescriptions.create')
                ->with('warning', 'Pasien ini belum memiliki resep. Silakan buat resep terlebih dahulu.');
        }

        return view('medicines.take', [
            'prescription' => $prescription,
            // Tambahkan variabel lain yang diperlukan
        ]);
    }
}
