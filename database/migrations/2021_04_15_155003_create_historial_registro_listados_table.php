<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistorialRegistroListadosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('historial_registro_listados', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('descripcion', 250);
			$table->smallInteger('cliente_id')->index('fk_historial_registro_listados_clientes1_idx');
			$table->integer('historial_registro_id')->index('fk_historial_registro_listados_historial_registros1_idx');
			$table->boolean('historial_tipo_registro_id')->index('fk_historial_registro_listados_historial_tipo_registros1_idx');
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
		Schema::drop('historial_registro_listados');
	}

}
