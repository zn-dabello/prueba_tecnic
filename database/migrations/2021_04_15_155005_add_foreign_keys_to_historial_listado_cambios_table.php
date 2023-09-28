<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToHistorialListadoCambiosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('historial_listado_cambios', function(Blueprint $table)
		{
			$table->foreign('historial_label_id', 'fk_historial_listado_cambios_historial_labels1')->references('id')->on('historial_labels')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('historial_listado_id', 'fk_historial_listado_cambios_historial_listados1')->references('id')->on('historial_listados')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('historial_listado_cambios', function(Blueprint $table)
		{
			$table->dropForeign('fk_historial_listado_cambios_historial_labels1');
			$table->dropForeign('fk_historial_listado_cambios_historial_listados1');
		});
	}

}
