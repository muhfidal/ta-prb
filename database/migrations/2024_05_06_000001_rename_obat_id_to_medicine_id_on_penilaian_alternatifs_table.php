<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('penilaian_alternatifs', function (Blueprint $table) {
            if (Schema::hasColumn('penilaian_alternatifs', 'obat_id')) {
                $table->renameColumn('obat_id', 'medicine_id');
            }
        });
    }

    public function down()
    {
        Schema::table('penilaian_alternatifs', function (Blueprint $table) {
            if (Schema::hasColumn('penilaian_alternatifs', 'medicine_id')) {
                $table->renameColumn('medicine_id', 'obat_id');
            }
        });
    }
};
