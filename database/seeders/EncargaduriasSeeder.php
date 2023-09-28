<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MiInstitucion\UserEncargaduria;

class EncargaduriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserEncargaduria::insert([

            ['id' => '1','descripcion' => 'Soporte', 'created_at' => '2023-08-23 11:14:00'],
            ['id' => '2','descripcion' => 'Institución', 'created_at' => '2023-08-23 11:14:00'],
            ['id' => '3','descripcion' => 'Dirección', 'created_at' => '2023-08-23 11:14:00'],
            ['id' => '4','descripcion' => 'Sub-Dirección', 'created_at' => '2023-08-23 11:14:00'],
            ['id' => '5','descripcion' => 'Unidad', 'created_at' => '2023-08-23 11:14:00']

        ]);
    }
}
