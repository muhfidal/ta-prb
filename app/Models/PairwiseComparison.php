<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PairwiseComparison extends Model
{
    use HasFactory;

    protected $table = 'pairwise_comparisons';

    protected $fillable = [
        'kriteria_id_1',
        'kriteria_id_2',
        'nilai'
    ];

    protected $casts = [
        'nilai' => 'float'
    ];

    public function kriteria1(): BelongsTo
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_id_1');
    }

    public function kriteria2(): BelongsTo
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_id_2');
    }
}
