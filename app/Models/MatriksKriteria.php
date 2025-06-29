<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MatriksKriteria extends Model
{
    protected $fillable = [
        'kriteria1_id',
        'kriteria2_id',
        'nilai_l',
        'nilai_m',
        'nilai_u',
    ];

    public function kriteria1()
    {
        return $this->belongsTo(Kriteria::class, 'kriteria1_id');
    }

    public function kriteria2()
    {
        return $this->belongsTo(Kriteria::class, 'kriteria2_id');
    }
}
