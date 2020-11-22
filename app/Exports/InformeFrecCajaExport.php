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

class InformeFrecCajaExport implements FromView,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $arreglo,$articulos;

    function __construct($arreglo, $cajas) {
    $this->arreglo = $arreglo;
    $this->cajas = $cajas;
    //$this->estante = $estante;
    }
  
    public function view(): View
    {
        return view('informes.informesfreccaja', [
            'filtrosfreccaja' => $this->arreglo,'cajas' => $this->cajas
        ]);;
        
    }
}
