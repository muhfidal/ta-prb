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
        Schema::table('pengaturan_fuzzy', function (Blueprint $table) {
            if (!Schema::hasColumn('pengaturan_fuzzy', 'kriteria_id')) {
                $table->foreignId('kriteria_id')->nullable()->constrained('kriterias')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengaturan_fuzzy', function (Blueprint $table) {
            $table->dropForeign(['kriteria_id']);
            $table->dropColumn('kriteria_id');
        });
    }
};
