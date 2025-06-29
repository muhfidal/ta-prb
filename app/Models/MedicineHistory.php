<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicineHistory extends Model
{
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
