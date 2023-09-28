<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistorialTipoRegistrosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('historial_tipo_registros', function(Blueprint $table)
		{
			$table->boolean('id')->primary();
			$table->string('descripcion', 50)->nullable();
			$table->boolean('tiene_listado')->default(0)->comment('Indica si el modulo tiene submodulo');
			$table->dateTime('created_at')->nullable();
			$table->dateTime('update_at')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('historial_tipo_registros');
	}

}
