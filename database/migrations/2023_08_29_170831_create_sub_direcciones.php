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
        Schema::create('sub_direcciones', function (Blueprint $table) {
            $table->id();
            $table->Integer('direccion_id');
            $table->integer('estado_id')->default(1);
            $table->string('descripcion', 255);
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_direcciones');
    }
};
