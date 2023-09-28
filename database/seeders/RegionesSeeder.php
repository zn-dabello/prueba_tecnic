<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Administracion\Region;

class RegionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Region::insert([
          ['id' => 1,  'nombre' => 'Tarapacá',                             'numeracion' => 'I',   'orden' => 1],
          ['id' => 2,  'nombre' => 'Antofagasta',                          'numeracion' => 'II',  'orden' => 1],
          ['id' => 3,  'nombre' => 'Atacama',                              'numeracion' => 'III', 'orden' => 3],
          ['id' => 4,  'nombre' => 'Ccoquimbo',                             'numeracion' => 'IV',  'orden' => 4],
          ['id' => 5,  'nombre' => 'Valparaíso',                           'numeracion' => 'V',   'orden' => 5],
          ['id' => 6,  'nombre' => 'Libertador B. O\'Higgins',             'numeracion' => 'VI',  'orden' => 7],
          ['id' => 7,  'nombre' => 'MAule',                                'numeracion' => 'VII', 'orden' => 8],
          ['id' => 8,  'nombre' => 'Biobío',                               'numeracion' => 'VIII','orden' => 9],
          ['id' => 9,  'nombre' => 'La Araucanía',                         'numeracion' => 'IX',  'orden' => 10],
          ['id' => 10, 'nombre' => 'Los Lagos',                            'numeracion' => 'X',   'orden' => 11],
          ['id' => 11, 'nombre' => 'Aysén del Gral. C. Ibáñez del Campo',  'numeracion' => 'XI',  'orden' => 12],
          ['id' => 12, 'nombre' => 'Magallanes y la Antártica Chilena', 'numeracion' => 'XII', 'orden' => 13],
          ['id' => 13, 'nombre' => 'Metropolitana de Santiago',            'numeracion' => 'RM',  'orden' => 6],
          ['id' => 14, 'nombre' => 'Los Ríos',                             'numeracion' => 'XIV', 'orden' => 14],
          ['id' => 15, 'nombre' => 'Arica y Parinacota',                   'numeracion' => 'XV',  'orden' => 15],
          ['id' => 16, 'nombre' => 'Ñuble',                                'numeracion' => 'XVI', 'orden' => 16]
        ]);
    }
}
