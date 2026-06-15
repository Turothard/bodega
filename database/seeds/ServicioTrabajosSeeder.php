<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\ServicioTrabajo;

class ServicioTrabajosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arreglo= ["1_1_1_false","1_2_1_false","1_3_1_false","1_4_1_false","1_5_1_false","1_6_1_false","1_7_1_false","1_8_1_false","1_9_1_false","1_10_1_false","1_11_1_false","1_12_1_false","1_13_1_false","1_14_1_false","1_15_1_false","1_16_1_false","1_17_1_false","1_18_1_false","1_19_1_false","1_20_1_false","1_21_1_false","1_22_1_false","1_23_1_false","1_24_1_false","1_25_1_false","1_26_1_false","1_27_1_false","1_28_1_false","1_29_1_false","1_30_1_false","1_31_1_false","1_32_1_false","1_33_1_false","1_34_1_false","1_35_1_false","1_36_1_false","2_1_1_false","2_2_1_false","2_3_1_false","2_4_1_false","2_5_1_false","2_6_1_false","2_7_1_false","2_8_1_false","2_9_1_false","2_10_1_false","2_11_1_false","2_12_1_false","2_13_1_false","2_14_1_false","2_15_1_false","2_16_1_false","2_17_1_false","2_18_1_false","2_19_1_false","2_20_1_false","2_21_1_false","2_22_1_false","2_23_1_false","2_24_1_false","2_25_1_false","2_26_1_false","2_27_1_false","2_28_1_false","2_29_1_false","2_30_1_false","2_31_1_false","2_32_1_false","2_33_1_false","2_34_1_false","2_35_1_false","2_36_1_false","3_1_1_FALSE","4_2_1_FALSE","5_3_1_FALSE","6_4_1_FALSE","7_5_1_FALSE","8_6_1_FALSE","9_7_1_FALSE","9_9_1_FALSE","9_10_1_FALSE","10_8_1_FALSE","11_9_1_FALSE","11_10_1_FALSE","11_11_1_FALSE","12_12_1_FALSE","13_13_1_FALSE","14_14_1_FALSE","14_23_1_FALSE","14_24_1_FALSE","14_30_1_FALSE","14_31_1_FALSE","14_34_1_FALSE","14_36_1_FALSE","15_15_1_FALSE","15_23_1_FALSE","15_24_1_FALSE","15_30_1_FALSE","15_31_1_FALSE","15_34_1_FALSE","15_36_1_FALSE","16_16_1_FALSE","16_23_1_FALSE","16_24_1_FALSE","16_30_1_FALSE","16_31_1_FALSE","16_34_1_FALSE","16_36_1_FALSE","17_17_1_FALSE","17_23_1_FALSE","17_24_1_FALSE","17_30_1_FALSE","17_31_1_FALSE","17_34_1_FALSE","17_36_1_FALSE","18_18_1_FALSE","18_30_1_FALSE","19_19_1_FALSE","19_23_1_FALSE","19_30_1_FALSE","19_31_1_FALSE","20_20_1_FALSE","21_21_1_FALSE","21_22_1_FALSE","22_22_1_FALSE","23_25_1_FALSE","23_23_1_FALSE","23_24_1_FALSE","23_30_1_FALSE","23_31_1_FALSE","23_34_1_FALSE","23_36_1_FALSE","24_26_1_FALSE","24_23_1_FALSE","24_24_1_FALSE","24_30_1_FALSE","24_31_1_FALSE","24_34_1_FALSE","24_36_1_FALSE","25_27_1_FALSE","25_23_1_FALSE","25_24_1_FALSE","25_30_1_FALSE","25_31_1_FALSE","25_34_1_FALSE","25_36_1_FALSE","26_28_1_FALSE","26_23_1_FALSE","26_24_1_FALSE","26_30_1_FALSE","26_31_1_FALSE","26_34_1_FALSE","26_36_1_FALSE","27_29_1_FALSE","27_23_1_FALSE","27_30_1_FALSE","27_31_1_FALSE","28_32_1_FALSE","28_14_1_FALSE","28_15_1_FALSE","28_16_1_FALSE","28_17_1_FALSE","28_25_1_FALSE","28_26_1_FALSE","28_27_1_FALSE","28_28_1_FALSE","28_21_1_FALSE","28_22_1_FALSE","29_33_1_FALSE","30_35_1_FALSE"];
        for ($i=0; $i < count($arreglo); $i++) { 
            $array = explode("_",$arreglo[$i]);
            ServicioTrabajo::create([
                'servicio_id' => $array[0],
                'trabajo_id' => $array[1],
                'tipofacturacion_id' => $array[2],
                'multiplicador' => $array[3],
                'caducidad' => '2100-12-31',
                'activo' => true,
            ]);
        }
    }
}
