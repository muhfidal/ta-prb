<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpkRecommendationHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'patient_id', 'user_id', 'penyakit_ids', 'rekomendasi', 'taken_medicines'
    ];
    protected $casts = [
        'penyakit_ids' => 'array',
        'rekomendasi' => 'array',
        'taken_medicines' => 'array',
    ];
    public function patient() { return $this->belongsTo(Patient::class); }
    public function user() { return $this->belongsTo(User::class); }
}
