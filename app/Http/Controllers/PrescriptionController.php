<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use App\Models\Patient;
use App\Models\Medicine;
use App\Models\Disease;
use App\Models\Doctor;
use App\Models\MedicinePatientHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
Carbon::setLocale('id');

class PrescriptionController extends Controller
{
    public function index(Request $request)
    {
        $query = Prescription::with(['patient', 'diseases', 'medicines', 'creator']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('prescription_number', 'like', "%{$search}%")
                    ->orWhereHas('patient', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('no_bpjs', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('period')) {
            $date = Carbon::createFromFormat('Y-m', $request->period);
            $query->whereYear('prescription_date', $date->year)
                  ->whereMonth('prescription_date', $date->month);
        }

        $prescriptions = $query->latest('prescription_date')->paginate(10);

        if ($request->wantsJson()) {
            return response()->json($prescriptions);
        }

        return view('prescriptions.index', compact('prescriptions'));
    }

    public function create()
    {
        $diseases = Disease::all();
        $medicines = Medicine::where('is_prb', 0)->get();
        $patients = Patient::all();
        return view('prescriptions.create', compact('diseases', 'medicines', 'patients'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // Cek apakah pasien sudah memiliki resep
            $existingPrescription = Prescription::where('patient_id', $request->patient_id)->first();
            if ($existingPrescription) {
                return back()->withErrors('Pasien ini sudah memiliki resep. Silakan edit resep yang sudah ada atau hapus resep lama terlebih dahulu.');
            }

            $validated = $request->validate([
                'patient_id' => 'required|exists:patients,id',
                'disease_id' => 'required|array',
                'disease_id.*' => 'exists:diseases,id',
                'prescription_date' => 'required|date',
                'notes' => 'nullable|string',
                'medicines' => 'required|array',
                'medicines.*.id' => 'required|exists:medicines,id',
                'medicines.*.dosage' => 'required|string',
                'medicines.*.quantity' => 'required|integer|min:1',
                'medicines.*.notes' => 'nullable|string'
            ]);

            $prescription = new Prescription([
                'prescription_number' => 'PRE-' . time(),
                'patient_id' => $validated['patient_id'],
                'prescription_date' => $validated['prescription_date'],
                'notes' => $validated['notes'],
                'created_by' => Auth::id()
            ]);

            $prescription->save();

            // Attach diseases
            $prescription->diseases()->attach($validated['disease_id']);

            // Attach medicines dengan data pivot
            foreach ($validated['medicines'] as $medicine) {
                DB::table('prescription_medicine')->insert([
                    'prescription_id' => $prescription->id,
                    'medicine_id' => $medicine['id'],
                    'dosage' => $medicine['dosage'],
                    'quantity' => $medicine['quantity'],
                    'notes' => $medicine['notes'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            DB::commit();

            return redirect()->route('prescriptions.show', $prescription)
                ->with('success', 'Resep berhasil dibuat.');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error creating prescription: ' . $e->getMessage());
            return back()->withErrors('Terjadi kesalahan saat membuat resep. ' . $e->getMessage());
        }
    }

    public function show(Prescription $prescription)
    {
        $prescription->load(['patient', 'diseases', 'medicines', 'creator']);
        return view('prescriptions.show', compact('prescription'));
    }

    public function edit(Prescription $prescription)
    {
        $prescription->load(['patient', 'diseases', 'medicines']);
        $diseases = Disease::all();
        $medicines = Medicine::where('is_prb', 0)->get();
        $patients = Patient::all();
        return view('prescriptions.edit', compact('prescription', 'diseases', 'medicines', 'patients'));
    }

    public function update(Request $request, Prescription $prescription)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'disease_id' => 'required|array',
                'disease_id.*' => 'exists:diseases,id',
                'prescription_date' => 'required|date',
                'notes' => 'nullable|string',
                'medicines' => 'required|array',
                'medicines.*.id' => 'required|exists:medicines,id',
                'medicines.*.dosage' => 'required|string',
                'medicines.*.quantity' => 'required|integer|min:1',
                'medicines.*.notes' => 'nullable|string'
            ]);

            $prescription->update([
                'prescription_date' => $validated['prescription_date'],
                'notes' => $validated['notes']
            ]);

            // Sync diseases
            $prescription->diseases()->sync($validated['disease_id']);

            // Update medicines dengan data pivot
            DB::table('prescription_medicine')->where('prescription_id', $prescription->id)->delete();

            foreach ($validated['medicines'] as $medicine) {
                DB::table('prescription_medicine')->insert([
                    'prescription_id' => $prescription->id,
                    'medicine_id' => $medicine['id'],
                    'dosage' => $medicine['dosage'],
                    'quantity' => $medicine['quantity'],
                    'notes' => $medicine['notes'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            DB::commit();

            return redirect()->route('prescriptions.show', $prescription)
                ->with('success', 'Resep berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error updating prescription: ' . $e->getMessage());
            return back()->withErrors('Terjadi kesalahan saat memperbarui resep. ' . $e->getMessage());
        }
    }

    public function destroy(Prescription $prescription)
    {
        try {
            DB::beginTransaction();

            // Hapus relasi dengan medicines dan diseases
            DB::table('prescription_medicine')->where('prescription_id', $prescription->id)->delete();
            $prescription->diseases()->detach();

            // Hapus prescription
            $prescription->delete();

            DB::commit();

            return redirect()->route('prescriptions.index')
                ->with('success', 'Resep berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error deleting prescription: ' . $e->getMessage());
            return back()->withErrors('Terjadi kesalahan saat menghapus resep. ' . $e->getMessage());
        }
    }

    public function print(Request $request, $id)
    {
        try {
            // Ambil doctor_id dan taken_at dari input (GET/POST)
            $doctorId = $request->input('doctor_id');
            $takenAt = $request->input('taken_at', now());

            if (!$doctorId) {
                \Log::debug('PRINT RESEP: doctor_id tidak ada', ['doctor_id' => $doctorId]);
                return redirect()->route('medicines.take')->withErrors('Dokter harus dipilih.');
            }

            $prescription = Prescription::with(['patient.diseases', 'medicines', 'histories'])->findOrFail($id);

            $userDoctor = User::find($doctorId);
            if (!$userDoctor || !$userDoctor->isDoctor()) {
                \Log::debug('PRINT RESEP: userDoctor tidak valid', ['doctor_id' => $doctorId, 'userDoctor' => $userDoctor]);
                return redirect()->route('medicines.take')->withErrors('Dokter tidak valid.');
            }

            // Cari doctor_id dari tabel doctors yang berelasi dengan user ini
            $doctorModel = \App\Models\Doctor::where('user_id', $userDoctor->id)->first();
            if (!$doctorModel) {
                \Log::debug('PRINT RESEP: doctorModel tidak ditemukan', ['user_id' => $userDoctor->id]);
                return redirect()->route('medicines.take')->withErrors('Data dokter tidak ditemukan.');
            }

            // Pastikan resep punya obat
            if ($prescription->medicines->isEmpty()) {
                \Log::debug('PRINT RESEP: resep tidak punya obat', ['prescription_id' => $prescription->id]);
                return redirect()->route('medicines.take')->withErrors('Resep tidak memiliki obat. Tidak bisa dicetak.');
            }

            // Ambil quantity dari data pivot prescription_medicine
            $firstMedicine = $prescription->medicines->first();
            $quantity = $firstMedicine && isset($firstMedicine->pivot) ? $firstMedicine->pivot->quantity : 1;

            // Buat satu entri history untuk satu resep
            $history = MedicinePatientHistory::create([
                'prescription_id' => $prescription->id,
                'patient_id' => $prescription->patient_id,
                'doctor_id' => $doctorModel->id, // Menggunakan ID dari tabel doctors
                'medicine_id' => $firstMedicine ? $firstMedicine->id : null,
                'quantity' => $quantity,
                'taken_at' => $takenAt,
            ]);

            return view('prescriptions.print', compact('prescription', 'doctorModel', 'history'));
        } catch (\Exception $e) {
            \Log::error('Error saat cetak resep: ' . $e->getMessage());
            return redirect()->route('medicines.take')->withErrors('Terjadi kesalahan saat mencetak resep: ' . $e->getMessage());
        }
    }

    public function showTakeMedicineForm()
    {
        $patients = Patient::all();
        $prescriptions = Prescription::with(['medicines', 'histories'])->get();
        $doctors = Doctor::all();

        return view('medicines.take', compact('patients', 'prescriptions', 'doctors'));
    }
}
