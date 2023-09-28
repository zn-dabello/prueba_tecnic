<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class HistorialAccionesMinusculaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('UPDATE historial_acciones SET descripcion = CONCAT(UPPER(LEFT(descripcion, 1)), LOWER(SUBSTRING(descripcion, 2)));');
        \DB::statement('UPDATE historial_acciones SET descripcion = "Ordenar: Bajar" WHERE id = 28;');
        \DB::statement('UPDATE historial_acciones SET descripcion = "Ordenar: Subir" WHERE id = 29;');
        \DB::statement('UPDATE historial_labels SET label = "Acción del Navegador" WHERE id = 60;');
        \DB::statement('UPDATE historial_tipo_registros SET descripcion = "Contenido" WHERE id = 49;');
        \DB::statement('UPDATE historial_tipo_registros SET descripcion = "Currículo" WHERE id = 50;');
        \DB::statement('UPDATE historial_tipo_registros SET tiene_listado = 0 WHERE id = 1;');
        
    }
}
