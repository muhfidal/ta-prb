<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::dropIfExists('matriks_kriterias');
    }

    public function down()
    {
        // Tidak perlu implementasi karena ini adalah penghapusan
    }
};
