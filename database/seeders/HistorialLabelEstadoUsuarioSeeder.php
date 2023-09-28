<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\General\HistorialLabel;

class HistorialLabelEstadoUsuarioSeeder extends Seeder
{
      /**
      * Run the database seeds.
      *
      * @return void
      */
      public function run()
      {

            HistorialLabel::insert([

                  ['id' => '48','label' => 'Estado Usuario'],

            ]);

      }
}
 