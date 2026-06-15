<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\CampoFormulario;

class CampoFormulariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arreglo= ["Numero_Numero_Texto_Número_TRUE_dato_","Texto_Texto_Texto_Nombre_TRUE_dato_","Texto_Texto_Texto_Apellido_TRUE_dato_","fecha_fecha_fecha_Fecha_TRUE_dato_","Areatexto_Areatexto_Areatexto_Observación_FALSE_dato_","Password_Password_Password_Contraseña_TRUE_dato_","Numero_Numero_Texto_Cantidad_TRUE_dato_","Hora_Hora_Texto_Hora_TRUE_dato_","Imagen_Imagen_Imagen_Foto_TRUE_dato_","Selector_Texto_Texto_Sector_TRUE_dato_App\Sector","Selector_Texto_Texto_Area_TRUE_dato_App\Area","Selector_Texto_Texto_Agencias_TRUE_dato_App\Agencia","Buscador_Texto_Texto_Colaborador_TRUE_dato_App\Colaboradore","Numero_Numero_Texto_Horas trabajadas_TRUE_funcion_horastrabajadas()","Numero_Numero_Texto_Cantidad de Lotes_TRUE_dato_","Fecha_Hora_Hora_Hora inicio (Trabajo) _TRUE_funcion_inicio()","Fecha_Hora_Hora_Hora termino (Trabajo)_TRUE_funcion_termino()","Buscador_Texto_Texto_Colaborador_TRUE_objeto_App\Colaboradore","Imagen_Imagen_Imagen_Foto Inicio_TRUE_dato_","Imagen_Imagen_Imagen_Foto Termino_TRUE_dato_","Selector_Texto_Texto_Color Poncha_TRUE_grupo_Azul|Verde|Negro","Numero_Numero_Texto_N° de Lote_TRUE_dato_","Numero_Numero_Texto_Toneladas_TRUE_dato_"];
        for ($i=0; $i < count($arreglo); $i++) { 
            $array = explode("_",$arreglo[$i]);
            CampoFormulario::create([
                'tipo' => $array[0],
                'tipoformulario' => $array[1],
                'tipoinforme' => $array[2],
                'nombre' => $array[3],
                'tipovalor' => $array[5],
                'valor' => $array[6],
                'extensible' => false,
                'requerido' => $array[4],
                'activo' => true,
            ]);
        }
    }
}
