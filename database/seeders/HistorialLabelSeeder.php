<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\General\HistorialLabel;

class HistorialLabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        HistorialLabel::insert([

              ['id' => '1','label' => 'Nombre'],
              ['id' => '3','label' => 'Teléfono'],
              ['id' => '4','label' => 'Domicilio'],
              ['id' => '5','label' => 'Estado'],
              ['id' => '6','label' => 'Estado Usuario'],
              ['id' => '7','label' => 'Descripción'],
              ['id' => '8','label' => 'Dirección'], // Direccion Texto

              ['id' => '9','label' => 'Apellido'],
              ['id' => '10','label' => 'Encargado de'],
              ['id' => '11','label' => 'Sub-Direccion'],
              ['id' => '12','label' => 'Rut'],
              ['id' => '13','label' => 'Cargo'],
              ['id' => '14','label' => 'Usuario'],
              ['id' => '15','label' => 'Correo Electrónico'],
              ['id' => '16','label' => 'Unidad'],
              ['id' => '17','label' => 'Tiene Plantilla'],
              ['id' => '18','label' => 'Inicial'],
              ['id' => '19','label' => 'Final'],
              ['id' => '20','label' => 'Acción'],
              ['id' => '21','label' => 'Etapa'],
              ['id' => '22','label' => 'Obligatorio'],
              ['id' => '23','label' => 'Tipo de Documento'],
              ['id' => '24','label' => 'Estado Documento'],
              ['id' => '25','label' => 'Materia o Tema del Documento'],
              ['id' => '26','label' => 'Usa Plantilla'],
              ['id' => '27','label' => 'Documento Reservado'],
              ['id' => '28','label' => 'Estado Documento'],
              ['id' => '29','label' => 'Archivo'],
              ['id' => '30','label' => 'Dirección'], //Relacionada con Modulo Direccion
              ['id' => '31','label' => 'Plantilla']

        ]);
    }
}
