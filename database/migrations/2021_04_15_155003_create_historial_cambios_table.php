<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistorialCambiosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('historial_cambios', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('historial_id')->index('fk_historial_cambios_historiales1_idx');
			$table->smallInteger('historial_label_id')->index('fk_historial_cambios_historial_labels1_idx');
			$table->longtext('anterior')->nullable();
			$table->longtext('nuevo')->nullable();
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
		Schema::drop('historial_cambios');
	}

}
