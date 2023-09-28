<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistorialListadosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('historial_listados', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->smallInteger('cliente_id')->index('fk_historial_listados_clientes1_idx');
			$table->integer('historial_registro_listado_id')->index('fk_historial_listados_historial_registro_listados1_idx');
			$table->boolean('historial_accion_id')->index('fk_historial_listados_historial_acciones1_idx');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('historial_listados');
	}

}
