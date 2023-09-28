<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User\Perfil;

class PerfilSeeder extends Seeder
{
      /**
      * Run the database seeds.
      *
      * @return void
      */
      public function run()
      {

            Perfil::insert([

                  ['id' => '1','visualizador' => '0','nombre' => 'Administrador General','created_at' => NULL,'updated_at' => NULL,'cliente_id' => NULL,'estado_id' => '1'],
                  ['id' => '2','visualizador' => '1','nombre' => 'Visualizador','created_at' => NULL,'updated_at' => NULL,'cliente_id' => NULL,'estado_id' => '1']

            ]);

      }
}
 