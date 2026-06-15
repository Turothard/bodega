<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Bodega;
class BodegasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arreglo= ['BOD01_Bodega Principal_Principal_Oficina Zeal Servicios 3er Piso','BOD02_Bodega Planta Zeal_Principal_Oficina Zeal Servicios 1er Piso'
        ,'BOD03_Bodega prueba_Principal_prueba'];
        for ($i=0; $i < count($arreglo); $i++) { 
            $array = explode("_",$arreglo[$i]);
            Bodega::create([
                'idbodega' => $array[0],
                'nombrebod' => $array[1],
                'tipobod' => $array[2],
                'localizacionbod' => $array[3],
            ]);
        }
    }
}
