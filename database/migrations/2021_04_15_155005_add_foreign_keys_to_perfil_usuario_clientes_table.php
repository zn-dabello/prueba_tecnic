<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToPerfilUsuarioClientesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('perfil_usuario_clientes', function(Blueprint $table)
		{
			$table->foreign('cliente_id', 'fk_perfil_usuario_clientes_clientes1')->references('id')->on('clientes')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('estado_id', 'fk_perfil_usuario_clientes_estados1')->references('id')->on('estados')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('perfil_id', 'fk_perfil_usuario_clientes_perfiles1')->references('id')->on('perfiles')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('user_id', 'fk_perfil_usuario_clientes_users1')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('perfil_usuario_clientes', function(Blueprint $table)
		{
			$table->dropForeign('fk_perfil_usuario_clientes_clientes1');
			$table->dropForeign('fk_perfil_usuario_clientes_estados1');
			$table->dropForeign('fk_perfil_usuario_clientes_perfiles1');
			$table->dropForeign('fk_perfil_usuario_clientes_users1');
		});
	}

}
