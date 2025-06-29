<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyakit extends Model
{
    use HasFactory;
    protected $table = 'penyakits';
    protected $fillable = [
        'nama_penyakit',
        'deskripsi'
    ];

    public function medicines()
    {
        return $this->belongsToMany(Medicine::class, 'penyakit_medicine');
    }

    public function penilaianAlternatifs()
    {
        return $this->hasMany(PenilaianAlternatif::class);
    }

    public function matriksObat()
    {
        return $this->hasMany(MatriksObat::class);
    }
}
