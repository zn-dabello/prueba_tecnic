<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistorialRegistrosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('historial_registros', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->smallInteger('cliente_id')->index('fk_historial_registros_clientes1_idx');
			$table->longtext('descripcion')->nullable();
			$table->string('listados', 45)->nullable()->comment('ids tipo registro');
			$table->timestamps();
			$table->integer('historial_registro')->index('modulo');
			$table->boolean('historial_tipo_registro_id')->index('fk_historial_registros_historial_tipo_registros1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('historial_registros');
	}

}
