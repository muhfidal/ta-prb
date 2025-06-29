<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('penilaian_alternatifs', function (Blueprint $table) {
            $table->foreignId('penyakit_id')->nullable()->after('medicine_id')->constrained('penyakits')->onDelete('cascade');
        });
    }
    public function down() {
        Schema::table('penilaian_alternatifs', function (Blueprint $table) {
            $table->dropForeign(['penyakit_id']);
            $table->dropColumn('penyakit_id');
        });
    }
};
