<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Prescription;
use App\Models\Medicine;
use App\Models\Symptom;
use App\Models\MedicinePatientHistory;
use App\Models\Penyakit;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $totalPatients = Patient::count();
        $totalPatientsWithMedicine = MedicinePatientHistory::whereMonth('taken_at', $currentMonth)
            ->whereYear('taken_at', $currentYear)
            ->distinct('patient_id')
            ->count('patient_id');

        $percentagePatientsWithMedicine = $totalPatients > 0 ? intval(($totalPatientsWithMedicine / $totalPatients) * 100) : 0;

        $data = [
            'totalPatients' => $totalPatients,
            'totalPrescriptions' => Prescription::count() ?? 0,
            'totalMedicines' => Medicine::count() ?? 0,
            'totalPrbDiseases' => Penyakit::count() ?? 0,
            'recentPatients' => Patient::with('creator')
                                ->latest()
                                ->take(5)
                                ->get(),
            'totalPatientsWithMedicine' => $totalPatientsWithMedicine,
            'percentagePatientsWithMedicine' => $percentagePatientsWithMedicine,
        ];

        // Data untuk grafik pengambilan obat
        $months = collect(range(5, 0))->map(function($i) {
            return Carbon::now()->subMonths($i)->format('M');
        });

        $medicineTakeCounts = collect(range(5, 0))->map(function($i) {
            $date = Carbon::now()->subMonths($i);
            return MedicinePatientHistory::whereYear('taken_at', $date->year)
                                         ->whereMonth('taken_at', $date->month)
                                         ->distinct('patient_id')
                                         ->count('patient_id');
        });

        $data['chartLabels'] = $months;
        $data['chartData'] = $medicineTakeCounts;

        // Ambil aktivitas terbaru
        $recentActivities = collect();

        // Aktivitas penambahan pasien
        $recentPatients = Patient::with('creator')->latest()->take(5)->get();
        foreach ($recentPatients as $patient) {
            $creatorName = $patient->creator ? $patient->creator->name : 'Unknown';
            $recentActivities->push([
                'type' => 'Penambahan Pasien',
                'description' => "{$patient->name} ditambahkan oleh {$creatorName}",
                'time' => $patient->created_at,
            ]);
        }

        // Aktivitas pengambilan obat
        $recentMedicineTakes = MedicinePatientHistory::with('patient', 'doctor')->latest()->take(5)->get();
        foreach ($recentMedicineTakes as $take) {
            $patientName = $take->patient ? $take->patient->name : 'Unknown';
            $doctorName = $take->doctor ? $take->doctor->name : 'Unknown';
            $recentActivities->push([
                'type' => 'Pengambilan Obat',
                'description' => "{$patientName} mengambil obat dari {$doctorName}",
                'time' => $take->taken_at instanceof \Carbon\Carbon ? $take->taken_at : \Carbon\Carbon::parse($take->taken_at),
            ]);
        }

        // Urutkan aktivitas berdasarkan waktu
        $recentActivities = $recentActivities->sortByDesc('time')->take(5);

        $data['recentActivities'] = $recentActivities;

        return view('home', $data);
    }
}
