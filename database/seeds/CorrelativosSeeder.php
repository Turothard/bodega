<?php

use Illuminate\Database\Seeder;
use App\Correlativo;
class CorrelativosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arreglo= ['4_ANA_00001_ANA00001','4_ANA_00002_ANA00002','4_ANA_00003_ANA00003','4_ANA_00004_ANA00004','4_ANA_00005_ANA00005','4_ANA_00006_ANA00006','4_ANA_00007_ANA00007','4_ANA_00008_ANA00008','4_ANA_00009_ANA00009','4_ANA_00010_ANA00010','4_ANA_00011_ANA00011','4_ANA_00012_ANA00012','4_ANA_00013_ANA00013','4_ANA_00014_ANA00014','4_ANA_00015_ANA00015','4_ANA_00016_ANA00016','4_ANA_00017_ANA00017','4_ANA_00018_ANA00018','4_ANA_00019_ANA00019','4_ANA_00020_ANA00020','4_ANA_00021_ANA00021','4_ANA_00022_ANA00022','4_ANA_00023_ANA00023','4_ANA_00024_ANA00024','4_ANA_00025_ANA00025','4_ANA_00026_ANA00026','4_ANA_00027_ANA00027','4_ANA_00028_ANA00028','4_ANA_00029_ANA00029','4_ANA_00030_ANA00030','4_ANA_00031_ANA00031','4_ANA_00032_ANA00032','4_ANA_00033_ANA00033','4_ANA_00034_ANA00034','4_ANA_00035_ANA00035','4_ANA_00036_ANA00036','4_ANA_00037_ANA00037','4_ANA_00038_ANA00038','4_ANA_00039_ANA00039','4_ANA_00040_ANA00040','4_ANA_00041_ANA00041','4_ANA_00042_ANA00042','4_ANA_00043_ANA00043','4_ANA_00044_ANA00044','4_ANA_00045_ANA00045','5_ASE_00001_ASE00001','5_ASE_00002_ASE00002','5_ASE_00003_ASE00003','5_ASE_00004_ASE00004','5_ASE_00005_ASE00005','5_ASE_00006_ASE00006','5_ASE_00007_ASE00007','5_ASE_00008_ASE00008','3_ELE_00001_ELE00001','3_ELE_00002_ELE00002','1_EPP_00001_EPP00001','1_EPP_00002_EPP00002','1_EPP_00003_EPP00003','1_EPP_00004_EPP00004','1_EPP_00005_EPP00005','1_EPP_00006_EPP00006','1_EPP_00007_EPP00007','1_EPP_00008_EPP00008','1_EPP_00009_EPP00009','1_EPP_00010_EPP00010','1_EPP_00011_EPP00011','1_EPP_00012_EPP00012','1_EPP_00013_EPP00013','1_EPP_00014_EPP00014','1_EPP_00015_EPP00015','1_EPP_00016_EPP00016','1_EPP_00017_EPP00017','1_EPP_00018_EPP00018','1_EPP_00019_EPP00019','1_EPP_00020_EPP00020','1_EPP_00021_EPP00021','1_EPP_00022_EPP00022','1_EPP_00023_EPP00023','1_EPP_00024_EPP00024','1_EPP_00025_EPP00025','1_EPP_00026_EPP00026','1_EPP_00027_EPP00027','1_EPP_00028_EPP00028','1_EPP_00029_EPP00029','1_EPP_00030_EPP00030','1_EPP_00031_EPP00031','1_EPP_00032_EPP00032','1_EPP_00033_EPP00033','1_EPP_00034_EPP00034','1_EPP_00035_EPP00035','1_EPP_00036_EPP00036','1_EPP_00037_EPP00037','1_EPP_00038_EPP00038','1_EPP_00039_EPP00039','1_EPP_00040_EPP00040','1_EPP_00041_EPP00041','1_EPP_00042_EPP00042','1_EPP_00043_EPP00043','1_EPP_00044_EPP00044','1_EPP_00045_EPP00045','1_EPP_00046_EPP00046','1_EPP_00047_EPP00047','1_EPP_00048_EPP00048','1_EPP_00049_EPP00049','1_EPP_00050_EPP00050','1_EPP_00051_EPP00051','1_EPP_00052_EPP00052','1_EPP_00053_EPP00053','1_EPP_00054_EPP00054','1_EPP_00055_EPP00055','1_EPP_00056_EPP00056','1_EPP_00057_EPP00057','1_EPP_00058_EPP00058','1_EPP_00059_EPP00059','1_EPP_00060_EPP00060','1_EPP_00061_EPP00061','1_EPP_00062_EPP00062','1_EPP_00063_EPP00063','1_EPP_00064_EPP00064','1_EPP_00065_EPP00065','1_EPP_00066_EPP00066','1_EPP_00067_EPP00067','1_EPP_00068_EPP00068','1_EPP_00069_EPP00069','1_EPP_00070_EPP00070','1_EPP_00071_EPP00071','1_EPP_00072_EPP00072','1_EPP_00073_EPP00073','1_EPP_00074_EPP00074','6_OFI_00001_OFI00001','6_OFI_00002_OFI00002','6_OFI_00003_OFI00003','6_OFI_00004_OFI00004','6_OFI_00005_OFI00005','6_OFI_00006_OFI00006','6_OFI_00007_OFI00007','6_OFI_00008_OFI00008','6_OFI_00009_OFI00009','6_OFI_00010_OFI00010','6_OFI_00011_OFI00011','6_OFI_00012_OFI00012','6_OFI_00013_OFI00013','6_OFI_00014_OFI00014','6_OFI_00015_OFI00015','6_OFI_00016_OFI00016','6_OFI_00017_OFI00017','6_OFI_00018_OFI00018','6_OFI_00019_OFI00019','6_OFI_00020_OFI00020','6_OFI_00021_OFI00021','6_OFI_00022_OFI00022','6_OFI_00023_OFI00023','6_OFI_00024_OFI00024','6_OFI_00025_OFI00025','6_OFI_00026_OFI00026','6_OFI_00027_OFI00027','6_OFI_00028_OFI00028','7_TRA_00001_TRA00001','7_TRA_00002_TRA00002','2_UNI_00001_UNI00001','2_UNI_00002_UNI00002','2_UNI_00003_UNI00003','2_UNI_00004_UNI00004','2_UNI_00005_UNI00005','2_UNI_00006_UNI00006','2_UNI_00007_UNI00007','2_UNI_00008_UNI00008','2_UNI_00009_UNI00009','2_UNI_00010_UNI00010','2_UNI_00011_UNI00011','2_UNI_00012_UNI00012','2_UNI_00013_UNI00013','2_UNI_00014_UNI00014','2_UNI_00015_UNI00015','2_UNI_00016_UNI00016','2_UNI_00017_UNI00017','2_UNI_00018_UNI00018','2_UNI_00019_UNI00019','2_UNI_00020_UNI00020','2_UNI_00021_UNI00021','2_UNI_00022_UNI00022','2_UNI_00023_UNI00023','2_UNI_00024_UNI00024','2_UNI_00025_UNI00025','2_UNI_00026_UNI00026','2_UNI_00027_UNI00027'];
        for ($i=0; $i < count($arreglo); $i++) { 
            $array = explode("_",$arreglo[$i]);
            Correlativo::create([
                'subcategoria_id' => $array[0],
                'subcategoria' => $array[1],
                'correlativo' => $array[2],
                'correlativofinal' => $array[3],
            ]);
        }
    }
}
