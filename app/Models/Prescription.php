<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Prescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'prescription_number',
        'patient_id',
        'prescription_date',
        'notes',
        'created_by'
    ];

    protected $casts = [
        'prescription_date' => 'datetime',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function diseases(): BelongsToMany
    {
        return $this->belongsToMany(Disease::class)
            ->withTimestamps();
    }

    public function medicines(): BelongsToMany
    {
        return $this->belongsToMany(Medicine::class, 'prescription_medicine')
            ->withPivot(['dosage', 'quantity', 'notes'])
            ->withTimestamps();
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function histories(): HasMany
    {
        return $this->hasMany(MedicinePatientHistory::class, 'prescription_id');
    }
}
