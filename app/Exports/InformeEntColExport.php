<?php

namespace App\Exports;

use App\Posicione;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Invoice;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class InformeEntColExport implements FromView,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $arreglo,$nombres;

    function __construct($arreglo, $nombres) {
    $this->arreglo = $arreglo;
    $this->nombres = $nombres;
    //$this->estante = $estante;
    }
  
    public function view(): View
    {
        return view('informes.informesentcol', [
            'filtrosentcol' => $this->arreglo,'noms' => $this->nombres
        ]);;
        
    }
}
