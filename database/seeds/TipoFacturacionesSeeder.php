<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\TipoFacturacione;
class TipoFacturacionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arreglo= ['facturacion uno','facturacion dos'];
        for ($i=0; $i < count($arreglo); $i++) { 
            
            TipoFacturacione::create([
                'nombre' => $arreglo[$i],
                'activo' => true,
            ]);
        }
    }
}
