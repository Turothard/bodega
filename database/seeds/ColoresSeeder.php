<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Colore;

class ColoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arreglo= ['00_Sin Color_#','01_Blanco_#FFFFFF','02_Negro_#000000','03_Rojo_#FF0000','04_Azul_#0000FF','05_Verde_#00FF00','06_Amarillo_#FFFF00','07_Magenta_#FF00FF','08_Cian_#00FFFF','09_Café_#3F2212','10_Naranjo_#FF7F00','11_Rojo Minero_#DF3A01','12_plateado_#C0C0C0','13_Rosa_#F7819F'];
        for ($i=0; $i < count($arreglo); $i++) { 
            $array = explode("_",$arreglo[$i]);
            Colore::create([
                'idcolor' => $array[0],
                'nombrecol' => $array[1],
                'hexcol' => $array[2],
            ]);
        }
    }
}
