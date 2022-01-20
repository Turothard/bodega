<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\ObservacionTabulada;
class ObservacionTabuladaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arreglo= ['Carga mal estibada_Carga mal estibada','Carga dañada de origen_Carga dañada de origen','Retención de mercancia_Retención de mercancia','Sin observación_Sin observación'];
        for ($i=0; $i < count($arreglo); $i++) { 
            $array = explode("_",$arreglo[$i]);
            ObservacionTabulada::create([
                'nombre' => $array[0],
                'descripcion' => $array[1],
                'activo' => true
            ]);
        }
    }
}
