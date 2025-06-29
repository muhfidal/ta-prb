<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('penilaian_obat_global', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medicine_id')->constrained('medicines')->onDelete('cascade');
            $table->foreignId('kriteria_id')->constrained('kriterias')->onDelete('cascade');
            $table->float('nilai_l');
            $table->float('nilai_m');
            $table->float('nilai_u');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('penilaian_obat_global');
    }
};
