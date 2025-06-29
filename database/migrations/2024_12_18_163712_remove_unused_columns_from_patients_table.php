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
            $table->dropForeign(['disease_id']);
            $table->dropForeign(['medicine_id']);

            $table->dropColumn(['diagnosis', 'disease_id', 'medicine_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->text('diagnosis')->nullable();
            $table->bigInteger('disease_id')->unsigned()->nullable();
            $table->bigInteger('medicine_id')->unsigned()->nullable();

            $table->foreign('disease_id')->references('id')->on('diseases');
            $table->foreign('medicine_id')->references('id')->on('medicines');
        });
    }
};
