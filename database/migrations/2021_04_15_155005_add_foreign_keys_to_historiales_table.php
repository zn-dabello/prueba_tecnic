<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToHistorialesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('historiales', function(Blueprint $table)
		{
			$table->foreign('cliente_id', 'fk_historiales_clientes1')->references('id')->on('clientes')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('historial_accion_id', 'fk_historiales_historial_acciones1')->references('id')->on('historial_acciones')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('historial_registro_id', 'fk_historiales_historial_registros1')->references('id')->on('historial_registros')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('user_id', 'fk_historiales_users1')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('historiales', function(Blueprint $table)
		{
			$table->dropForeign('fk_historiales_clientes1');
			$table->dropForeign('fk_historiales_historial_acciones1');
			$table->dropForeign('fk_historiales_historial_registros1');
			$table->dropForeign('fk_historiales_users1');
		});
	}

}
