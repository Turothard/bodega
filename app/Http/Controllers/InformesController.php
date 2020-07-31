<?php

namespace App\Http\Controllers;
use App\Exports\InformeStockExport;
use App\Exports\InformeStockCriticoExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
class InformesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('informes/informe');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    public function export(Request $request) 
    {   
        $filtros =$request->detalle;
        switch ($request->tipo) {
            case 'informesstock':
                $name ='InformeStock'.date('Ymd_His').'.xlsx';
                Excel::store(new InformeStockExport($filtros["bodega"],$filtros["estante"]), $name, 'informex');
                return $name;
                break;
                case 'informesstockcritico':
                    $name ='InformeStockCritico'.date('Ymd_His').'.xlsx';
                    Excel::store(new InformeStockCriticoExport($filtros["bodega"],$filtros["estante"]), $name, 'informex');
                    return $name;
                    break;
            default:
                # code...
                break;
        }
        
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
