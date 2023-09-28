<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToHistorialRegistroListadosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('historial_registro_listados', function(Blueprint $table)
		{
			$table->foreign('cliente_id', 'fk_historial_registro_listados_clientes1')->references('id')->on('clientes')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('historial_registro_id', 'fk_historial_registro_listados_historial_registros1')->references('id')->on('historial_registros')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('historial_tipo_registro_id', 'fk_historial_registro_listados_historial_tipo_registros1')->references('id')->on('historial_tipo_registros')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('historial_registro_listados', function(Blueprint $table)
		{
			$table->dropForeign('fk_historial_registro_listados_clientes1');
			$table->dropForeign('fk_historial_registro_listados_historial_registros1');
			$table->dropForeign('fk_historial_registro_listados_historial_tipo_registros1');
		});
	}

}
