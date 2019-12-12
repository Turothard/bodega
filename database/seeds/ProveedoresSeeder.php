<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Proveedore;
class ProveedoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arreglo= ['XXXXXXXX-1_SIN RUT_00_____','96808860-2_CATERPILLAR_02_Articulos para la mineria_Huechuraba_Av. Los Jardines 924_229277000_','96542490-3_TRECK_03_Fabrica de calzado de seguridad e inportacion de articulos de seguridad_Viña del Mar_Calle Limache N° 3132 Local 1 El Salto_322677419 - 322678092_ventas@treck.cl','76299244-2_PROTEKNICA_04_Inportadora_Viña del Mar_Riñihue 2540 Bodega E7_322353070_ventas@proteknica.cl','76155263-5_COMERCIALIZADORA ESCOBAR LTDA._05_Comercializacion de todo tipo bordados y estampados en tela_Viña del Mar_14 Norte 1240 31_973375969_Orfreshi@Hotmail.com','83758600-3_JUAN MAGAÑA Y CIA LTDA._06_Ventas por menor de Articulos Deportivos_Valparaiso_Independencia 1874_322255671_info@maganadeportes.cl','7601847-2_LUISA MARIA DINAMARCA GONZALEZ_07_Venta articulos electronicos_Valparaiso_Chacabuco 2904 A_322254128_empresa@elrayoelectron.cl','76740999-0_FERRETERIA MARCO ANTONIO PONCE MUÑOZ EIRL_08_____','96971470-1_RAMEK S.A_10_Seguridad Industrial_Viña del Mar_Calle Limache 3847 El Salto_322630141_ventas@ramek.cl','76210411-3_EXPORTACION IMPORTACION HOTELERIA FANG WANG EIRL_11_Hotel-Restaurant_Viña del Mar_Plaza Francisco Vergara 191_322698906_frangwang191@hotmail.com','4827332-7_HECTOR JUAN SEPULVEDA BUSTAMANTE _12_Distribuidora_Viña del Mar_San Antonio 1001 local 35_322734061_sysembalajes@gmail.com','77882450-7_SOMERCAM_13_Representaciones y Distrucion de Productos Quimicos_Valparaiso_Cochrane N°459 Of 4_322259791 - 322218278_somercan@gmail.com','96539970-4_PERNOVAL_14_Ferreteria_Valparaiso_Pedro Montt 2177_322212200_','77067560-K_FERRETARIA EL CANDADO LTDA._15_Ferreteria_Valparaiso_Rawson 308_322212271_','21716790-6_ENAVASADO Y DISTRIBUIDORA DE AGUA GASIFICADA._16_Distribuidora de Agua gasificada_Viña del Mar_Pablo xe Rocka 134, los almendros__','76536499-K_JUNGHEINRICH_17_Arriendo,Compra,Venta,Inpertacion,Exportacion de Gruas,Maquinarias y Equipos Industriales,Servicio Tecnico_Pudahuel_Avda. Puerto Madero N°9691 Parque Industrial Santiago_224997100_coventas@jungheinrich.cl','96768410-4_PAYROLL_18_programa computacional_Providencia_Bernardo Monn 465_324833000_Cobranza@payrol.cl','96661420-K_GLOBAL_19_Componentes electronicos_Viña del Mar_1 Ote. 946 B_322711275_','90844000-5_KUPFER_20_Articulos de seguridad, srvicios industriales_Viña del Mar_Calle Limache 3363_322632972_','96546430-1_IMPEX S.A._21_Mayorista_Valparaiso_Blanco 424_322259676 - 322259791_impex@impex.cl','96889950-3_GARMENDIA_22_Inportadora_Viña del Mar_Calle Limache 3363 loc. 4 El Salto_322157467 - 322157468_ventas@garmendia.cl','78872990-1_TRANSRADIO_23_Prooveedores de sistemas de radiocomunicacion_Huechuraba_Av. del Parque 4680A, Of. 507_226836550_','78885550 - 8_PERSONAL COMPUTER FACTORY S.A._24_Ventas e Importación Articulos Computacionales e Insumos Asesoría y Administración en Venta de Equipos y Sistemas Computacionales_Santiago_Av. Manuel Montt 170__','99510910-7_SEGURYCEL S.A._25_Comercialización de Artículos de Seguridad Industrial por Mayor y Menor_Valparaiso_Independecia 2822_322902400_grupojps@jps.cl','96792430-K_SODIMAC S.A._28_Distribuidora de Materiales de Construcción_Valparaiso_Quince Norte 1961_226802000_','76124255-5_MEGALIBRERÍA BETOS_29_Librería bazar fotocopias insumos computacionales_Valparaiso_Av. Brazil 472 _322595200_','76292620-2_ARATA & ARATA COMERCIAL LTDA._30_Venta al por mayor y pór menor de artículos de aseo y envases descartables_Viña del Mar_Arlegui 1190 B vergara_322680295_aratayarataltda@gmail.com'];
        for ($i=0; $i < count($arreglo); $i++) { 
            $array = explode("_",$arreglo[$i]);
            proveedore::create([
                'rutproveedor' => $array[0],
                'nombreprov' => $array[1],
                'codigoprov' => $array[2],
                'giroprov' => $array[3],
                'comunaprov' => $array[4],
                'direccionprov' => $array[5],
                'telefonoprov' => $array[6],
                'correoprov' => $array[7],
            ]);
        }
    }
}
