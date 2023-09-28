<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\General\Cliente;
use Illuminate\Support\Facades\Schema;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        \DB::statement('SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";');
        Cliente::insert([
          ['id' => env('CLIENTE_ACTIVO'),  'rut' => '96.572.360|9', 'nombre_fantasia' => 'Base ZonaNube',   'razon_social' => 'ZonaNube', 'direccion'=> 'General Bustamante 428', 'comuna_id'=> '13123', 'estado_id'=> 1]
        ]);
    }
}
