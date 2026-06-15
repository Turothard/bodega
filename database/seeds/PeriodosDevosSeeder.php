<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\PeriodoDevo;
class PeriodosDevosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arreglo= ['0_Sin Periodo','4_4 Horas','6_6 Horas','8_8 Horas','12_12 Horas','24_1 Día','48_2 Días','72_3 Días','96_4 Días','120_5 Días','144_6 Días','168_7 Días'];
        for ($i=0; $i < count($arreglo); $i++) { 
            $array = explode("_",$arreglo[$i]);
            PeriodoDevo::create([
                'periododevo' => $array[0],
                'descripcionper' => $array[1],
            ]);
        }
    }
}
