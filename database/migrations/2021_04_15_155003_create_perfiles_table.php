<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerfilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('perfiles', function(Blueprint $table)
		{
			$table->smallInteger('id', true);
			$table->boolean('visualizador')->default(0);
			$table->string('nombre', 250)->nullable();
			$table->timestamps();
			$table->smallInteger('cliente_id')->nullable()->index('fk_perfiles_clientes1_idx1');
			$table->smallInteger('estado_id')->default(1)->index('fk_perfiles_estados1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('perfiles');
	}

}
