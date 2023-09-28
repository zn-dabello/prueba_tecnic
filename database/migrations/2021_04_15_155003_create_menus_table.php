<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('menus', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->smallInteger('cliente_id')->default(0)->index('FK__clientes_menus');
			$table->string('descripcion', 150)->nullable();
			$table->string('ruta', 200);
			$table->string('etiqueta', 50)->nullable();
			$table->integer('padre')->unsigned()->default(0);
			$table->smallInteger('orden')->default(0);
			$table->smallInteger('mis_datos')->default(0);
			$table->smallInteger('espacio')->default(0);
			$table->smallInteger('modulo_id');
			$table->smallInteger('perfil_id')->index('FK__perfiles_menu');
			$table->smallInteger('estado_id')->default(1)->index('FK__estados_menus');
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
		Schema::drop('menus');
	}

}
