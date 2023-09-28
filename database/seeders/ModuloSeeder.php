<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MiInstitucion\Modulo;

class ModuloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
        Modulo::insert([

            ['id' => '1','descripcion' => 'Inicio', 'tipo_modulo' => 1, 'modulo_padre' => 0],
            ['id' => '2','descripcion' => 'Minutas', 'tipo_modulo' => 1, 'modulo_padre' => 0],
            ['id' => '3','descripcion' => 'Mi Institución', 'tipo_modulo' => 1, 'modulo_padre' => 0],
            ['id' => '4','descripcion' => 'Mi Institución / Ficha', 'tipo_modulo' => 2, 'modulo_padre' => 3],
            ['id' => '5','descripcion' => 'Mi Institución / Direcciones', 'tipo_modulo' => 2, 'modulo_padre' => 3],
            ['id' => '6','descripcion' => 'Mi Institución / Sub-Direcciones', 'tipo_modulo' => 2, 'modulo_padre' => 3],
            ['id' => '7','descripcion' => 'Mi Institución / Unidades', 'tipo_modulo' => 2, 'modulo_padre' => 3],
            ['id' => '8','descripcion' => 'Mi Institución / Usuarios', 'tipo_modulo' => 2, 'modulo_padre' => 3]

        ]);
    }
}
