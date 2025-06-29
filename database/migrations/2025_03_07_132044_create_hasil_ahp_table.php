<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHasilAHPTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hasil_ahp', function (Blueprint $table) {
            $table->id();
            $table->json('bobot'); // Simpan vektor bobot dalam format JSON
            $table->decimal('lambda_max', 8, 3);
            $table->decimal('CI', 8, 3);
            $table->decimal('CR', 8, 3);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_ahp');
    }
}
