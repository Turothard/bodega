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

class InformeEntArtExport implements FromView,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $arreglo,$articulos;

    function __construct($arreglo, $articulos) {
    $this->arreglo = $arreglo;
    $this->articulos = $articulos;
    //$this->estante = $estante;
    }
  
    public function view(): View
    {
        return view('warehouse.informes.informesentart', [
            'filtrosentart' => $this->arreglo,'arts' => $this->articulos
        ]);;
        
    }
}
