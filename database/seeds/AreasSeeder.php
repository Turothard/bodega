<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Area;
class AreasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arreglo= ["2_ZONA CERO_Aforo de mercancía IMO y/o Servicios especiales","2_USDA_Inspección de frutas de exportación e inportación","2_SAG_Aforo físico, Desconsolidado y Consolidado + Control de Gases","2_ADUANA_Inspección , Aforo físico, Desconsolidado y Conosolidado de mercancía.","2_TRÁNSITO_Dirigir el flujo de los camiones en patio ZAO","1_GATE ENTRADA_Control del flujo de vehículos que se dirigen al Sector de RDA.","1_GATE SALIDA_Control de todo flujo de vehículos que valla de salida del RDA.","1_BODEGA IMO_Almacenamiento y Manipulación de Carga Peligrosa","1_GATE CONTROL_Recepción y despacho de la carga contenedorizada. Asignación y distribución de la misma.","1_CROSS DOCK_Inspección , Aforo físico, Desconsolidado y Conosolidado de mercancía.","1_TOLDO ALMACEN_Inspección , Aforo físico, Desconsolidado, Conosolidado y Retención de mercancía.","1_LOZA ALMACEN_Inspección , Aforo físico, Desconsolidado, Conosolidado, Retención y Separación de mercancía.", "3_Administración_Oficina administrativo Zeal Servicios"];
        for ($i=0; $i < count($arreglo); $i++) { 
            $array = explode("_",$arreglo[$i]);
            Area::create([
                'sector_id' => $array[0],
                'nombrearea' => $array[1],
                'descripcionarea' => $array[2],
            ]);
        }
    }
}
