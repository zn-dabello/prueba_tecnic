<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserEstadoSeeder::class);
        $this->call(EstadoSeeder::class);
        $this->call(PerfilSeeder::class);
        $this->call(ClienteSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(PerfilUsuarioClienteSeeder::class);
        $this->call(PaisesSeeder::class);
        $this->call(RegionesSeeder::class);
        $this->call(ComunaSeeder::class);
        $this->call(HistorialAccionSeeder::class);
        $this->call(HistorialTipoRegistroSeeder::class);
        $this->call(HistorialRegistrosTableSeeder::class);
        $this->call(UserHistorialSeeder::class);
        $this->call(MenusSeeder::class);
        $this->call(HistorialLabelSeeder::class);
        $this->call(EncargaduriasSeeder::class);
        $this->call(TipoAccesosSeeder::class);
        $this->call(ModuloSeeder::class);
        $this->call(UserModuloAccesoSeeder::class);
        $this->call(RepuestosTableSeeder::class);
    }
}
