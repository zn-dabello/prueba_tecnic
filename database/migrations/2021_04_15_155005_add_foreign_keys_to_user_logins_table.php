<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToUserLoginsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('user_logins', function(Blueprint $table)
		{
			$table->foreign('cliente_id', 'fk_user_logins_clientes1')->references('id')->on('clientes')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('perfil_id', 'fk_user_logins_perfiles1')->references('id')->on('perfiles')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('user_id', 'fk_user_logins_users1')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('user_logins', function(Blueprint $table)
		{
			$table->dropForeign('fk_user_logins_clientes1');
			$table->dropForeign('fk_user_logins_perfiles1');
			$table->dropForeign('fk_user_logins_users1');
		});
	}

}
