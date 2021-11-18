<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\CampoServicio;

class CampoServiciosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arreglo= ["1|foliointerno|true","1|folioexterno|true","1|agencia_id|true","1|digitoidentificador|true","1|contenido_id|true","2|foliointerno|true","2|folioexterno|true","2|agencia_id|true","2|digitoidentificador|true","2|contenido_id|true","3|foliointerno|true","3|folioexterno|true","3|agencia_id|true","3|digitoidentificador|true","3|contenido_id|true","4|foliointerno|true","4|foliointerno|true","4|folioexterno|true","4|agencia_id|true","4|digitoidentificador|true","5|contenido_id|true","5|foliointerno|true","5|folioexterno|true","5|agencia_id|true","5|digitoidentificador|true","6|contenido_id|true","6|foliointerno|true","6|foliointerno|true","6|folioexterno|true","6|agencia_id|true","7|digitoidentificador|true","7|contenido_id|true","7|foliointerno|true","7|folioexterno|true","7|agencia_id|true","8|digitoidentificador|true","8|contenido_id|true","8|foliointerno|true","8|foliointerno|true","8|folioexterno|true","9|agencia_id|true","9|digitoidentificador|true","9|contenido_id|true","9|foliointerno|true","9|folioexterno|true","10|agencia_id|true","10|digitoidentificador|true","10|contenido_id|true","10|foliointerno|true","10|foliointerno|true","11|folioexterno|true","11|agencia_id|true","11|digitoidentificador|true","11|contenido_id|true","11|foliointerno|true","12|folioexterno|true","12|agencia_id|true","12|digitoidentificador|true","12|contenido_id|true","12|foliointerno|true","13|foliointerno|true","13|folioexterno|true","13|agencia_id|true","13|digitoidentificador|true","13|contenido_id|true","14|foliointerno|true","14|folioexterno|true","14|agencia_id|true","14|digitoidentificador|true","14|contenido_id|true","15|foliointerno|true","15|foliointerno|true","15|folioexterno|true","15|agencia_id|true","15|digitoidentificador|true","16|contenido_id|true","16|foliointerno|true","16|folioexterno|true","16|agencia_id|true","16|digitoidentificador|true","17|contenido_id|true","17|foliointerno|true","17|foliointerno|true","17|folioexterno|true","17|agencia_id|true","18|digitoidentificador|true","18|contenido_id|true","18|foliointerno|true","18|folioexterno|true","18|agencia_id|true","19|digitoidentificador|true","19|contenido_id|true","19|foliointerno|true","19|foliointerno|true","19|folioexterno|true","20|agencia_id|true","20|digitoidentificador|true","20|contenido_id|true","20|foliointerno|true","20|folioexterno|true","21|agencia_id|true","21|digitoidentificador|true","21|contenido_id|true","21|foliointerno|true","21|foliointerno|true","22|folioexterno|true","22|agencia_id|true","22|digitoidentificador|true","22|contenido_id|true","22|foliointerno|true","23|folioexterno|true","23|agencia_id|true","23|digitoidentificador|true","23|contenido_id|true","23|foliointerno|true","24|foliointerno|true","24|folioexterno|true","24|agencia_id|true","24|digitoidentificador|true","24|contenido_id|true","25|foliointerno|true","25|folioexterno|true","25|agencia_id|true","25|digitoidentificador|true","25|contenido_id|true","26|foliointerno|true","26|foliointerno|true","26|folioexterno|true","26|agencia_id|true","26|digitoidentificador|true","27|contenido_id|true","27|foliointerno|true","27|folioexterno|true","27|agencia_id|true","27|digitoidentificador|true","28|contenido_id|true","28|foliointerno|true","28|foliointerno|true","28|folioexterno|true","28|agencia_id|true","29|digitoidentificador|true","29|contenido_id|true","29|foliointerno|true","29|folioexterno|true","29|agencia_id|true","30|digitoidentificador|true","30|contenido_id|true","30|foliointerno|true","30|foliointerno|true","30|folioexterno|true"];
        for ($i=0; $i < count($arreglo); $i++) { 
            $array = explode("|",$arreglo[$i]);
            CampoServicio::create([
                'servicio_id' => $array[0],
                'campo' => $array[1],
                'activo' => $array[2],
            ]);
        }
    }
}
