<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToHistorialListadosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('historial_listados', function(Blueprint $table)
		{
			$table->foreign('cliente_id', 'fk_historial_listados_clientes1')->references('id')->on('clientes')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('historial_accion_id', 'fk_historial_listados_historial_acciones1')->references('id')->on('historial_acciones')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('historial_registro_listado_id', 'fk_historial_listados_historial_registro_listados1')->references('id')->on('historial_registro_listados')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('historial_listados', function(Blueprint $table)
		{
			$table->dropForeign('fk_historial_listados_clientes1');
			$table->dropForeign('fk_historial_listados_historial_acciones1');
			$table->dropForeign('fk_historial_listados_historial_registro_listados1');
		});
	}

}
