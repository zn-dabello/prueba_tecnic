<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('mantencion_registro', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_mantencion');
            $table->string('numero_equipo');
            $table->string('marca_equipo');
            $table->string('ubicacion')->nullable();
            $table->string('proveedor')->nullable();
            $table->integer('estado_id')->default(1);
            $table->timestamps();
        });

        Schema::create('repuestos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_repuesto');
            $table->integer('cantidad');
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('repuestos');
        Schema::dropIfExists('mantencion_registro');
    }
};


