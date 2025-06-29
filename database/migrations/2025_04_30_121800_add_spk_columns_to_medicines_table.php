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
        Schema::table('medicines', function (Blueprint $table) {
            $table->foreignId('disease_id')->nullable()->constrained('diseases')->nullOnDelete();
            $table->float('score')->nullable()->comment('Skor Fuzzy AHP untuk obat ringan');
            $table->string('dose')->nullable()->comment('Dosis obat (misal: 3x1 sehari)');
            $table->integer('quantity')->nullable()->comment('Jumlah default untuk obat');
            $table->text('reason')->nullable()->comment('Alasan rekomendasi untuk obat ringan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medicines', function (Blueprint $table) {
            $table->dropForeign(['disease_id']);
            $table->dropColumn(['disease_id', 'score', 'dose', 'reason', 'quantity']);
        });
    }
};
