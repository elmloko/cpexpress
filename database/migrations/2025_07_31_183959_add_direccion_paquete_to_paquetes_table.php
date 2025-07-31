<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('paquetes', function (Blueprint $table) {
            $table->string('direccion_paquete', 99)->nullable();
        });
    }

    public function down()
    {
        Schema::table('paquetes', function (Blueprint $table) {
            $table->dropColumn('direccion_paquete');
        });
    }
};
