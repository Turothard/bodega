<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(UserSeeder::class);
         $this->call(PermissionsTableSeeder::class);
         $this->call(ColaboradoresSeeder::class);
         $this->call(PeriodosDevosSeeder::class);
         $this->call(MarcasSeeder::class);
         $this->call(BodegasSeeder::class);
         $this->call(ProveedoresSeeder::class);
         $this->call(UnidadesSeeder::class);
         $this->call(CategoriasSeeder::class);
         $this->call(SubCategoriasSeeder::class);
         $this->call(ColoresSeeder::class);
         $this->call(ArticulosSeeder::class);
         $this->call(EstantesSeeder::class);
         $this->call(SectoresSeeder::class);
         $this->call(AreasSeeder::class);
         $this->call(UbicacionesSeeder::class);
         $this->call(PosicionesSeeder::class);
    }
}
