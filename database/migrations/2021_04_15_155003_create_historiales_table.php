<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistorialesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('historiales', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('ip', 16)->nullable();
			$table->timestamps();
			$table->integer('user_id')->unsigned()->index('fk_historiales_users1_idx');
			$table->smallInteger('cliente_id')->index('fk_historiales_clientes1_idx');
			$table->boolean('historial_accion_id')->nullable()->index('fk_historiales_historial_acciones1_idx');
			$table->integer('historial_registro_id')->index('fk_historiales_historial_registros1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('historiales');
	}

}
