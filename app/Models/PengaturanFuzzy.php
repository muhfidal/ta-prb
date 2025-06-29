<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengaturanFuzzy extends Model
{
    use HasFactory;

    protected $table = 'pengaturan_fuzzy';

    protected $fillable = [
        'kriteria_id',
        'min_value',
        'max_value',
        'fuzzy_set'
    ];

    public function kriteria(): BelongsTo
    {
        return $this->belongsTo(Kriteria::class);
    }
}
