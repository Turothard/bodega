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

class InformeStockCriticoExport implements FromView,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $bodega,$estante;

  
  
    public function view(): View
    {
        
        return view('informes.informesstockcritico', [
            'filtrosstock' => Posicione::where("cantidadpos",">","0")
            ->join("estantes","posiciones.estante_id", "estantes.id")
            ->join("articulos", "posiciones.codigoart", "articulos.codigoart")
            ->whereRaw("articulos.stockcriticoart >= posiciones.cantidadpos ")
            ->select("estantes.bodega_id", "articulos.nombreart","estantes.nroestante", "posiciones.sectorpos", "posiciones.nivelpos",
             "posiciones.cantidadpos", "articulos.stockcriticoart")->get()
        ]);
        
        
    }
}
