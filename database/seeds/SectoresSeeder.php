<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Sectore;
class SectoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arreglo= ["RDA_Recinto Depósito Aduanero_Camino La Pólvora km 12.7 Valparaíso Chile","ZAO_Zona de Actividades Obligatorias_Camino La Pólvora km 12.7 Valparaíso Chile"];
        for ($i=0; $i < count($arreglo); $i++) { 
            $array = explode("_",$arreglo[$i]);
            Sectore::create([
                'nombresec' => $array[0],
                'descripcionsec' => $array[1],
                'direccionsec' => $array[2],
            ]);
        }
    }
}
