<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Agencia;

class AgenciasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arreglo= ["ABRAHAM TOME","ALAN SMITH","BROWNE","C DE AGUIRRE","C. CARRASCO","CARLOS DURAN","CARLOS ROSSI","CELIS","CORADINES","EDUARDO CAMPOS","FCO PARDO","FCO VARGAS","FUENZALIDA","GERARDO VALLE","GUERRA","HARDY","HECTOR GUTIERREZ","HERNAN TELLERIA","JAIME GARCIA","JC RAMOS","JC STEPHENS","JORGE VIO","JULIO SALINAS","JULIO VENEGAS","LARRAÑAGA","LEON","M FERNANDEZ","MANUEL FERNANDEZ","MAUREL","MEWES","MEWES","MONTENEGRO","NORMAN SANCHEZ","O BARRERA","OLIVARES","PAMELA ORTEGA","PATRICIO VALERO","PEDRO SANTIBAÑEZ","PIERO ROSSI","POLLMAN","RAMON VICENCIO","CARLO ROSSI","SANCHEZ","SESNICH","SMITH","SOTO ULLOA","STEPHENS","TELLERIA","VALERO","VIVEROS"];
        for ($i=0; $i < count($arreglo); $i++) { 
            
            Agencia::create([
                'nombre' => $arreglo[$i],
                'activo' => true,
            ]);
        }
    }
}
