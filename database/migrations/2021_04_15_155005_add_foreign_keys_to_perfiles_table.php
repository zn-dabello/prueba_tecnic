<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToPerfilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('perfiles', function(Blueprint $table)
		{
			$table->foreign('cliente_id', 'fk_perfiles_clientes1')->references('id')->on('clientes')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('estado_id', 'fk_perfiles_estados1')->references('id')->on('estados')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('perfiles', function(Blueprint $table)
		{
			$table->dropForeign('fk_perfiles_clientes1');
			$table->dropForeign('fk_perfiles_estados1');
		});
	}

}
