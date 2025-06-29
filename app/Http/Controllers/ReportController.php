<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;

class ReportController extends Controller
{
    public function patients()
    {
        $patients = Patient::all(); // Mengambil semua data pasien
        return view('reports.patient_detail', compact('patients'));
    }

    public function prescriptions()
    {
        // Logika untuk laporan resep
        return view('reports.prescription_list');
    }

    public function medicines()
    {
        // Logika untuk laporan obat
        return view('reports.medicine_usage');
    }

    public function diseases()
    {
        // Logika untuk laporan penyakit
        return view('reports.disease_statistics');
    }

    public function doctors()
    {
        // Logika untuk laporan dokter
        return view('reports.doctor_performance');
    }

    public function downloadPatients($format)
    {
        $patients = Patient::with('prescriptions.diseases')->get();

        if ($format === 'pdf') {
            // Logika untuk mengunduh PDF
        } elseif ($format === 'excel') {
            // Logika untuk mengunduh Excel
        }

        return redirect()->route('reports.patients');
    }

    public function index()
    {
        $totalPatients = \App\Models\Patient::count();
        $totalPrescriptions = \App\Models\Prescription::count();
        $totalMedicines = \App\Models\Medicine::count();
        $totalDiseases = \App\Models\Disease::count();
        $totalDoctors = \App\Models\Doctor::count();
        $recentPatients = \App\Models\Patient::latest()->take(5)->get();
        $recentPrescriptions = \App\Models\Prescription::with('patient')->latest()->take(5)->get();
        $recentMedicines = \App\Models\Medicine::latest()->take(5)->get();
        $recentDiseases = \App\Models\Disease::latest()->take(5)->get();
        $recentDoctors = \App\Models\Doctor::with('user')->latest()->take(5)->get();
        return view('reports.index', compact(
            'totalPatients', 'totalPrescriptions', 'totalMedicines', 'totalDiseases', 'totalDoctors',
            'recentPatients', 'recentPrescriptions', 'recentMedicines', 'recentDiseases', 'recentDoctors'
        ));
    }
}
