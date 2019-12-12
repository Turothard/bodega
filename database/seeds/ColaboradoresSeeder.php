<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Colaboradore;
class ColaboradoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arreglo= ['JONATHAN ANDRÉS_CACERES LIQUITAY_17560348-4_ASISTENTE ADMINISTRATIVO_ADMINISTRACION_ADM','LUIS DANIEL_VILLAR  COLLADO_17475558-2_ASISTENTE APOYO CAPATAZ_TRABAJADORES_ZAO','VÍCTOR RAMÓN_LÓPEZ VALDEBENITO_0908696-0_ASISTENTE APOYO GRÚA HORQUILLA_TRABAJADORES_ZAO','JUAN MANUEL_QUIJANA  SAN MARTÍN_11832527-3_ASISTENTE APOYO GRÚA HORQUILLA_TRABAJADORES_ZAO','MARCOS ANTONIO_SALINAS URIONA _13021741-9_ASISTENTE APOYO GRÚA HORQUILLA_TRABAJADORES_ZAO','FABIO ALONSO_CASTRO FIGUEROA_16501994-6_ASISTENTE CONTROL PUERTA ACCESO DE CAMIONES_TRABAJADORES_RDA','EDUARDO ANDRÉ_GONZÁLEZ  CÉSPEDES_17143398-3_ASISTENTE CONTROL PUERTA ACCESO DE CAMIONES_TRABAJADORES_RDA','RICARDO EDUARDO_JARA HIDALGO_15073868-7_ASISTENTE CONTROL PUERTA ACCESO DE CAMIONES_TRABAJADORES_RDA','VICTOR ALFREDO_JARA HIDALGO_17807140-8_ASISTENTE CONTROL PUERTA ACCESO DE CAMIONES_TRABAJADORES_RDA','JAIME ANTONIO_MARTINEZ VARGAS _18187020-6_ASISTENTE CONTROL PUERTA ACCESO DE CAMIONES_TRABAJADORES_RDA','CESAR ANTONIO_SALAS GONZALEZ_17139827-4_ASISTENTE CONTROL PUERTA ACCESO DE CAMIONES_TRABAJADORES_RDA','KEVIN JESÚS_ORTIZ ROJAS_19330047-2_ASISTENTE DE MANIOBRAS EN TRÁNSITO_TRABAJADORES_ZAO','LUIS FELIPE_ROJAS  ALMONTE_18298242-3_ASISTENTE DE MANIOBRAS EN TRÁNSITO_TRABAJADORES_ZAO','PATRICIO ANDRÉS_VALENCIA JAIME_19011878-9_ASISTENTE DE MANIOBRAS EN TRÁNSITO_TRABAJADORES_ZAO','JOSÉ BERNARDINO_GÓMEZ ARAVENA_11332091-5_ASISTENTE INPECCIÓN Y AFORO_TRABAJADORES_ZAO','FERNANDO ANDRÉS_PASTENES VELASQUEZ_13879022-3_ASISTENTE INPECCIÓN Y AFORO_TRABAJADORES_RDA','DAVID ALONSO_ULZURRÚN ASTORGA_17355746-9_ASISTENTE INPECCIÓN Y AFORO_TRABAJADORES_RDA','MARCELO ANDRÉS_URRA  BASCUÑAN_13877908-4_ASISTENTE INPECCIÓN Y AFORO_TRABAJADORES_ZAO','FABIÁN HUMBERTO_VALENZUELA MIRANDA_09999610-2_ASISTENTE INPECCIÓN Y AFORO_TRABAJADORES_ZAO','SANDRO EDGARDO_ZÚÑIGA RODRIGUEZ_11654369-9_ASISTENTE INPECCIÓN Y AFORO_TRABAJADORES_ZAO','VICTOR MAURICIO_ESPINOZA PÉREZ_13734387-8_ASISTENTE OPERACIONES LOGISTICAS_TRABAJADORES_RDA','NICOLAS ANDRÉS_PIZARRO MELLA_19755028-6_ASISTENTE OPERACIONES LOGISTICAS_TRABAJADORES_RDA','RODRIGO DIMITRI_RIVAS CERDA_12846513-8_ASISTENTE OPERACIONES LOGISTICAS_TRABAJADORES_RDA','MANUEL ALEJANDRO_SARAVIA YAÑEZ_15930942-8_ASISTENTE OPERACIONES LOGISTICAS_TRABAJADORES_RDA','ERICK MICHAEL_VASQUEZ SUAREZ_17804308-0_ASISTENTE OPERACIONES LOGISTICAS_TRABAJADORES_RDA','MARCO ANTONIO_CORTEZ SEGURA_16967522-8_ASISTENTE OPERADOR HORQUILLA_TRABAJADORES_RDA','LUIS  RAUL_PIZARRO HUERTA_12116462-0_ASISTENTE OPERADOR HORQUILLA_TRABAJADORES_RDA','DANILO ANDRES_YAÑEZ RAKELA_15356378-0_ASISTENTE OPERADOR HORQUILLA_TRABAJADORES_RDA','GABRIEL EDUARDO_ARREDONDO MOLINA_15078647-9_CAPATAZ_CAPATAZ_ZAO','JAIME ANDRÉS_RAMIREZ CERÓN_16106109-3_CAPATAZ_CAPATAZ_RDA','ALAN LEROY_ROJAS CACERES_19011857-6_CAPATAZ_CAPATAZ_RDA','MIGUEL JORGE_GONZÁLEZ DÍAZ_08030157-K_COORDINADOR LOTES USDA_TRABAJADORES_ZAO','MAURICIO FERNANDO_RIVERA CERDA_10943719-0_JEFE ADMINISTRATIVO_ADMINISTRACION_ADM','GONZALO ANDRES_AGUIRRE SEGOVIA_17807133-5_MOVILIZADOR DE CARGA_TRABAJADORES_ZAO','MARIO ANTONIO_ANDRADES JIMENEZ_19773858-8_MOVILIZADOR DE CARGA_TRABAJADORES_RDA','RODRIGO ANDRÉS_ARANCIBIA SILVA_15750438-K_MOVILIZADOR DE CARGA_TRABAJADORES_ZAO','RODRIGO MATÍAS_BERRIOS DIAZ_19403427-K_MOVILIZADOR DE CARGA_TRABAJADORES_RDA','VICTOR HUGO_CAMPOS MUÑOZ_15022722-4_MOVILIZADOR DE CARGA_TRABAJADORES_RDA','CARLOS ANDRÉS_CASTRO MUÑOZ_15751069-K_MOVILIZADOR DE CARGA_TRABAJADORES_RDA','MAXIMILIANO DEL JESUS_CASTRO MUÑOZ_18298013-7_MOVILIZADOR DE CARGA_TRABAJADORES_RDA','ABRAHAM ESTEBAN_CUADRA FERNANDEZ_17807501-2_MOVILIZADOR DE CARGA_TRABAJADORES_ZAO','FRANCISCO JAVIER_DELMAS RETAMALES_18032114-4_MOVILIZADOR DE CARGA_TRABAJADORES_RDA','BASTÍAN ANDRÉS_ECHEVERRÍA AHUMADA_19011635-2_MOVILIZADOR DE CARGA_TRABAJADORES_RDA','CRISTOBAL ANDRÉS_GRANADA TOLEDO_17143931-9_MOVILIZADOR DE CARGA_TRABAJADORES_ZAO','ANDY POOL_GREZ ASTORGA_17807245-5_MOVILIZADOR DE CARGA_TRABAJADORES_RDA','ALEX DAMIÁN_GUTIÉRREZ ITURRIAGA_20654993-6_MOVILIZADOR DE CARGA_TRABAJADORES_RDA','CRISTIAN GERALDO_HERNÁNDEZ JARA_18568083-5_MOVILIZADOR DE CARGA_TRABAJADORES_RDA','JUAN PEDRO_IBACETA CAYA_11814845-2_MOVILIZADOR DE CARGA_TRABAJADORES_RDA','CRISTOFER ALEXANDER_IBACETA ROMERO_18270961-1_MOVILIZADOR DE CARGA_TRABAJADORES_RDA','JORGE NICOLAS_JIMÉNEZ  BARRERA_18113552-2_MOVILIZADOR DE CARGA_TRABAJADORES_RDA','ALEJANDRO FELIPE_JORQUERA PAREDES_17476241-4_MOVILIZADOR DE CARGA_TRABAJADORES_RDA','OLIVER FABIAN_LEIVA AHUMADA_18962115-9_MOVILIZADOR DE CARGA_TRABAJADORES_RDA','JAVIER IGNACIO_NUÑEZ SANDOVAL_19339861-8_MOVILIZADOR DE CARGA_TRABAJADORES_ZAO','RODRIGO ANDRÉS_PAREDES MEDINA_12624406-1_MOVILIZADOR DE CARGA_TRABAJADORES_RDA','JAN PIERRE_POZO CARLINI_18032239-6_MOVILIZADOR DE CARGA_TRABAJADORES_RDA','BONO CID_ROJAS HERNAEZ_18916806-3_MOVILIZADOR DE CARGA_TRABAJADORES_RDA','JOSÉ  ANTONIO_SAUVIGNONE ESCOBAR_17472632-9_MOVILIZADOR DE CARGA_TRABAJADORES_ZAO','MATÍAS ANDRÉ_SEPÚLVEDA VENEGAS_18998284-4_MOVILIZADOR DE CARGA_TRABAJADORES_RDA','RICARDO ANTONIO_TARIFEÑO IBARRA_19775662-6_MOVILIZADOR DE CARGA_TRABAJADORES_ZAO','DANIEL ALEJANDRO_TOLEDO GUTIERREZ_20478349-7_MOVILIZADOR DE CARGA_TRABAJADORES_ZAO','FERNANDO RAFAEL_ANDAUR LILLO_13877058-3_PAÑOLERO_BODEGA_ADM','JOSE ADOLFO_CONAPIAO BOASSI_16106197-2_PAÑOLERO_BODEGA_ADM','KEVIN ALFONSO_FARÍAS RIVEROS_18272185-9_PREVENSIÓN DE RIESGOS_ADMINISTRACION_ADM','CARLOS FERNANDO PAULO_GRANADA GONZÁLEZ_09930341-7_SUPERVISOR_SUPERVISION_ZAO','CARLOS ALEJANDRO_QUINTANA SANDOVAL_15101323-6_SUPERVISOR_SUPERVISION_RDA','MARCOS_ABALLAY_17273201-1_DESARROLLADOR_ADMINISTRACION_ADM'];
        for ($i=0; $i < count($arreglo); $i++) {
            $array = explode("_",$arreglo[$i]);
            Colaboradore::create([
                'rutcolaborador' => $array[2],
                'nombrescolab' => $array[0],
                'apellidoscolab' => $array[1],
                'deptocolab' => $array[4],
                'sectorcolab' => $array[5],
                'cargocolab' => $array[3],
                'fechaingresocolab' => date('Y-m-d H:i:s'),
                'estadocolab' => true
            ]);
        }
    }
}
