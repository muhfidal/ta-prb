<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\MedicinePatientHistory;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Medicine;
use App\Models\Prescription;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class MedicinePatientHistoryController extends Controller
{
    public function create()
    {
        $patients = Patient::with(['medicinePatientHistories.prescription', 'medicinePatientHistories.doctor'])->select('id', 'name', 'no_bpjs', 'address', 'gender', 'birth_date')->orderBy('name')->get();
        $medicines = Medicine::all();
        $doctors = \App\Models\Doctor::with('user')->get();
        $prescriptions = Prescription::with(['medicines', 'histories'])->get();

        return view('medicines.take', compact('patients', 'medicines', 'doctors', 'prescriptions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:users,id',
            'taken_at' => 'required|date',
        ]);

        // Validasi tambahan untuk memastikan doctor_id adalah milik user dengan role doctor
        $userDoctor = User::find($validated['doctor_id']);
        if (!$userDoctor || !$userDoctor->isDoctor()) {
            return redirect()->back()->withErrors(['doctor_id' => 'Dokter yang dipilih tidak valid.']);
        }

        // Cari doctor_id dari tabel doctors yang berelasi dengan user ini
        $doctorModel = \App\Models\Doctor::where('user_id', $userDoctor->id)->first();
        if (!$doctorModel) {
            return redirect()->back()->withErrors(['doctor_id' => 'Data dokter tidak ditemukan di tabel doctors.']);
        }

        $prescription = Prescription::with('medicines')->where('patient_id', $validated['patient_id'])->first();

        if ($prescription) {
            // Buat satu entri history untuk satu resep
            MedicinePatientHistory::create([
                'prescription_id' => $prescription->id,
                'patient_id' => $validated['patient_id'],
                'doctor_id' => $doctorModel->id, // Menggunakan ID dari tabel doctors
                'medicine_id' => $prescription->medicines->first()->id,
                'taken_at' => $validated['taken_at'],
            ]);

            // Setelah berhasil, redirect ke halaman create dengan pesan sukses
            return redirect()->route('medicines.take')->with('success', 'Pengambilan obat berhasil disimpan!');
        }

        return redirect()->back()->withErrors(['error' => 'Prescription not found for the patient.']);
    }

    public function index(Request $request)
    {
        $query = Patient::with(['medicinePatientHistories' => function($query) use ($request) {
            $query->with('doctor')->orderBy('taken_at', 'desc');

            // Filter berdasarkan rentang tanggal
            if ($request->filled('start_date')) {
                $query->whereDate('taken_at', '>=', $request->start_date);
            }
            if ($request->filled('end_date')) {
                $query->whereDate('taken_at', '<=', $request->end_date);
            }
        }]);

        // Filter berdasarkan nama pasien
        if ($request->filled('patient_name')) {
            $query->where('name', 'like', '%' . $request->input('patient_name') . '%');
        }

        $patients = $query->paginate(10);

        return view('medicinePatientHistories.index', compact('patients'));
    }

    public function search(Request $request)
    {
        $query = Patient::whereHas('medicinePatientHistories')
            ->with(['medicinePatientHistories' => function($query) use ($request) {
                $query->with('doctor')->orderBy('taken_at', 'desc');
                // Filter berdasarkan rentang tanggal
                if ($request->filled('start_date')) {
                    $query->whereDate('taken_at', '>=', $request->start_date);
                }
                if ($request->filled('end_date')) {
                    $query->whereDate('taken_at', '<=', $request->end_date);
                }
            }]);

        // Filter berdasarkan nama pasien
        if ($request->filled('query')) {
            $query->where('name', 'like', '%' . $request->input('query') . '%');
        }

        $patients = $query->paginate(10);

        return view('medicinePatientHistories.partials.patient_list', compact('patients'))->render();
    }

    /**
     * Simpan histori pengambilan obat dan kembalikan URL print resep (untuk AJAX)
     */
    public function storeAndPrint(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:users,id',
            'taken_at' => 'required|date',
        ]);

        $userDoctor = User::find($validated['doctor_id']);
        if (!$userDoctor || !$userDoctor->isDoctor()) {
            return response()->json(['success' => false, 'message' => 'Dokter tidak valid.'], 422);
        }
        $doctorModel = \App\Models\Doctor::where('user_id', $userDoctor->id)->first();
        if (!$doctorModel) {
            return response()->json(['success' => false, 'message' => 'Data dokter tidak ditemukan.'], 422);
        }
        $prescription = Prescription::with('medicines')->where('patient_id', $validated['patient_id'])->first();
        if (!$prescription) {
            return response()->json(['success' => false, 'message' => 'Prescription not found for the patient.'], 422);
        }
        $history = MedicinePatientHistory::create([
            'prescription_id' => $prescription->id,
            'patient_id' => $validated['patient_id'],
            'doctor_id' => $doctorModel->id,
            'medicine_id' => $prescription->medicines->first()->id,
            'taken_at' => $validated['taken_at'],
        ]);
        $printUrl = route('prescriptions.print', [
            'prescription' => $prescription->id,
            'doctor_id' => $doctorModel->user_id,
            'taken_at' => $validated['taken_at'],
        ]);
        return response()->json(['success' => true, 'print_url' => $printUrl]);
    }

    public function show($id)
    {
        $history = MedicinePatientHistory::with(['patient', 'doctor', 'medicine', 'prescription'])->find($id);
        if (!$history) {
            abort(404, 'Data histori pengambilan obat tidak ditemukan.');
        }
        return view('medicinePatientHistories.show', compact('history'));
    }
}
