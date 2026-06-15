<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Trabajo;

class TrabajosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arreglo= ["TRBP40RDA_0.1_Parcial 40_1","TRBT40_0.2_Total 40_1","TRBP20_0.3_Parcial 20_1","TRBT20_0.4_Total 20_1","TRBCON_0.5_Consolidado_1","TRBDES_0.6_Desconsolidado_1","TRBCHA_0.7_Forwarding_1","TRBSIT_0.8_Separación de Item_1","TRBSPE_0.9_Persona(HORQUILLERO)_1","TRBSPE02_0.10_Persona(TARJA)_1","TRBSPE03_0.11_Persona(MOVILIZADOR)_1","TRBSES_0.12_Especial_1","TRBLIM_0.13_Limpieza_1","TRBP20ZAO_1.1_Parcial 20_2","TRBT20ZAO_1.2_Total 20_2","TRBP40ZAO_1.3_Parcial 40_2","TRBT40ZAO_1.4_Total 40_2","TRBUSDAZAO_1.5_Muestra USDA_2","TRBCFZAO_1.6_Carga Fraccionada_2","TRBPXHZ0_3.14_Personal por Hora_2","TRBESPZ0_3.15_Especial Zona 0_2","TRBESP2Z0_3.16_Especial Prolongado Zona 0_2","TRPRPTZ0_3.36_Retiro Pallet_2","TRPLIMZ0_3.37_Limpieza Carga y Contenedor_2","TRBP20IMO_3.39_Parcial 20 IMO_2","TRBT20IMO_3.40_Total 20 IMO_2","TRBP40IMO_3.41_Parcial 40 IMO_2","TRBT40IMO_3.42_Total 40 IMO_2","TRBCFIMO_3.43_Carga Fraccionada IMO_2","TRBREMZ0_5.1_Reparación de Embalaje_2","TRBREZZ0_5.4_Reenzunchado_2","TRBCSZ0_5.5_Corte Sello_2","TRBRCZ0_5.8_Reposición de Caja_2","TRBPCSZ0_5.10_Pesaje Carga Suelta_2","TRBDRGZ0_5.11_Servicio de Apo. a la Ins. de Mercancías Esp._2","TRBRFRZ0_5.35_Reposición Fruta_2"];
        for ($i=0; $i < count($arreglo); $i++) { 
            $array = explode("_",$arreglo[$i]);
            Trabajo::create([
                'codigo' => $array[0],
                'codigoalt' => $array[1],
                'nombre' => $array[2],
                'sector_id' => $array[3],
                'user_id' => 12,
                'activo' => true,
            ]);
        }
    }
}
