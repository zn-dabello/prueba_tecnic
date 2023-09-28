<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserModuloAccesoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        \DB::statement('INSERT INTO user_modulo_accesos (user_id, modulo_id, tipo_acceso_id)
                      SELECT DISTINCT 1, m.id, 2
                      FROM
                          modulos m
                      WHERE
                        m.estado_id = 1;');
    }
}
