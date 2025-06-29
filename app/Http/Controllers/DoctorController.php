<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = Doctor::orderBy('name')->paginate(10);
        return view('doctors.index', compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('role', 'doctor')
            ->whereNotIn('id', \App\Models\Doctor::pluck('user_id'))
            ->orderBy('name')->get();
        return view('doctors.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'specialization' => 'nullable|string|max:100',
        ]);
        Doctor::create($validated);
        return redirect()->route('doctors.index')->with('success', 'Dokter berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Doctor $doctor)
    {
        $users = User::where('role', 'doctor')
            ->where(function($q) use ($doctor) {
                $q->whereNotIn('id', \App\Models\Doctor::where('id', '!=', $doctor->id)->pluck('user_id'))
                  ->orWhere('id', $doctor->user_id);
            })
            ->orderBy('name')->get();
        return view('doctors.edit', compact('doctor', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Doctor $doctor)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'specialization' => 'nullable|string|max:100',
        ]);
        $doctor->update($validated);
        return redirect()->route('doctors.index')->with('success', 'Data dokter berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return redirect()->route('doctors.index')->with('success', 'Dokter berhasil dihapus');
    }
}
