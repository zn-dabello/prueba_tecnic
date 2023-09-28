<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User\User;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    User::insert([

      ['id' => 1,  'nombre' => 'Administrador',  'apellido' => 'ZonaNube',  'usuario' => 'portal', 'email' => 'portal@zonanube.cl', 'password' => '$2y$10$CQR0wPUBipx6xi4AdRCymuVVr0EseTWBTJwp0p.dOQ4GsW4rcuPCa', 'user_estado_id' => 1, 'perfil_id' => 1, 'recibir_correo_id' => 0, 'cliente_id' => env('CLIENTE_ACTIVO'), 'encargaduria_id' => 1]
      
    ]);
  }
}
