<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Medicine extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
        'unit',
        'disease_id',
        'score',
        'dose',
        'quantity',
        'reason',
        'is_prb',
    ];

    public function disease(): BelongsTo
    {
        return $this->belongsTo(Disease::class);
    }

    public function diseases(): BelongsToMany
    {
        return $this->belongsToMany(Disease::class)
                    ->withPivot('dosage', 'notes')
                    ->withTimestamps();
    }

    public function patientHistories(): HasMany
    {
        return $this->hasMany(MedicinePatientHistory::class);
    }

    public function prescriptions(): BelongsToMany
    {
        return $this->belongsToMany(Prescription::class, 'prescription_medicine')
                    ->withPivot(['dosage', 'quantity', 'notes'])
                    ->withTimestamps();
    }

    public function penyakits()
    {
        return $this->belongsToMany(Penyakit::class, 'penyakit_medicine');
    }
}
