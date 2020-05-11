<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
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
        font-size: 16px;
        text-align:left;
        border: black 1px;
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
            min-height: 40px;
        }
        .inline{
            display: inline-block;
        }
    </style>
    </head>
    <body>
    <div style="display: inline-block; width:25%; vertical-align: top; border: black 1px;">
        <img src="..\public\images\logozealserv.png" width="150" />
    </div>
    <div  style="display: inline-block; width:50%; border: black 1px;">
        <h2>
            Entrega de Artículos
        </h2>
    </div>
    <div  style="display: inline-block; width:25%; border: black 1px;">
        {{date("d-m-Y, H:i")}}
    </div>
    <br>
    <br>
    <table id="tablaencabezado">
        <tr>
            <th>Nro de Pedido:</th>
            <td>{{ucfirst(strtolower($pedido->id))}}</td>
        </tr>
        <tr>
            <th>Solicitante:</th>
            <td>{{ucfirst(strtolower($pedido->nombrecortocolab))}}</td>
        </tr>
        <tr>
            <th>R.U.T:</th>
            <td>{{ucfirst(strtolower($pedido->rutcolaborador))}}</td>
        </tr>
        <tr>
            <th>Cargo:</th>
            <td>{{ucfirst(strtolower($pedido->cargocolab))}}</td>
        </tr>
        <tr>
            <th>Sector:</th>
            <td>{{ucfirst(strtolower($pedido->sectorcolab))}}</td>
        </tr>
    </table>
    <br>
    <table id="tabladetalle">
        <thead>
            <tr>
                <th colspan="3">Detalle Artículos</th>
                <th colspan="3">Detalle Firmas</th>
            </tr>
            <tr>
                <th>Artículo</th>
                <th>Cantidad</th>
                <th>Estado</th>
                <th>Nombre</th>
                <th>Entrega</th>
                <th>Devolución</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($detalle as $det)
            <tr>
                <td style="max-width: 350px">{{ucfirst(strtolower($det->nombreart))}}</td>
                <td>{{$det->cantidadproceso}}</td>
                <td></td>
                <td>{{ucfirst(strtolower($det->nombrecortocolab))}}</td>
                <td style="min-width: 200px;"></td>
                <td style="min-width: 200px;"></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @for ($i = 0;  $i< 32-count($detalle) ; $i++)
        <br/>
    @endfor
    <div class="inline" style="width:10%"></div>
    <div class="inline" style="width:30%; text-align: center">
    _____________________ <br>
    {{ucfirst(strtolower($bodeguero->nombrecortocolab))}}</div>
    <div class="inline" style="width:20%"></div>
    <div class="inline" style="width:30%; text-align: center">
        _____________________ <br>
        {{ucfirst(strtolower($pedido->nombrecortocolab))}}</div>
    <div class="inline" style="width:10%"></div>
    </body>
</html>