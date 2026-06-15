<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Contenido;

class ContenidosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arreglo= ["Aditivo","Aguardiente","Ajos","Almendra","Arroz","Art. Bambo","Articulos para telefonos","Arvejas","Bananos","Bioestimulantes","Bolsas","Bomba","Bulbos Flores","Camión Diesel","Cartones","Cervezas","Cestas","Cinta de embalaje","Cuero","Fertilizantes","Fibra Coco","Forfenicol","Gelatina","Granos Chia","Herbicida","Hierro dextrano","Juguetes","Leche en polvo","Legumbres","Lentejas","Licores","Lincomicina","Lizana","Madera","Maq. Usada","Maquina botonera","Med. Veterinarios","Meloxicam","Motivos decorativos","Oxitetraciclina","Palillos chinos","Paltas","Piñas","Plato prep. Carne","Prendas de Ropa","Prendas de vestir","Pulpa tomate","Puzzles de papel","Quesos","QUINOA","Sacos","Semilla Cilantro","Semilla Zanahoria","Sesamo","Sulfato magnesio","Tabaco","Taurina","Turba","Varillas Bamboo","Vino","Vitamina A","Whisky"];
        for ($i=0; $i < count($arreglo); $i++) { 
            
            Contenido::create([
                'nombre' => $arreglo[$i],
                'activo' => true,
            ]);
        }
    }
}
