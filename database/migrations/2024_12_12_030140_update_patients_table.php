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
        Schema::table('patients', function (Blueprint $table) {
            $table->foreignId('disease_id')->nullable()->constrained();
            $table->foreignId('medicine_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            if (Schema::hasColumn('patients', 'disease_id')) {
                $table->dropForeign(['disease_id']);
                $table->dropColumn('disease_id');
            }
            if (Schema::hasColumn('patients', 'medicine_id')) {
                $table->dropForeign(['medicine_id']);
                $table->dropColumn('medicine_id');
            }
        });
    }
};
