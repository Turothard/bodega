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

class InformeStockExport implements FromView,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $bodega,$estante;

    function __construct($bodega,$estante) {
    $this->bodega = $bodega;
    $this->estante = $estante;
    }
  
    public function view(): View
    {
        if($this->bodega!=null && $this->estante!=null){
            return view('warehouse.informes.informesstock', [
                'filtrosstock' => Posicione::where('cantidadpos','>','0')
                ->join('estantes','posiciones.estante_id', 'estantes.id')
                ->join('articulos', 'posiciones.codigoart', 'articulos.codigoart')
                ->where('estantes.bodega_id', $this->bodega)
                ->where('estantes.id', $this->estante)
                ->select('estantes.bodega_id', 'articulos.nombreart','estantes.nroestante', 'posiciones.sectorpos', 'posiciones.nivelpos', 'posiciones.cantidadpos')->get()
            ]);;
        }else{
            if($this->bodega!=null){
                return view('warehouse.informes.informesstock', [
                    'filtrosstock' => Posicione::where('cantidadpos','>','0')
                    ->join('estantes','posiciones.estante_id', 'estantes.id')
                    ->join('articulos', 'posiciones.codigoart', 'articulos.codigoart')
                    ->where('estantes.bodega_id', $this->bodega)
                    ->select('estantes.bodega_id', 'articulos.nombreart','estantes.nroestante', 'posiciones.sectorpos', 'posiciones.nivelpos', 'posiciones.cantidadpos')->get()
                ]);
            }
            return view('warehouse.informes.informesstock', [
                'filtrosstock' => Posicione::where('cantidadpos','>','0')
                ->join('estantes','posiciones.estante_id', 'estantes.id')
                ->join('articulos', 'posiciones.codigoart', 'articulos.codigoart')
                ->select('estantes.bodega_id', 'articulos.nombreart','estantes.nroestante', 'posiciones.sectorpos', 'posiciones.nivelpos', 'posiciones.cantidadpos')->get()
            ]);
        }
        
    }
}
