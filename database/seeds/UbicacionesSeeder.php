<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Ubicacione;
class UbicacionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arreglo= ["1_2_Anden 1_Descripcion Anden 1","2_2_Anden 2_Descripcion Anden 2","3_2_Anden 3_Descripcion Anden 3","4_2_Anden 4_Descripcion Anden 4","5_2_Anden 5_Descripcion Anden 5","6_2_Anden 6_Descripcion Anden 6","7_3_Anden 7_Descripcion Anden 7","8_3_Anden 8_Descripcion Anden 8","9_3_Anden 9_Descripcion Anden 9","10_3_Anden 10_Descripcion Anden 10","11_3_Anden 11_Descripcion Anden 11","12_3_Anden 12_Descripcion Anden 12","13_3_Anden 13_Descripcion Anden 13","14_3_Anden 14_Descripcion Anden 14","15_3_Anden 15_Descripcion Anden 15","16_3_Anden 16_Descripcion Anden 16","17_3_Anden 17_Descripcion Anden 17","18_3_Anden 18_Descripcion Anden 18","19_3_Anden 19_Descripcion Anden 19","20_3_Anden 20_Descripcion Anden 20","21_4_Anden 21_Descripcion Anden 21","22_4_Anden 22_Descripcion Anden 22","23_4_Anden 23_Descripcion Anden 23","24_4_Anden 24_Descripcion Anden 24","25_4_Anden 25_Descripcion Anden 25","26_4_Anden 26_Descripcion Anden 26","27_4_Anden 27_Descripcion Anden 27","28_4_Anden 28_Descripcion Anden 28","29_4_Anden 29_Descripcion Anden 29","30_4_Anden 30_Descripcion Anden 30","31_4_Anden 31_Descripcion Anden 31","32_4_Anden 32_Descripcion Anden 32","33_4_Anden 33_Descripcion Anden 33","34_4_Anden 34_Descripcion Anden 34","35_4_Anden 35_Descripcion Anden 35","36_4_Anden 36_Descripcion Anden 36","37_4_Anden 37_Descripcion Anden 37","38_10_Anden 1_Descripcion Anden 1","39_10_Anden 2_Descripcion Anden 2","40_10_Anden 3_Descripcion Anden 3","41_10_Anden 4_Descripcion Anden 4","42_10_Anden 5_Descripcion Anden 5","43_10_Anden 6_Descripcion Anden 6","44_10_Anden 7_Descripcion Anden 7","45_10_Anden 8_Descripcion Anden 8","46_10_Anden 9_Descripcion Anden 9","47_10_Anden 10_Descripcion Anden 10"];
        for ($i=0; $i < count($arreglo); $i++) { 
            $array = explode("_",$arreglo[$i]);
            Ubicacione::create([
                'area_id' => $array[1],
                'nombreubi' => $array[2],
                'descripcionubi' => $array[3],
            ]);
        }
    }
}
