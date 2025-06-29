<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pengaturan_fuzzy', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kriteria_id')->constrained('kriterias')->onDelete('cascade');
            $table->decimal('min_value', 10, 4);
            $table->decimal('max_value', 10, 4);
            $table->string('fuzzy_set');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengaturan_fuzzy');
    }
};
