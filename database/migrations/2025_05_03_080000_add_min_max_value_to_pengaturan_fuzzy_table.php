<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengaturan_fuzzy', function (Blueprint $table) {
            if (!Schema::hasColumn('pengaturan_fuzzy', 'min_value')) {
                $table->float('min_value')->nullable()->after('kriteria_id');
            }
            if (!Schema::hasColumn('pengaturan_fuzzy', 'max_value')) {
                $table->float('max_value')->nullable()->after('min_value');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pengaturan_fuzzy', function (Blueprint $table) {
            if (Schema::hasColumn('pengaturan_fuzzy', 'min_value')) {
                $table->dropColumn('min_value');
            }
            if (Schema::hasColumn('pengaturan_fuzzy', 'max_value')) {
                $table->dropColumn('max_value');
            }
        });
    }
};
