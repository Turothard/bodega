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
        <th style="1px solid #CCC"><strong>ARTÍCULOS</strong></th>
        @foreach($arts as $art)
            <td>{{ $art["nombreart"]}}</td>
            @endforeach
    </tr>
    <tr>
        <td></td>
    </tr>
    <tr>
        <th style="1px solid #CCC"><strong>PEDIDO</strong></th>
        <th style="1px solid #CCC"><strong>FECHA</strong></th>
        <th style="1px solid #CCC"><strong>COLABORADOR</strong></th>
        <th style="1px solid #CCC"><strong>ARTÍCULO</strong></th>
        <th style="1px solid #CCC"><strong>NOMBRE ART</strong></th>
        <th style="1px solid #CCC"><strong>ENTREGADO</strong></th>
        <th style="1px solid #CCC"><strong>DEVUELTO</strong></th>
    </tr>
    </thead>
    <tbody>
        
    @foreach($filtrosentart as $filtros)
        <tr>
            <td>{{ $filtros->pedido_id }}</td>
            <td>{{ $filtros->updated_at }}</td>
            <td>{{ $filtros->nombrescolab }} {{ $filtros->apellidoscolab }}</td>
            <td>{{ $filtros->codigoart }}</td>
            <td>{{ $filtros->nombreart }}</td>
            <td>{{ $filtros->cantidadproceso}}</td>
            <td>{{ $filtros->cantidaddevolucion}}</td>
        </tr>
    @endforeach
    </tbody>
</table>