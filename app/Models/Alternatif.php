<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alternatif extends Model
{
    use HasFactory;

    protected $table = 'alternatifs';
    protected $fillable = ['nama_obat', 'deskripsi', 'kode_obat', 'status'];

    public function penilaianAlternatifs()
    {
        return $this->hasMany(PenilaianAlternatif::class);
    }
}
