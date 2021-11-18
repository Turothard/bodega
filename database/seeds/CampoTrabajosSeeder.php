<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\CampoTrabajo;

class CampoTrabajosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arreglo= ["1_16_0","1_17_0","2_16_0","2_17_0","3_16_0","3_17_0","4_16_0","4_17_0","5_16_0","5_17_0","6_16_0","6_17_0","7_16_0","7_17_0","8_16_0","8_17_0","9_16_0","9_17_0","9_13_0","10_16_0","10_17_0","10_13_0","11_16_0","11_17_0","11_13_0","12_16_0","12_17_0","13_16_0","13_17_0","14_16_0","14_17_0","15_16_0","15_17_0","16_16_0","16_17_0","17_16_0","17_17_0","18_16_0","18_17_0","18_21_0","18_22_100","19_16_0","19_17_0","19_23_100","20_16_0","20_17_0","20_14_0","21_16_0","21_17_0","22_16_0","22_17_0","23_16_0","23_17_0","24_16_0","24_17_0","25_16_0","25_17_0","26_16_0","26_17_0","27_16_0","27_17_0","28_16_0","28_17_0","29_16_0","29_17_0","29_23_0","30_16_0","30_17_0","31_16_0","31_17_0","32_16_0","32_17_0","32_13_0","33_13_0","34_16_0","34_17_0","35_16_0","35_17_0","36_13_0"];
        for ($i=0; $i < count($arreglo); $i++) { 
            $array = explode("_",$arreglo[$i]);
            CampoTrabajo::create([
                'trabajo_id' => $array[0],
                'campo_id' => $array[1],
                'largo' => $array[2],
                'activo' => true,
            ]);
        }
    }
}
