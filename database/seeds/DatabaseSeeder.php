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
         /*$this->call(UserSeeder::class);
         $this->call(PermissionsTableSeeder::class);
         $this->call(ColaboradoresSeeder::class);
         $this->call(PeriodosDevosSeeder::class);
         $this->call(MarcasSeeder::class);
         $this->call(BodegasSeeder::class);
         $this->call(ProveedoresSeeder::class);
         $this->call(UnidadesSeeder::class);
         $this->call(CorrelativosSeeder::class);
         $this->call(CategoriasSeeder::class);
         $this->call(SubCategoriasSeeder::class);
         $this->call(ColoresSeeder::class);
         $this->call(ArticulosSeeder::class);
         $this->call(EstantesSeeder::class);
         $this->call(SectoresSeeder::class);
         $this->call(AreasSeeder::class);
         $this->call(UbicacionesSeeder::class);
         $this->call(PosicionesSeeder::class);*/
         $this->call(ServiciosSeeder::class);
         $this->call(AgenciasSeeder::class);
         $this->call(ContenidosSeeder::class);
         $this->call(TipoFacturacionesSeeder::class);
         $this->call(TrabajosSeeder::class);
         $this->call(CampoFormulariosSeeder::class);
         $this->call(CampoTrabajosSeeder::class);
         $this->call(ServicioTrabajosSeeder::class);
         $this->call(TarifariosSeeder::class);
         $this->call(CampoServiciosSeeder::class);
    }
}
