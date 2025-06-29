<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicinePatientHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'medicine_id',
        'prescription_id',
        'doctor_id',
        'taken_at',
        'quantity',
    ];

    // Definisikan relasi ke model Medicine
    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    // Definisikan relasi ke model Patient
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    // Definisikan relasi ke model Doctor (dokter)
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    // Definisikan relasi ke model Prescription
    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }
}
