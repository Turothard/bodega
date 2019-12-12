<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Categoria;
class CategoriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arreglo= ['Vestimenta_VE_Ropa exterior o indumentaria de una persona, para realizar algún tipo de trabajo','Herramientas_HE_Conjunto de instrumentos que se utilizan para desempeñar un oficio o un trabajo determinado','Insumos_IN_Bien de cualquier clase empleado en la producción de otros bienes o realización de trabajos'];
        for ($i=0; $i < count($arreglo); $i++) { 
            $array = explode("_",$arreglo[$i]);
            Categoria::create([
                'codigocat' => $array[1],
                'nombrecat' => $array[0],
                'descripcioncat' => $array[2],
            ]);
        }
    }
}
