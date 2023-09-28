<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\General\Menu;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class MenusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        \DB::statement('TRUNCATE TABLE menus;');
        Menu::insert([
            ////// PERFIL ADMINISTRADOR GENERAL /////////

            //Inicio
            ['id'=>1, 'cliente_id' => env('CLIENTE_ACTIVO'), 'descripcion' => 'Inicio', 'ruta' => 'home', 'etiqueta'=>'Inicio', 'padre'=>0, 'orden'=>0, 'perfil_id'=>1, 'espacio'=>0, 'modulo_id'=>1,'updated_at' => new \Carbon\Carbon, 'created_at' => new \Carbon\Carbon],

            // Munitas
            ['id'=>2, 'cliente_id' => env('CLIENTE_ACTIVO'), 'descripcion' => 'Minutas', 'ruta' => 'minutas', 'etiqueta'=>'Minutas', 'padre'=>0, 'orden'=>1, 'perfil_id'=>1, 'espacio'=>0, 'modulo_id'=>2,'updated_at' => new \Carbon\Carbon, 'created_at' => new \Carbon\Carbon],

            //Mantenciones
            ['id'=>3, 'cliente_id' => env('CLIENTE_ACTIVO'), 'descripcion' => 'Mantencion', 'ruta' => '#', 'etiqueta'=>'Mantencion', 'padre'=>0, 'orden'=>2, 'perfil_id'=>1, 'espacio'=>0, 'modulo_id'=>3,'updated_at' => new \Carbon\Carbon, 'created_at' => new \Carbon\Carbon],

                ['id'=>6, 'cliente_id' => env('CLIENTE_ACTIVO'), 'descripcion' => 'Registrar Equipos', 'ruta' => 'mantencion/registrarse', 'etiqueta'=>'Registrar', 'padre'=>3, 'orden'=>2, 'perfil_id'=>1, 'espacio'=>4, 'modulo_id'=>5,'updated_at' => new \Carbon\Carbon, 'created_at' => new \Carbon\Carbon],


        ]);
    }
}
