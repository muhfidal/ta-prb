<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PatientExport;
use App\Imports\PatientImport;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        // Ambil parameter filter dari request
        $name = $request->input('name');
        $gender = $request->input('gender');
        $birthDate = $request->input('birth_date');

        // Query dasar
        $query = Patient::query();

        // Tambahkan filter berdasarkan nama
        if ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        }

        // Tambahkan filter berdasarkan gender
        if ($gender) {
            $query->where('gender', $gender);
        }

        // Tambahkan filter berdasarkan tanggal lahir
        if ($birthDate) {
            $query->whereDate('birth_date', $birthDate);
        }

        // Dapatkan hasil dengan pagination
        $patients = $query->paginate(10);

        return view('patients.index', compact('patients'));
    }

    public function create()
    {
        return view('patients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:L,P',
            'address' => 'required|string',
            'birth_date' => 'required|date',
            'no_bpjs' => 'required|string|unique:patients,no_bpjs',
        ]);

        $validated['created_by'] = auth()->id();

        Patient::create($validated);

        return redirect()
            ->route('patients.index')
            ->with('success', 'Pasien berhasil ditambahkan');
    }

    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:L,P',
            'address' => 'required|string',
            'birth_date' => 'required|date',
            'no_bpjs' => 'required|string|unique:patients,no_bpjs,' . $patient->id,
        ]);

        $patient->update($validated);

        return redirect()
            ->route('patients.index')
            ->with('success', 'Data pasien berhasil diperbarui');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()
            ->route('patients.index')
            ->with('success', 'Data pasien berhasil dihapus');
    }

    public function show(Patient $patient)
    {
        $patient->load('prescriptions.diseases', 'prescriptions.medicines', 'medicineHistories');

        $groupedHistories = $patient->medicineHistories()
            ->selectRaw('MONTH(taken_at) as month, COUNT(*) as count')
            ->whereYear('taken_at', now()->year)
            ->groupBy('month')
            ->pluck('count', 'month');

        return view('patients.show', compact('patient', 'groupedHistories'));
    }

    public function laporan()
    {
        // Ambil data yang diperlukan untuk laporan
        $patients = Patient::all();

        // Kirim data ke view laporan
        return view('patients.laporan', compact('patients'));
    }

    public function search(Request $request)
    {
        $q = $request->get('q');
        $pasiens = \App\Models\Patient::where('name', 'like', "%$q%")
            ->orWhere('no_bpjs', 'like', "%$q%")
            ->limit(10)
            ->get();
        return response()->json($pasiens);
    }

    public function visits(Patient $patient)
    {
        if (!$patient || !$patient->exists) {
            return redirect()
                ->route('prescriptions.index')
                ->with('error', 'Data pasien tidak ditemukan.');
        }

        $currentYear = request('year', now()->year);
        // Ambil semua riwayat, lalu filter dan groupBy tahun & bulan
        $allHistories = $patient->medicinePatientHistories()
            ->with(['prescription', 'doctor'])
            ->get();

        $histories = $allHistories->filter(function($history) use ($currentYear) {
            return Carbon::parse($history->taken_at)->year == $currentYear;
        })->groupBy(function($history) {
            return Carbon::parse($history->taken_at)->format('m');
        });

        $months = collect(range(1, 12))->map(function($month) use ($histories, $currentYear) {
            $monthName = Carbon::create($currentYear, $month, 1)->translatedFormat('M');
            $monthHistories = $histories->get(sprintf("%02d", $month), collect());

            return [
                'name' => $monthName,
                'number' => $month,
                'status' => $this->getVisitStatus($monthHistories, $month, $currentYear),
                'histories' => $monthHistories,
                'date' => Carbon::create($currentYear, $month, 1)->format('Y-m'),
            ];
        });

        return view('patients.visits', compact('patient', 'months', 'currentYear'));
    }

    private function getVisitStatus($histories, $month, $year)
    {
        $now = now();
        $currentMonth = $now->month;
        $currentYear = $now->year;

        if ($histories->isEmpty()) {
            if ($year < $currentYear) {
                return 'missed';
            } elseif ($year > $currentYear) {
                return 'upcoming';
            } else {
                if ($month < $currentMonth) {
                    return 'missed';
                } elseif ($month > $currentMonth) {
                    return 'upcoming';
                } else {
                    return 'pending';
                }
            }
        }
        return 'completed';
    }

    public function exportExcel()
    {
        return Excel::download(new PatientExport, 'data_pasien.xlsx');
    }
}
