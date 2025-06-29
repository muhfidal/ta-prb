<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    protected $fillable = [
        'nama_obat',
        'deskripsi',
        'harga',
        'stok'
    ];

    public function matriksObat1()
    {
        return $this->hasMany(MatriksObat::class, 'obat1_id');
    }

    public function matriksObat2()
    {
        return $this->hasMany(MatriksObat::class, 'obat2_id');
    }
}
