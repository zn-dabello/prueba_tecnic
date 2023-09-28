<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistorialListadoCambiosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('historial_listado_cambios', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('anterior', 250)->nullable();
			$table->string('nuevo', 250)->nullable();
			$table->integer('historial_listado_id')->index('fk_historial_listado_cambios_historial_listados1_idx');
			$table->smallInteger('historial_label_id')->index('fk_historial_listado_cambios_historial_labels1_idx');
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
		Schema::drop('historial_listado_cambios');
	}

}
