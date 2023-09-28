<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User\User;

class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([

          ['id' => 2,  'nombre' => 'Alvaro',  'apellido' => 'Zuleta',  'usuario' => 'azuleta', 'email' => 'azuleta@zonanube.cl', 'password' => '0000', 'user_estados_id' => 2, 'perfil_id' => 1, 'recibir_correo_id' => 1],
          ['id' => 3,  'nombre' => 'Raudely',  'apellido' => 'Pimentel',  'usuario' => 'rpimentel', 'email' => 'rpimentel@zonanube.com', 'password' => '0000', 'user_estados_id' => 2, 'perfil_id' => 1, 'recibir_correo_id' => 1]
          
        ]);
    }
}
