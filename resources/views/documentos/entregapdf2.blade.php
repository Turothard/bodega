<?php
$contador=0;
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Document</title>
        <style>
            body{
                font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
            }
        h1{
            text-align: center;
            text-transform: uppercase;
        }
        .tablaencabezado{
            font-size: 15px;
            border: black 1px;
        }
        #tablaencabezado tr th{
            text-align:left;
        }
        #tabladetalle{
            font-size: 13px;
            border:1px solid black;
            border-collapse: collapse;
            width: 100%;
        }
        #tabladetalle tr th,  #tabladetalle tr td{
            border:1px solid black;
            padding: 3px;
            
        }
        #tabladetalle tr td{
            height: 30px;
        }
        .inline{
            display: inline-block;
        }
        #eldiv{
            width:99%;
            /*border:1px solid black;*/
            height:560px;
        
        }
    </style>
    </head>
    <body>
        <table style="width:100%;border-collapse: collapse; text-align:center; vertical-align:middle;" border="1">
            <tr>
                <td rowspan="2" style="width:20%">
                    <img src="data:image/png;base64,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" width="130" />
                </td>
                <td style="width:60%">
                   <b> ENTREGA DE ARTÍCULOS</b>
                </td>
                <td  style="width:20%"> <b>V - 0.0</b></td>
            </tr>
            <tr>
                <td>Sistema de Gestión de Calidad<br>
                <b>ISO 9001:2015</b></td>
                <td>20.07.2020</td>
            </tr>
        </table>
    {{-- <div style="display: inline-block; width:24%; vertical-align: top;">
        <img src="data:image/png;base64,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" width="150" />
    </div>
    <div  style="display: inline-block; width:50%; ">

           <p style="font-size:24px;font-weight:bold;text-align:center;"> Entrega de Artículos</P>

    </div>
    <div style="display: inline-block; width:25%; ">
        {{date("d-m-Y, H:i")}}
    </div> --}}
    <br>
    <br>
    <table id="tablaencabezado">
        <tr>
            <th>Nro de Pedido:</th>
            <td>{{ucfirst(strtolower($pedido->id))}}</td>
        </tr>
        <tr>
            <th>Solicitante:</th>
            <td>{{ucwords(Str::lower($pedido->nombrecortocolab))}}</td>
        </tr>
        <tr>
            <th>R.U.T:</th>
            <td>{{ucfirst(strtolower($pedido->rutcolaborador))}}</td>
        </tr>
        <tr>
            <th>Cargo:</th>
            <td>{{ucwords(Str::lower($pedido->cargocolab))}}</td>
        </tr>
        <tr>
            <th>Sector:</th>
            <td>{{ucfirst(strtolower($pedido->sectorcolab))}}</td>
        </tr>
    </table>
    <br>
    <div id="eldiv">
    <table id="tabladetalle">
        <thead>
            <tr>
                <th colspan="3">Detalle Artículos</th>
                <th colspan="3">Detalle Firmas</th>
            </tr>
            <tr>
                <th style="width: 20%">Artículo</th>
                <th style="width: 5%">Cantidad</th>
                <th style="width: 5%">Estado</th>
                <th style="width: 14%">Nombre</th>
                <th style="width: 8%">Entrega</th>
                <th style="width: 8%">Devolución</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($detalle as $det)
            <tr>
                <td>{{ucfirst(Str::lower($det->nombreart))}}</td>
                <td style="text-align: center">{{$det->cantidadproceso}}</td>
                <td></td>
                <td>{{ucwords(Str::lower($det->nombrecortocolab))}}</td>
                <td></td>
                <td></td>
            </tr>
            
            @endforeach
        </tbody>
    </table>
    <p style="font-size:11px;">*Estados de los Artículos: Nuevo (N); Usado Buen Estado (U BE); Usado Mal Estado (U ME); Dar de Baja (DB).</p>
    </div>
    <br>
    <div>
        Observación:___________________________________________________________________<br>
        ______________________________________________________________________________<br>
        ______________________________________________________________________________
    </div>

    <br>
    <br>
    <div class="inline" style="width:10%"></div>
    <div class="inline" style="width:30%; text-align: center">
    _____________________ <br>
    {{ucwords(Str::lower($bodeguero->nombrecortocolab))}} <br>
    {{ucwords(Str::lower($bodeguero->cargocolab))}}</div>
    <div class="inline" style="width:20%"></div>
    <div class="inline" style="width:30%; text-align: center">
        _____________________ <br>
        {{ucwords(Str::lower($pedido->nombrecortocolab))}} <br>
        {{ucwords(Str::lower($pedido->cargocolab))}}</div>
    <div class="inline" style="width:10%"></div>
    </body>
</html>