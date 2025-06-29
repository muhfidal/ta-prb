<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianAlternatif extends Model
{
    use HasFactory;

    protected $table = 'penilaian_alternatifs';

    protected $fillable = [
        'medicine_id',
        'kriteria_id',
        'nilai_l',
        'nilai_m',
        'nilai_u'
    ];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }

    public function penyakit()
    {
        return $this->belongsTo(Penyakit::class);
    }
}
