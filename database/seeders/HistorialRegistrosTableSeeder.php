<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class HistorialRegistrosTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        
        \DB::table('historial_registros')->insert([
            [
                'cliente_id' => env('CLIENTE_ACTIVO'),
                'descripcion' => 'User ZonaNube',
                'listados' => "4",
                'created_at' => NULL,
                'updated_at' => NULL,
                'historial_registro' => 1,
                'historial_tipo_registro_id' => 1,
            ],
           [
                'cliente_id' => env('CLIENTE_ACTIVO'),
                'descripcion' => 'Base ZonaNube',
                'listados' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'historial_registro' => 1,
                'historial_tipo_registro_id' => 2,
            ]
        ]);
        
        
    }
}