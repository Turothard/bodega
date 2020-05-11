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
    <div style="display: inline-block; width:20%; vertical-align: top; border: black 1px;">
        <img src="..\public\images\logozealserv.png" width="150" />
    </div>
    <div  style="display: inline-block; width:60%; border: black 1px;">
        <h2>
            INFORME CAJA CHIA DEL {{$fechai}} ASL {{$fechaf}}
        </h2>
    </div>
    <div  style="display: inline-block; width:20%; border: black 1px;">
        {{date("d-m-Y, H:i")}}
    </div>
    <br>
    <br>
    <table id="tabladetalle">
        <thead>
            
            <tr>
                <th>Proveedor</th>
                <th>RUT</th>
                <th>Tipo Doc</th>
                <th>Nro Doc</th>
                <th>Artículo</th>
                <th>Cantidad</th>
                <th>Valor Unit</th>
                <th>Total</th>
                <th>Fecha Ingreso</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($compras as $det)
            <tr>
                <td style="max-width: 350px">{{ucfirst(strtolower($det->nombreproving))}}</td>
                <td>{{$det->proveedor_id}}</td>
                <td>{{ucfirst(strtolower($det->tipodocing))}}</td>
                <td>{{ucfirst(strtolower($det->nrodocing))}}</td>
                <td>{{ucfirst(strtolower($det->nombreart))}}</td>
                <td>{{ucfirst(strtolower($det->cantidading))}}</td>
                <td>{{ucfirst(strtolower($det->precioing))}}</td>
                <td>{{ucfirst(strtolower($det->totaling))}}</td>
                <td>{{ucfirst(strtolower($det->fechaing))}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
   
    </body>
</html>