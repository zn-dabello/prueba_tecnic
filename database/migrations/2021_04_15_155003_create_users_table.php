<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre', 250);
			$table->string('apellido', 250)->nullable();
			$table->string('usuario', 250);
			$table->string('cargo', 250)->nullable();
			$table->string('telefono', 20)->nullable();
			$table->string('email', 250);
			$table->string('rut', 70)->nullable();
			$table->dateTime('email_verified_at')->nullable();
			$table->string('password', 250);
			$table->string('remember_token', 100)->nullable();
			$table->string('hash', 200)->nullable();
			$table->smallInteger('user_estado_id')->default(1);
			$table->smallInteger('perfil_id')->default(1);
			$table->smallInteger('cliente_id');
			$table->tinyInteger('recibir_correo_id')->default(0);
			$table->smallInteger('encargaduria_id');
			$table->smallInteger('direccion_id')->nullable();
			$table->smallInteger('subdireccion_id')->nullable();
			$table->smallInteger('unidad_id')->nullable();
			$table->timestamps();

			$table->foreign('user_estado_id')->references('id')->on('user_estados');
			$table->foreign('perfil_id')->references('id')->on('perfiles');
			$table->foreign('cliente_id')->references('id')->on('clientes');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
