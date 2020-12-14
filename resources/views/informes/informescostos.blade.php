{{-- <table>
    <tr>
        <td rowspan="2">imagen</td>
        <td>informes</td>
        <td>version</td>
    </tr>
    <tr>
        <td>sistema</td>
        <td>00</td>
    </tr>
</table> --}}
@php
$total = 0;
@endphp
<table>
    <thead>
    <tr>
        <th style="1px solid #CCC"><strong>ARTÍCULOS</strong></th>
        @foreach($arts as $art)
            <td>{{ $art["nombreart"]}}</td>
            @endforeach
    </tr>
    <tr>
        <td></td>
    </tr>
    <tr>
        <th style="1px solid #CCC">FECHA</th>
        <th style="1px solid #CCC">PROVEEDOR</th>
        <th style="1px solid #CCC">ARTICULO</th>
        <th style="1px solid #CCC">CANTIDAD</th>
        <th style="1px solid #CCC">COSTO UNITARIO</th>
        <th style="1px solid #CCC">TOTAL NETO</th>
        <th style="1px solid #CCC">I.V.A</th>
        <th style="1px solid #CCC">TOTAL BRUTO</th>

    </tr>
    </thead>
    <tbody>
    @foreach($costos as $costo)
        <tr>
            <td>{{ $costo->fechaoc }}</td>
            <td>{{ $costo->nombreprov }}</td>
            <td>{{ $costo->nombreart }}</td>
            <td>{{ $costo->cantidaddetoc }}</td>
            <td>{{ number_format ($costo->montounitariodetoc, 0, ".", ",")}}</td>
            <td>{{ number_format ($costo->montototaldetoc, 0, ".", ",")}}</td>
            <td>{{ number_format (((INT)$costo->montototaldetoc*1.19), 0, ".", ",")}}</td>
            <td>{{ number_format (($costo->montototaldetoc+((INT)$costo->montototaldetoc*1.19)), 0, ".", ",")}}</td>
            @php
            $total = $total +($costo->montototaldetoc+(INT)$costo->montototaldetoc*1.19);
            @endphp
            
        </tr>
    @endforeach
    <tr>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th>TOTAL</th>
        <th>{{number_format ($total, 0, ".", ",")}}</th>
    </tr>
    </tbody>
</table>