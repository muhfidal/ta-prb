<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Disease extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    public function medicines(): BelongsToMany
    {
        return $this->belongsToMany(Medicine::class)
                    ->withPivot('dosage', 'notes')
                    ->withTimestamps();
    }

    public function prescriptions(): BelongsToMany
    {
        return $this->belongsToMany(Prescription::class)
                    ->withTimestamps();
    }
}
