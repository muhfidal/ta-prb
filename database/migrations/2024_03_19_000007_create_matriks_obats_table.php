<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('matriks_obats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penyakit_id')->constrained('penyakits')->onDelete('cascade');
            $table->foreignId('kriteria_id')->constrained('kriterias')->onDelete('cascade');
            $table->foreignId('obat1_id')->constrained('obats')->onDelete('cascade');
            $table->foreignId('obat2_id')->constrained('obats')->onDelete('cascade');
            $table->decimal('nilai_l', 10, 4);
            $table->decimal('nilai_m', 10, 4);
            $table->decimal('nilai_u', 10, 4);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('matriks_obats');
    }
};
