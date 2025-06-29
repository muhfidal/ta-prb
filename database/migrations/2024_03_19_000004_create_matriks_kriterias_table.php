<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('matriks_kriterias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kriteria1_id')->constrained('kriterias')->onDelete('cascade');
            $table->foreignId('kriteria2_id')->constrained('kriterias')->onDelete('cascade');
            $table->decimal('nilai_l', 10, 4);
            $table->decimal('nilai_m', 10, 4);
            $table->decimal('nilai_u', 10, 4);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('matriks_kriterias');
    }
};
