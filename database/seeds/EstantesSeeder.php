<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Estante;
class EstantesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arreglo= ["1_BOD01_1_2_Estante BOD01 Nro 1","2_BOD01_1_2_Estante BOD01 Nro 2","3_BOD01_1_3_Estante BOD01 Nro 3","4_BOD01_1_3_Estante BOD01 Nro 4","5_BOD01_1_3_Estante BOD01 Nro 5","6_BOD01_1_2_Estante BOD01 Nro 6","7_BOD01_1_2_Estante BOD01 Nro 7","8_BOD01_1_2_Estante BOD01 Nro 8","9_BOD01_1_4_Estante BOD01 Nro 9","10_BOD01_1_4_Estante BOD01 Nro 10","11_BOD01_1_4_Estante BOD01 Nro 11","12_BOD01_1_4_Estante BOD01 Nro 12","1_BOD02_2_3_Estante BOD02 Nro"];
        for ($i=0; $i < count($arreglo); $i++) { 
            $array = explode("_",$arreglo[$i]);
            Estante::create([
                'nroestante' => $array[0],
                'bodega_id' => $array[1],
                'sectoresest' => $array[2],
                'nivelesest' => $array[3],
                'descripcionest' => $array[4],
            ]);
        }
    }
}
