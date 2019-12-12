<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Marca;
class MarcasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arreglo= ['Z99_ZEAL SERVICIOS','A01_DARROKA','A02_STEELPRO','A03_ACTIVEX','A04_WORLD','A05_SAFESATIS','A06_BLACKBULL','A07_BUFALO','A08_ALLBRIEFS','A09_3M','A10_RESISTOR','A11_AIR','A12_MEGA MAX','A13_LIBUS','A14_DYNAL','A15_OPTIMUS','A16_BANDPACK','A17_GRAPAS','A18_ZUNCHO','A19_MANGA','A20_KENDY','A21_QUIMICA UNIVERSAL','A22_FODEX','A23_RED LINE','A24_KARSON','A25_WESSER','A26_CONDOR','A27_INCHALAM','A28_VECTOR','A29_INDURA','A30_NAPOLEON','A31_TRICOLOR ','A32_STANLEY','A33_BAUKER','A34_KENWOOD','A35_PHILCO','A36_SAMSUNG','A37_LOGITECH','A38_KLEINE','A39_VIRUTEX','A40_TITIZ','A41_BIC','A42_STABILO','A43_TORRES','A44_KORES','A45_FULTONS','A46_SHARPIE','A47_HAND','A48_ARTEL','A49_COLON','A50_CHAMEX','A51_CHAMEX','A52_CANVAS','A53_V-FLEX','A54_ATOX','A55_ENZUCHADORA','A56_SELLADOR DE GRAPAS','A57_AIRSAFTY','A58_HALUX','A59_PILOT','A60_BIC','A61_ISOFIT','A62_PRITT STIC FIX','A63_PROARTE','A64_SHACHIHATA','A65_BOSTITSH','A66_PELICAN','A67_ADIX','A68_SELLOFFICE','A69_CHAMEX','A70_DON CHITO','A71_TRIED','A72_FIBRO','A73_VIDELA','A74_ROMMEL','A75_BASURING','A76_REGIO','A77_TANAX','A78_MAXIMA'];
        for ($i=0; $i < count($arreglo); $i++) { 
            $array = explode("_",$arreglo[$i]);
            Marca::create([
                'idmarca' => $array[0],
                'nombremar' => $array[1],
            ]);
        }
    }
}
