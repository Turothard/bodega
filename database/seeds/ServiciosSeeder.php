<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Servicio;
class ServiciosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arreglo= ["DUMMY_DUMMY_1","DUMMY2_DUMMY2_2","SERVP40RDA_Servicio Parcial 40_1","SERVT40RDA_Servicio Total 40_1","SERVP20RDA_Servicio Parcial 20_1","SERVT20RDA_Servicio Total 20_1","SERVCONRDA_Servicio Consolidado_1","SERVDESRDA_Servicio Desconsolidado_1","SERVCHARDA_Servicio Forwarding_1","SERVSITRDA_Servicio Separación de Item_1","SERVSPERDA_Servicio Persona_1","SERVSESRDA_Servicio Especial_1","SERVLIMRDA_Servicio Maestranza_2","SERVP20ZAO_Servicio Parcial 20_2","SERVT20ZAO_Servicio Total 20_2","SERVP40ZAO_Servicio Parcial 40_2","SERVT40ZAO_Servicio Total 40_2","SERVLOTZAO_Servicio Muestra USDA_2","SERVCFZAO_Servicio Carga Fraccionada_2","SERVPHZAO_Servicio Personal por Hora_2","SERVESPZAO_Servicio Especial Zona 0_2","SERVESPPZAO_Servicio Especial Prolongado Zona 0_2","SERVP20IZAO_Servicio Parcial 20 IMO_2","SERVT20IZAO_Servicio Total 20 IMO_2","SERVP40Z0_Servicio Parcial 40 IMO_2","SERVT40Z0_Servicio Total 40 IMO_2","SERVCFZ0_Servicio Carga Fraccionada IMO_2","SERVCSZ0_Servicio Corte Sello_2","SERVRCZ0_Servicio Reposición de Caja_2","SERVADUZ0_Servicio de Droga_2"];
        for ($i=0; $i < count($arreglo); $i++) { 
            $array = explode("_",$arreglo[$i]);
            Servicio::create([
                'codigo' => $array[0],
                'nombre' => $array[1],
                'sector_id' => $array[2],
                'user_id' => 12,
                'activo' => true,
            ]);
        }
    }
}
