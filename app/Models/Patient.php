<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Prescription;

class Patient extends Model
{
    protected $fillable = [
        'name',
        'gender',
        'address',
        'birth_date',
        'no_bpjs',
        'created_by',
    ];

    protected $appends = ['has_prescription'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relasi many-to-many dengan model Medicine melalui Prescription
    public function medicines()
    {
        return $this->hasManyThrough(
            Medicine::class,
            Prescription::class,
            'patient_id', // Foreign key on prescriptions table
            'id', // Foreign key on medicines table
            'id', // Local key on patients table
            'id' // Local key on prescription_medicine table
        );
    }

    // Relasi many-to-many dengan model Disease
    public function diseases()
    {
        return $this->belongsToMany(Disease::class, 'disease_patient', 'patient_id', 'disease_id');
    }

    // Relasi ke MedicineHistory
    public function medicineHistories()
    {
        return $this->hasMany(MedicinePatientHistory::class);
    }

    // Relasi ke MedicinePatientHistory
    public function medicinePatientHistories()
    {
        return $this->hasMany(MedicinePatientHistory::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    // Accessor untuk mengecek apakah pasien sudah memiliki resep
    public function getHasPrescriptionAttribute()
    {
        return $this->prescriptions()->exists();
    }
}
