<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('matriks_obats', function (Blueprint $table) {
            // Hapus kolom lama
            $table->dropForeign(['obat1_id']);
            $table->dropForeign(['obat2_id']);
            $table->dropColumn(['obat1_id', 'obat2_id']);

            // Tambah kolom baru
            $table->foreignId('medicine_id')->after('kriteria_id')->constrained('medicines')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('matriks_obats', function (Blueprint $table) {
            // Hapus kolom baru
            $table->dropForeign(['medicine_id']);
            $table->dropColumn('medicine_id');

            // Kembalikan kolom lama
            $table->foreignId('obat1_id')->after('kriteria_id')->constrained('obats')->onDelete('cascade');
            $table->foreignId('obat2_id')->after('obat1_id')->constrained('obats')->onDelete('cascade');
        });
    }
};
