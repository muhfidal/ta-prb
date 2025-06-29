<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Prescription;
use App\Models\Patient;
use App\Models\Medicine;
use App\Models\Disease;
use App\Models\User;
use Carbon\Carbon;

class PrescriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus semua resep yang ada
        Prescription::query()->delete();

        $doctor = User::where('role', 'doctor')->first();
        $patients = Patient::all();
        $diseases = Disease::all();

        foreach ($patients as $patient) {
            // Buat 2 resep untuk setiap pasien
            for ($i = 0; $i < 2; $i++) {
                $disease = $diseases->random();
                $prescription = Prescription::create([
                    'prescription_number' => 'PRB-' . date('Ymd') . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT),
                    'patient_id' => $patient->id,
                    'disease_id' => $disease->id,
                    'created_by' => $doctor->id,
                    'created_at' => Carbon::now()->subDays(rand(1, 30))
                ]);

                // Tambahkan obat ke resep berdasarkan penyakit
                switch($disease->name) {
                    case 'Diabetes Melitus':
                        $medicines = ['Metformin', 'Glimepiride'];
                        break;
                    case 'Hipertensi':
                        $medicines = ['Amlodipine', 'Candesartan'];
                        break;
                    case 'Asma':
                        $medicines = ['Salbutamol'];
                        break;
                    case 'Epilepsi':
                        $medicines = ['Phenytoin'];
                        break;
                    case 'Jantung Koroner':
                        $medicines = ['Bisoprolol'];
                        break;
                    default:
                        $medicines = [];
                }

                foreach ($medicines as $medicineName) {
                    $medicine = Medicine::where('name', $medicineName)->first();
                    if ($medicine) {
                        $prescription->medicines()->attach($medicine->id, [
                            'quantity' => rand(10, 30),
                            'dosage' => rand(1, 3) . ' kali sehari',
                            'notes' => 'Diminum setelah makan'
                        ]);
                    }
                }
            }
        }
    }
}
