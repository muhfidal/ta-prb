<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengaturan_fuzzy', function (Blueprint $table) {
            if (!Schema::hasColumn('pengaturan_fuzzy', 'max_value')) {
                $table->float('max_value')->nullable();
            }
            if (!Schema::hasColumn('pengaturan_fuzzy', 'fuzzy_set')) {
                $table->string('fuzzy_set')->after('max_value');
            }
            if (!Schema::hasColumn('pengaturan_fuzzy', 'membership_type')) {
                $table->string('membership_type')->nullable()->after('fuzzy_set');
            }
            if (!Schema::hasColumn('pengaturan_fuzzy', 'variable_name')) {
                $table->string('variable_name')->nullable()->after('membership_type');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pengaturan_fuzzy', function (Blueprint $table) {
            $table->dropColumn(['max_value', 'fuzzy_set', 'membership_type', 'variable_name']);
        });
    }
};
