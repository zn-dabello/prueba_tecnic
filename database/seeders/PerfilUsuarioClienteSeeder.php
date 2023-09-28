<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User\PerfilUsuarioCliente;

class PerfilUsuarioClienteSeeder extends Seeder
{
      /**
      * Run the database seeds.
      *
      * @return void
      */
      public function run()
      {

            PerfilUsuarioCliente::insert([

                  ['id' => '1','user_id' => 1,'cliente_id' => env('CLIENTE_ACTIVO'), 'perfil_id' => 1, 'estado_id' => 1]
                  
            ]);

      }
}
 