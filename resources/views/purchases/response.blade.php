@extends('home')

@section('page', 'landing-page')

@section('header')
    @include('headers.generic', ['estado' => $compra->estadoCompra->estado])
@endsection

<?php setlocale(LC_MONETARY, 'es_CO.UTF-8'); ?>

@section('main_content')
    <div class="main main-raised">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-header header-success">
                        <h4 class="title text-center">Resultado de tu pedido</h4>
                    </div>
                    <div class="content table-responsive">
                        <table class="table table-active">
                            <thead>
                            <tr><th class="text-center" colspan="2"><h4>Datos finales del pedido</h4></th></tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Fecha</td>
                                <td>{{ $processingDate or $compra->fechaDeCompra->format('d/m/Y H:i:s') }}</td>
                            </tr>
                            <tr>
                                <td>Referencia de Compra</td>
                                <td>#{{ $compra->idOrden }}</td>
                            </tr>
                            <tr>
                                <td>Estado de la Compra</td>
                                <td>{{ ucfirst($compra->estadoCompra->estado) }}</td>
                            </tr>
                            <tr>
                                <td>Valor total</td>
                                <td>{{ money_format('%n', (isset($TX_VALUE) ? $TX_VALUE : $compra->valorTotal)) }}</td>
                            </tr>
                            <tr>
                                <td>Moneda</td>
                                <td>{{ isset($currency) ? $currency : 'COP' }}</td>
                            </tr>
                            @if(isset($reference_pol))
                            <tr>
                                <td>Referencia del pago</td>
                                <td>{{ $reference_pol }}</td>
                            </tr>
                            @endif
                            @if(isset($estadoTx))
                                <tr>
                                    <td>Estado de la transacción</td>
                                    <td>{{ $estadoTx }}</td>
                                </tr>
                            @endif
                            @if(isset($transactionId))
                            <tr>
                                <td>ID de la transacción</td>
                                <td>{{ $transactionId }}</td>
                            </tr>
                            @endif
                            </tbody>
                        </table>
                        <div class="footer text-center">
                            <a class="btn btn-primary btn-round" href="{{ route('purchase::show', $compra->idOrden) }}">Ver detalle de la compra</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection