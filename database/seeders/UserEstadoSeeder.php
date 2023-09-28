<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User\UserEstado;
use Illuminate\Support\Facades\Schema;

class UserEstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        \DB::statement('SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";');
        UserEstado::insert([

			['id' => '-1','descripcion' => 'Eliminado'],
			['id' => '0','descripcion' => 'Inactivo'],
			['id' => '1','descripcion' => 'Activo'],
			['id' => '2','descripcion' => 'Sin Ingresar']

	    ]);
    }
}
