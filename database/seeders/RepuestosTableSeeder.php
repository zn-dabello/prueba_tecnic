<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RepuestosTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('repuestos')->truncate();

        $repuestos = [
            [
                'nombre_repuesto' => 'Memoria RAM DDR4 8GB',
                'cantidad' => 20,
            ],
            [
                'nombre_repuesto' => 'Disco Duro SSD 512GB',
                'cantidad' => 15,
            ],
            [
                'nombre_repuesto' => 'Tarjeta Gráfica NVIDIA GeForce GTX 1660',
                'cantidad' => 10,
            ],

        ];


        DB::table('repuestos')->insert($repuestos);
    }
}


