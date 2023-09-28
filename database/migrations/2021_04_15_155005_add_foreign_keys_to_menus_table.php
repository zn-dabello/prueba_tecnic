<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToMenusTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('menus', function(Blueprint $table)
		{
			$table->foreign('cliente_id', 'FK__clientes_menus_01')->references('id')->on('clientes')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('estado_id', 'FK__estados_menus_01')->references('id')->on('estados')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('perfil_id', 'FK__perfiles_menu_01')->references('id')->on('perfiles')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('menus', function(Blueprint $table)
		{
			$table->dropForeign('FK__clientes_menus_01');
			$table->dropForeign('FK__estados_menus_01');
			$table->dropForeign('FK__perfiles_menu_01');
		});
	}

}
