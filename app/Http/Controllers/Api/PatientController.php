<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PatientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function all()
    {
        return Patient::select('id', 'name', 'no_bpjs')
            ->orderBy('name')
            ->get();
    }

    public function search(Request $request)
    {
        try {
            $query = $request->get('q');

            if (empty($query)) {
                return response()->json([]);
            }

            $patients = Patient::where(function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('no_bpjs', 'like', "%{$query}%");
            })
            ->select('id', 'name', 'no_bpjs', 'gender', 'birth_date', 'address')
            ->get();

            $patientsWithPrescription = $patients->map(function($patient) {
                $data = $patient->toArray();
                $data['has_prescription'] = Prescription::where('patient_id', $patient->id)->exists();
                return $data;
            });

            return response()->json($patientsWithPrescription);

        } catch (\Exception $e) {
            Log::error('Error in patient search: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan saat mencari data'], 500);
        }
    }

    public function prescriptions(Patient $patient)
    {
        return $patient->prescriptions()
            ->with(['medicines', 'diseases'])
            ->get();
    }
}
