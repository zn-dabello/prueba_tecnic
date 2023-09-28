<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Historial\Historial;
use App\Models\Historial\HistorialRegistro;

class UserHistorialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $listado_historial_registro = new HistorialRegistro();
        $datos = $listado_historial_registro->datosHistorialSeeder(1);

        foreach ($datos as $key => $registro) {

            Historial::insert([
                'ip' => '127.0.0.1',
                'created_at' => $registro['created_at'],
                'user_id' => 1,
                'cliente_id' => $registro['cliente_id'],
                'historial_accion_id' => 1,
                'historial_registro_id' => $registro['id']
            ]);

        }
    }
}
