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
        <th style="1px solid #CCC">FECHA</th>
        <th style="1px solid #CCC">OC</th>
        <th style="1px solid #CCC">PROVEEDOR</th>
        <th style="1px solid #CCC">ESTADO</th>
        <th style="1px solid #CCC">MONTO</th>

    </tr>
    </thead>
    <tbody>
    @foreach($ocs as $oc)
        <tr>
            <td>{{ $oc->fechaoc }}</td>
            <td>{{ $oc->nrooc }}</td>
            <td>{{ $oc->nombreprov }}</td>
            <td>{{ $oc->estadooc }}</td>
            <td>{{ number_format ($oc->montooc, 0, ".", ",")}}</td>
            @php
            $total = $total + $oc->montooc;
            @endphp
            
        </tr>
    @endforeach
    <tr>
        <th></th>
        <th></th>
        <th></th>
        <th>TOTAL</th>
        <th>{{number_format ($total, 0, ".", ",")}}</th>
    </tr>
    </tbody>
</table>