<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Unidade;
class UnidadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arreglo= ['Sin Unidad_0_00_00_Sin talla_00','Talla_T_S_0S_SMALL_0S','Talla_T_M_0M_MEDIUM_0M','Talla_T_L_0L_LARGE_0L','Talla_T_XS_XS_EXTRA SMALL_XS','Talla_T_XL_XL_EXTRA LARGE_XL','Talla_T_XXL_XX_EXTRA EXTRA LARGE_XX','Número_N_35_35_CALZADO 35_35','Número_N_36_36_CALZADO 36_36','Número_N_37_37_CALZADO 37_37','Número_N_38_38_CALZADO 38_38','Número_N_39_39_CALZADO 39_39','Número_N_40_40_CALZADO 40_40','Número_N_41_41_CALZADO 41_41','Número_N_42_42_CALZADO 42_42','Número_N_43_43_CALZADO 43_43','Número_N_44_44_CALZADO 44_44','Número_N_45_45_CALZADO 45_45','Número_N_46_46_CALZADO 46_46'];
        for ($i=0; $i < count($arreglo); $i++) { 
            $array = explode("_",$arreglo[$i]);
            Unidade::create([
                'idunidad' => $array[5],
                'tipounimed' => $array[1],
                'nombretipounimed' => $array[0],
                'codigounimed' => $array[2],
                'unidadmed' => $array[3],
                'descripcionunimed' => $array[4],
            ]);
        }
    }
}
