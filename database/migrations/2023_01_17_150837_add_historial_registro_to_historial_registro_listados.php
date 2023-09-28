<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHistorialRegistroToHistorialRegistroListados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('historial_registro_listados', function (Blueprint $table) {
            $table->integer('registro_id')->nullable()->after('historial_registro_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('historial_registro_listados', function (Blueprint $table) {
            $table->dropColumn('registro_id');
        });
    }
}
