<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\General\HistorialAccion;

class HistorialAccionSeeder extends Seeder
{
      /**
      * Run the database seeds.
      *
      * @return void
      */
      public function run()
      {

            HistorialAccion::insert([

                  ['id' => '1','descripcion' => 'Agregar','detalle' => '0'],
                  ['id' => '2','descripcion' => 'Borrar','detalle' => '0'],
                  ['id' => '3','descripcion' => 'Editar','detalle' => '1'],
                  ['id' => '7','descripcion' => 'Cambiar Contraseña','detalle' => '0']

            ]);

      }
}
 