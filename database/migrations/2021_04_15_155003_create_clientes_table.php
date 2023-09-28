<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('clientes', function(Blueprint $table)
		{
			$table->smallInteger('id', true);
			$table->string('rut', 30)->nullable();
			$table->string('nombre_fantasia')->nullable();
			$table->string('razon_social');
			$table->string('direccion', 250)->nullable();
			$table->string('telefono', 45)->nullable();
			$table->integer('comuna_id')->unsigned()->nullable()->index('fk_clientes_comunas1_idx');
			$table->smallInteger('estado_id')->default(1)->index('fk_clientes_estados1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('clientes');
	}

}
