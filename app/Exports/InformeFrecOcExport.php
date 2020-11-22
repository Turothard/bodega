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

class InformeFrecOcExport implements FromView,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $arreglo,$articulos;

    function __construct($arreglo, $ocs) {
    $this->arreglo = $arreglo;
    $this->ocs = $ocs;
    //$this->estante = $estante;
    }
  
    public function view(): View
    {
        return view('informes.informesfrecoc', [
            'filtrosfrecoc' => $this->arreglo,'ocs' => $this->ocs
        ]);;
        
    }
}
