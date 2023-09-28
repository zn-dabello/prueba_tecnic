<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserLoginsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_logins', function(Blueprint $table)
		{
			$table->bigInteger('id', true);
			$table->timestamps();
			$table->integer('user_id')->unsigned()->index('fk_user_logins_users1_idx');
			$table->smallInteger('cliente_id')->index('fk_user_logins_clientes1_idx');
			$table->smallInteger('perfil_id')->index('fk_user_logins_perfiles1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_logins');
	}

}
