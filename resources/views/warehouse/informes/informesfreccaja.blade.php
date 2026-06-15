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
$totalneto = 0;
$totalbruto = 0;
@endphp
<table>
    <thead>
    <tr>
        <th style="1px solid #CCC">FECHA</th>
        <th style="1px solid #CCC">NRO DOC</th>
        <th style="1px solid #CCC">DOCUMENTO</th>
        <th style="1px solid #CCC">PROVEEDOR</th>
        <th style="1px solid #CCC">MONTO NETO</th>
        <th style="1px solid #CCC">MONTO BRUTO</th>

    </tr>
    </thead>
    <tbody>
    @foreach($cajas as $caja)
        <tr>
            <td>{{ $caja->fechaingresoing }}</td>
            <td>{{ $caja->tipodocing }}</td>
            <td>{{ $caja->nrodocing }}</td>
            <td>{{ $caja->nombreproving }}</td>
            <td>{{ number_format ($caja->montoing, 0, ".", ",")}}</td>
            <td>{{ number_format (((INT)$caja->montoing*1.19), 0, ".", ",")}}</td>
            @php
            $totalneto = $totalneto + $caja->montoing;
            $totalbruto = $totalbruto + ((INT)$caja->montoing*1.19)
            @endphp
            
        </tr>
    @endforeach
    <tr>
        <th></th>
        <th></th>
        <th></th>
        <th>TOTAL</th>
        <th>{{number_format ($totalneto, 0, ".", ",")}}</th>
        <th>{{number_format ($totalbruto, 0, ".", ",")}}</th>
    </tr>
    </tbody>
</table>