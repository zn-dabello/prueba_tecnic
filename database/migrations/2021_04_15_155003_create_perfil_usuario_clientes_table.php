<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerfilUsuarioClientesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('perfil_usuario_clientes', function(Blueprint $table)
		{
			$table->bigInteger('id', true);
			$table->timestamps();
			$table->integer('user_id')->unsigned()->index('fk_perfil_usuario_clientes_users1_idx');
			$table->smallInteger('cliente_id')->index('fk_perfil_usuario_clientes_clientes1_idx');
			$table->smallInteger('perfil_id')->index('fk_perfil_usuario_clientes_perfiles1_idx');
			$table->boolean('revisa_documentacion')->nullable()->default(0);
			$table->smallInteger('estado_id')->default(1)->index('fk_perfil_usuario_clientes_estados1_idx');
			$table->integer('zona_id')->nullable()->index('fk_perfil_usuario_clientes_zonas1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('perfil_usuario_clientes');
	}

}
