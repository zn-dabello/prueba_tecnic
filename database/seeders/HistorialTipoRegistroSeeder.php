<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\General\HistorialTipoRegistro;

class HistorialTipoRegistroSeeder extends Seeder
{
      /**
      * Run the database seeds.
      *
      * @return void
      */
      public function run()
      {

            HistorialTipoRegistro::insert([

                  ['id' => '1', 'descripcion' => 'Usuario', 'tiene_listado' => '1', 'created_at' => NULL,'update_at' => NULL],
                  ['id' => '2', 'descripcion' => 'Cliente', 'tiene_listado' => '0', 'created_at' => NULL,'update_at' => NULL],
                  ['id' => '3', 'descripcion' => 'Dirección', 'tiene_listado' => '0', 'created_at' => NULL,'update_at' => NULL],
                  ['id' => '4', 'descripcion' => 'Roles y Accesos', 'tiene_listado' => '0', 'created_at' => NULL,'update_at' => NULL],
                  ['id' => '5', 'descripcion' => 'Documentos', 'tiene_listado' => '1', 'created_at' => NULL,'update_at' => NULL],
                  ['id' => '6', 'descripcion' => 'Tipo Documentos', 'tiene_listado' => '0', 'created_at' => NULL,'update_at' => NULL],
                  ['id' => '7', 'descripcion' => 'Etapas', 'tiene_listado' => '0', 'created_at' => NULL,'update_at' => NULL],
                  ['id' => '8', 'descripcion' => 'Flujo Documental', 'tiene_listado' => '0', 'created_at' => NULL,'update_at' => NULL],
                  ['id' => '9', 'descripcion' => 'Flujo Documental Etapa', 'tiene_listado' => '0', 'created_at' => NULL,'update_at' => NULL],
                  ['id' => '10', 'descripcion' => 'Documento Obligatorio', 'tiene_listado' => '0', 'created_at' => NULL,'update_at' => NULL],
                  ['id' => '11', 'descripcion' => 'Sub-Direcciones', 'tiene_listado' => '0', 'created_at' => NULL,'update_at' => NULL],
                  ['id' => '12', 'descripcion' => 'Unidades', 'tiene_listado' => '0', 'created_at' => NULL,'update_at' => NULL],
                  ['id' => '13', 'descripcion' => 'Mis Documentos', 'tiene_listado' => '1', 'created_at' => NULL,'update_at' => NULL],
                  ['id' => '14', 'descripcion' => 'Anexos', 'tiene_listado' => '0', 'created_at' => NULL,'update_at' => NULL]

            ]);

      }
}
