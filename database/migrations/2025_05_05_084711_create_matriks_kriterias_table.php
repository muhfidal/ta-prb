<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('matriks_kriterias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kriteria1_id')->constrained('kriterias')->onDelete('cascade');
            $table->foreignId('kriteria2_id')->constrained('kriterias')->onDelete('cascade');
            $table->double('nilai_l')->nullable();
            $table->double('nilai_m')->nullable();
            $table->double('nilai_u')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matriks_kriterias');
    }
};
