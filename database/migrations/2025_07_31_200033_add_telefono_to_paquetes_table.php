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
            $table->string('telefono', 20)->nullable()->after('direccion_paquete');
        });
    }

    public function down()
    {
        Schema::table('paquetes', function (Blueprint $table) {
            $table->dropColumn('telefono');
        });
    }
};
