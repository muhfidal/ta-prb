<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kriterias', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kriteria');
            $table->text('deskripsi')->nullable();
            $table->enum('tipe_kriteria', ['benefit', 'cost']);
            $table->decimal('bobot_l', 10, 4)->nullable();
            $table->decimal('bobot_m', 10, 4)->nullable();
            $table->decimal('bobot_u', 10, 4)->nullable();
            $table->decimal('bobot_defuzzifikasi', 10, 4)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kriterias');
    }
};
