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
<table>
    <thead>
    <tr>
        <th style="1px solid #CCC">ARTÍCULO</th>
        <th style="1px solid #CCC">BODEGA</th>
        <th style="1px solid #CCC">ESTANTE</th>
        <th style="1px solid #CCC">SECTOR</th>
        <th style="1px solid #CCC">NIVEL</th>
        <th style="1px solid #CCC">CANTIDAD</th>
        <th style="1px solid #CCC">STOCK CRIT.</th>
    </tr>
    </thead>
    <tbody>
    @foreach($filtrosstock as $filtros)
        <tr>
            <td>{{ $filtros->nombreart }}</td>
            <td>{{ $filtros->bodega_id }}</td>
            <td>{{ $filtros->nroestante }}</td>
            <td>{{ $filtros->sectorpos }}</td>
            <td>{{ $filtros->nivelpos}}</td>
            <td>{{ $filtros->cantidadpos}}</td>
            <td>{{ $filtros->stockcriticoart}}</td>
        </tr>
    @endforeach
    </tbody>
</table>