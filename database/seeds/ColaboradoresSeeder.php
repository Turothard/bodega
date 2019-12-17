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
        $arreglo= ["JONATHAN ANDRÉS_CACERES LIQUITAY_17560348-4_ASISTENTE ADMINISTRATIVO_ADMINISTRACION_ADM_JONATHAN CACERES","LUIS DANIEL_VILLAR  COLLADO_17475558-2_ASISTENTE APOYO CAPATAZ_TRABAJADORES_ZAO_LUIS VILLAR","VÍCTOR RAMÓN_LÓPEZ VALDEBENITO_0908696-0_ASISTENTE APOYO GRÚA HORQUILLA_TRABAJADORES_ZAO_VÍCTOR LÓPEZ","JUAN MANUEL_QUIJANA  SAN MARTÍN_11832527-3_ASISTENTE APOYO GRÚA HORQUILLA_TRABAJADORES_ZAO_JUAN QUIJANA","MARCOS ANTONIO_SALINAS URIONA _13021741-9_ASISTENTE APOYO GRÚA HORQUILLA_TRABAJADORES_ZAO_MARCOS SALINAS","FABIO ALONSO_CASTRO FIGUEROA_16501994-6_ASISTENTE CONTROL PUERTA ACCESO DE CAMIONES_TRABAJADORES_RDA_FABIO CASTRO","EDUARDO ANDRÉ_GONZÁLEZ  CÉSPEDES_17143398-3_ASISTENTE CONTROL PUERTA ACCESO DE CAMIONES_TRABAJADORES_RDA_EDUARDO GONZÁLEZ","RICARDO EDUARDO_JARA HIDALGO_15073868-7_ASISTENTE CONTROL PUERTA ACCESO DE CAMIONES_TRABAJADORES_RDA_RICARDO JARA","VICTOR ALFREDO_JARA HIDALGO_17807140-8_ASISTENTE CONTROL PUERTA ACCESO DE CAMIONES_TRABAJADORES_RDA_VICTOR JARA","JAIME ANTONIO_MARTINEZ VARGAS _18187020-6_ASISTENTE CONTROL PUERTA ACCESO DE CAMIONES_TRABAJADORES_RDA_JAIME MARTINEZ","CESAR ANTONIO_SALAS GONZALEZ_17139827-4_ASISTENTE CONTROL PUERTA ACCESO DE CAMIONES_TRABAJADORES_RDA_CESAR SALAS","KEVIN JESÚS_ORTIZ ROJAS_19330047-2_ASISTENTE DE MANIOBRAS EN TRÁNSITO_TRABAJADORES_ZAO_KEVIN ORTIZ","LUIS FELIPE_ROJAS  ALMONTE_18298242-3_ASISTENTE DE MANIOBRAS EN TRÁNSITO_TRABAJADORES_ZAO_LUIS ROJAS","PATRICIO ANDRÉS_VALENCIA JAIME_19011878-9_ASISTENTE DE MANIOBRAS EN TRÁNSITO_TRABAJADORES_ZAO_PATRICIO VALENCIA","JOSÉ BERNARDINO_GÓMEZ ARAVENA_11332091-5_ASISTENTE INPECCIÓN Y AFORO_TRABAJADORES_ZAO_JOSÉ GÓMEZ","FERNANDO ANDRÉS_PASTENES VELASQUEZ_13879022-3_ASISTENTE INPECCIÓN Y AFORO_TRABAJADORES_RDA_FERNANDO PASTENES","DAVID ALONSO_ULZURRÚN ASTORGA_17355746-9_ASISTENTE INPECCIÓN Y AFORO_TRABAJADORES_RDA_DAVID ULZURRÚN","MARCELO ANDRÉS_URRA  BASCUÑAN_13877908-4_ASISTENTE INPECCIÓN Y AFORO_TRABAJADORES_ZAO_MARCELO URRA","FABIÁN HUMBERTO_VALENZUELA MIRANDA_09999610-2_ASISTENTE INPECCIÓN Y AFORO_TRABAJADORES_ZAO_FABIÁN VALENZUELA","SANDRO EDGARDO_ZÚÑIGA RODRIGUEZ_11654369-9_ASISTENTE INPECCIÓN Y AFORO_TRABAJADORES_ZAO_SANDRO ZÚÑIGA","VICTOR MAURICIO_ESPINOZA PÉREZ_13734387-8_ASISTENTE OPERACIONES LOGISTICAS_TRABAJADORES_RDA_VICTOR ESPINOZA","NICOLAS ANDRÉS_PIZARRO MELLA_19755028-6_ASISTENTE OPERACIONES LOGISTICAS_TRABAJADORES_RDA_NICOLAS PIZARRO","RODRIGO DIMITRI_RIVAS CERDA_12846513-8_ASISTENTE OPERACIONES LOGISTICAS_TRABAJADORES_RDA_RODRIGO RIVAS","MANUEL ALEJANDRO_SARAVIA YAÑEZ_15930942-8_ASISTENTE OPERACIONES LOGISTICAS_TRABAJADORES_RDA_MANUEL SARAVIA","ERICK MICHAEL_VASQUEZ SUAREZ_17804308-0_ASISTENTE OPERACIONES LOGISTICAS_TRABAJADORES_RDA_ERICK VASQUEZ","MARCO ANTONIO_CORTEZ SEGURA_16967522-8_ASISTENTE OPERADOR HORQUILLA_TRABAJADORES_RDA_MARCO CORTEZ","LUIS  RAUL_PIZARRO HUERTA_12116462-0_ASISTENTE OPERADOR HORQUILLA_TRABAJADORES_RDA_LUIS PIZARRO","DANILO ANDRES_YAÑEZ RAKELA_15356378-0_ASISTENTE OPERADOR HORQUILLA_TRABAJADORES_RDA_DANILO YAÑEZ","GABRIEL EDUARDO_ARREDONDO MOLINA_15078647-9_CAPATAZ_CAPATAZ_ZAO_GABRIEL ARREDONDO","JAIME ANDRÉS_RAMIREZ CERÓN_16106109-3_CAPATAZ_CAPATAZ_RDA_JAIME RAMIREZ","ALAN LEROY_ROJAS CACERES_19011857-6_CAPATAZ_CAPATAZ_RDA_ALAN ROJAS","MIGUEL JORGE_GONZÁLEZ DÍAZ_08030157-K_COORDINADOR LOTES USDA_TRABAJADORES_ZAO_MIGUEL GONZÁLEZ","MAURICIO FERNANDO_RIVERA CERDA_10943719-0_JEFE ADMINISTRATIVO_ADMINISTRACION_ADM_MAURICIO RIVERA","GONZALO ANDRES_AGUIRRE SEGOVIA_17807133-5_MOVILIZADOR DE CARGA_TRABAJADORES_ZAO_GONZALO AGUIRRE","MARIO ANTONIO_ANDRADES JIMENEZ_19773858-8_MOVILIZADOR DE CARGA_TRABAJADORES_RDA_MARIO ANDRADES","RODRIGO ANDRÉS_ARANCIBIA SILVA_15750438-K_MOVILIZADOR DE CARGA_TRABAJADORES_ZAO_RODRIGO ARANCIBIA","RODRIGO MATÍAS_BERRIOS DIAZ_19403427-K_MOVILIZADOR DE CARGA_TRABAJADORES_RDA_RODRIGO BERRIOS","VICTOR HUGO_CAMPOS MUÑOZ_15022722-4_MOVILIZADOR DE CARGA_TRABAJADORES_RDA_VICTOR CAMPOS","CARLOS ANDRÉS_CASTRO MUÑOZ_15751069-K_MOVILIZADOR DE CARGA_TRABAJADORES_RDA_CARLOS CASTRO","MAXIMILIANO DEL JESUS_CASTRO MUÑOZ_18298013-7_MOVILIZADOR DE CARGA_TRABAJADORES_RDA_MAXIMILIANO CASTRO","ABRAHAM ESTEBAN_CUADRA FERNANDEZ_17807501-2_MOVILIZADOR DE CARGA_TRABAJADORES_ZAO_ABRAHAM CUADRA","FRANCISCO JAVIER_DELMAS RETAMALES_18032114-4_MOVILIZADOR DE CARGA_TRABAJADORES_RDA_FRANCISCO DELMAS","BASTÍAN ANDRÉS_ECHEVERRÍA AHUMADA_19011635-2_MOVILIZADOR DE CARGA_TRABAJADORES_RDA_BASTÍAN ECHEVERRÍA","CRISTOBAL ANDRÉS_GRANADA TOLEDO_17143931-9_MOVILIZADOR DE CARGA_TRABAJADORES_ZAO_CRISTOBAL GRANADA","ANDY POOL_GREZ ASTORGA_17807245-5_MOVILIZADOR DE CARGA_TRABAJADORES_RDA_ANDY GREZ","ALEX DAMIÁN_GUTIÉRREZ ITURRIAGA_20654993-6_MOVILIZADOR DE CARGA_TRABAJADORES_RDA_ALEX GUTIÉRREZ","CRISTIAN GERALDO_HERNÁNDEZ JARA_18568083-5_MOVILIZADOR DE CARGA_TRABAJADORES_RDA_CRISTIAN HERNÁNDEZ","JUAN PEDRO_IBACETA CAYA_11814845-2_MOVILIZADOR DE CARGA_TRABAJADORES_RDA_JUAN IBACETA","CRISTOFER ALEXANDER_IBACETA ROMERO_18270961-1_MOVILIZADOR DE CARGA_TRABAJADORES_RDA_CRISTOFER IBACETA","JORGE NICOLAS_JIMÉNEZ  BARRERA_18113552-2_MOVILIZADOR DE CARGA_TRABAJADORES_RDA_JORGE JIMÉNEZ","ALEJANDRO FELIPE_JORQUERA PAREDES_17476241-4_MOVILIZADOR DE CARGA_TRABAJADORES_RDA_ALEJANDRO JORQUERA","OLIVER FABIAN_LEIVA AHUMADA_18962115-9_MOVILIZADOR DE CARGA_TRABAJADORES_RDA_OLIVER LEIVA","JAVIER IGNACIO_NUÑEZ SANDOVAL_19339861-8_MOVILIZADOR DE CARGA_TRABAJADORES_ZAO_JAVIER NUÑEZ","RODRIGO ANDRÉS_PAREDES MEDINA_12624406-1_MOVILIZADOR DE CARGA_TRABAJADORES_RDA_RODRIGO PAREDES","JAN PIERRE_POZO CARLINI_18032239-6_MOVILIZADOR DE CARGA_TRABAJADORES_RDA_JAN POZO","BONO CID_ROJAS HERNAEZ_18916806-3_MOVILIZADOR DE CARGA_TRABAJADORES_RDA_BONO ROJAS","JOSÉ  ANTONIO_SAUVIGNONE ESCOBAR_17472632-9_MOVILIZADOR DE CARGA_TRABAJADORES_ZAO_JOSÉ SAUVIGNONE","MATÍAS ANDRÉ_SEPÚLVEDA VENEGAS_18998284-4_MOVILIZADOR DE CARGA_TRABAJADORES_RDA_MATÍAS SEPÚLVEDA","RICARDO ANTONIO_TARIFEÑO IBARRA_19775662-6_MOVILIZADOR DE CARGA_TRABAJADORES_ZAO_RICARDO TARIFEÑO","DANIEL ALEJANDRO_TOLEDO GUTIERREZ_20478349-7_MOVILIZADOR DE CARGA_TRABAJADORES_ZAO_DANIEL TOLEDO","FERNANDO RAFAEL_ANDAUR LILLO_13877058-3_PAÑOLERO_BODEGA_ADM_FERNANDO ANDAUR","JOSE ADOLFO_CONAPIAO BOASSI_16106197-2_PAÑOLERO_BODEGA_ADM_JOSE CONAPIAO","KEVIN ALFONSO_FARÍAS RIVEROS_18272185-9_PREVENSIÓN DE RIESGOS_ADMINISTRACION_ADM_KEVIN FARÍAS","CARLOS FERNANDO PAULO_GRANADA GONZÁLEZ_09930341-7_SUPERVISOR_SUPERVISION_ZAO_CARLOS GRANADA","CARLOS ALEJANDRO_QUINTANA SANDOVAL_15101323-6_SUPERVISOR_SUPERVISION_RDA_CARLOS QUINTANA","MARCOS_ABALLAY_17273201-1_DESARROLLADOR_ADMINISTRACION_ADM_MARCOS ABALLAY"];
        for ($i=0; $i < count($arreglo); $i++) {
            $array = explode("_",$arreglo[$i]);
            Colaboradore::create([
                'rutcolaborador' => $array[2],
                'nombrescolab' => $array[0],
                'apellidoscolab' => $array[1],
                'nombrecortocolab'=>$array[6],
                'deptocolab' => $array[4],
                'sectorcolab' => $array[5],
                'cargocolab' => $array[3],
                'fechaingresocolab' => date('Y-m-d H:i:s'),
                'estadocolab' => true
            ]);
        }
    }
}
