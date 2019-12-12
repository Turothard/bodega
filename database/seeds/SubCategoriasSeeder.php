<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Categoria;
use App\SubCategoria;
class SubCategoriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arreglo= ["ELEMENTO PROTECCION PERSONAL_EPP_Vestimenta","UNIFORME_UNI_Vestimenta","HERRAMIENTA ELECTRICA_ELE_Herramientas","HERRAMIENTA ANALOGA_ANA_Herramientas","UTILES DE ASEO_ASE_Insumos","OFIMATICA_OFI_Insumos","INSUMOS DE TRABAJO_TRA_Insumos"];
        for ($i=0; $i < count($arreglo); $i++) { 
            $array = explode("_",$arreglo[$i]);
            SubCategoria::create([
                'categoria_id' => Categoria::where("nombrecat", $array[2])->first('idcategoria')->idcategoria,
                'codigosubcat' => $array[1],
                'nombresubcat' => $array[0],
            ]);
        }
    }
}
