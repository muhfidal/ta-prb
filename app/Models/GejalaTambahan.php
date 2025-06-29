<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GejalaTambahan extends Model
{
    use HasFactory;

    protected $table = 'gejala_tambahan';

    protected $fillable = [
        'kriteria_id',
        'nama_gejala',
        'bobot',
        'deskripsi'
    ];

    protected $casts = [
        'bobot' => 'float'
    ];

    public function kriteria(): BelongsTo
    {
        return $this->belongsTo(Kriteria::class);
    }
}
