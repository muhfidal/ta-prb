<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('penilaian_alternatifs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('obat_id')->constrained('obats')->onDelete('cascade');
            $table->foreignId('kriteria_id')->constrained('kriterias')->onDelete('cascade');
            $table->decimal('nilai_l', 8, 2);
            $table->decimal('nilai_m', 8, 2);
            $table->decimal('nilai_u', 8, 2);
            $table->timestamps();

            // Tambahkan unique constraint untuk mencegah duplikasi penilaian
            $table->unique(['obat_id', 'kriteria_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('penilaian_alternatifs');
    }
};
