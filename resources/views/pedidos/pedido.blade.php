@extends('layouts.app')

@section('content')
<link href="{{ asset('css/micss.css') }}" rel="stylesheet">
    <pedido-vue menupedidos="'pedidos'"></pedido-vue>

@endsection
