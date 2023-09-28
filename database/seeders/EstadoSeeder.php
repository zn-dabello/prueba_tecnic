<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\General\Estado;

class EstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";');
        Estado::insert([

			['id' => '-1','descripcion' => 'Eliminado'],
			['id' => '0','descripcion' => 'Inactivo'],
			['id' => '1','descripcion' => 'Activo'],

	    ]);
    }
}
