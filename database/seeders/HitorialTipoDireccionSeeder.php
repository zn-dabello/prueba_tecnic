<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\General\HistorialTipoRegistro;

class HitorialTipoDireccionSeeder extends Seeder
{
    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {

          HistorialTipoRegistro::insert([

                ['id' => '3', 'descripcion' => 'Dirección', 'tiene_listado' => '0', 'created_at' => NULL,'update_at' => NULL]

          ]);

    }
}
