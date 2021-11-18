@extends('layouts.appinicio')


@section('contentinicio')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Sistema Zeal Servicios</div>

                <div class="card-body d-flex justify-content-center">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <button type="button" class="btn btn-primary btn-lg"><a class="nav-link text-dark font-weight-bold" href="{{ route('warehouse') }}">{{ __('Sistema Bodega') }}</a></button>&nbsp;&nbsp;&nbsp;
                    <button type="button" class="btn btn-primary btn-lg"><a class="nav-link text-dark font-weight-bold" href="{{ route('operation') }}">{{ __('Sistema Operaciones') }}</a></button>&nbsp;&nbsp;&nbsp;
                    <button type="button" class="btn btn-primary btn-lg"><a class="nav-link text-dark font-weight-bold" href="{{ route('warehouse.bodega') }}">{{ __('Sistema') }}</a></button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
