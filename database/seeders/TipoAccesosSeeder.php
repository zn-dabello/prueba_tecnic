<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MiInstitucion\TipoAcceso;

class TipoAccesosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {        
        TipoAcceso::insert([

            ['id' => '1','descripcion' => 'Sin Acceso'],
            ['id' => '2','descripcion' => 'Administrar'],
            ['id' => '3','descripcion' => 'Visualizar'],

        ]);
    }
}
