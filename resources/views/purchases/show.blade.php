@extends('layouts.dashboard')

@include('layouts.' . $board_user . '.sidebar', [
    'menuGestion'.ucfirst($type) => 'active',
])

@section('Page-title', 'Detalle de Compra')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-raised">
                <div class="card-header" data-background-color="brown">
                    <h3 class="title text-center">Detalle de la compra #{{ $compra->idOrden }} del {{ $compra->fechaDeCompra->format('d/m/Y H:i') }}</h3>
                </div>
                <div class="card-content">
                    <div class="container-fluid">
                        @if($user instanceof \App\Models\Comprador)
                        <div class="dropdown pull-right">
                            <a href="#" class="btn btn-primary btn-simple dropdown-toggle" data-toggle="dropdown">
                                Acciones
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                @if(isset($compra->calificacion))
                                    @can('editReview', $compra)
                                        <li><a href="{{ route('purchase::review::edit', $compra->idOrden) }}">Modificar calificación</a></li>
                                    @endcan
                                @endif
                                @can('refund', $compra)
                                    <li><a href="{{ route('purchase::refund', $compra->idOrden) }}">Solicitar devolución</a></li>
                                @endcan
                            </ul>
                        </div>
                        @endif
                        <div class="section">
                            <div class="row">
                                <br><br>
                                <div class="col-md-4 col-md-offset-2">
                                    <h3 class="title">Producto</h3>
                                    {{--<div class="row">--}}
                                    <div class="media">
                                        <a class="pull-left" href="{{ route('product::show', $compra->product->idPublicacion) }}">
                                            <div class="avatar">
                                                <img height="60" width="60" class="media-object img-raised img-rounded" src="{{ route('storage::get', $compra->product->fotos[0]->path . $compra->product->fotos[0]->nombreArchivo) }}">
                                            </div>
                                        </a>
                                        <div class="media-body">
                                            <h4 class="media-heading">
                                                <a href="{{ route('product::show', $compra->product->idPublicacion) }}">{{ $compra->product->nombre }}</a>
                                            </h4>
                                            <h6 class="text-muted"></h6>
                                            <p>
										        <?php setlocale(LC_MONETARY, 'es_CO.UTF-8'); ?>
                                                {{money_format('%n', $compra->product->precioEmpaque) }} x {{ $compra->cantidad }} {{ ($compra->cantidad > 1) ? 'unidades' : 'unidad' }}.
                                                <span class="text-muted">Publicación #{{ $compra->product->idPublicacion }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    {{--</div>--}}
                                </div>

                                <div class="col-md-4">
                                    <h3 class="title">Proveedor</h3>
                                    {{--<div class="row">--}}
                                    <div class="media">
                                        <a class="pull-left" href="{{ route('provider::show', $compra->product->proveedor->id) }}">
                                            <div class="avatar">
                                                <img height="60" width="60" class="media-object img-raised img-rounded" src="{{ route('storage::get', $compra->product->proveedor->fotos[0]->path . $compra->product->proveedor->fotos[0]->nombreArchivo) }}">
                                            </div>
                                        </a>
                                        <div class="media-body">
                                            <h4 class="media-heading">
                                                <a href="{{ route('provider::show', $compra->product->proveedor->id) }}">{{ $compra->product->proveedor->nombres }} {{ $compra->product->proveedor->apellidos }}</a>
                                            </h4>
                                            <h6 class="text-muted"></h6>
                                            <ul class="list-unstyled">
                                                <li>
                                                    <strong>Finca: </strong>{{ $compra->product->proveedor->nombreFinca }}
                                                </li>
                                                <li>
                                                    {{ $compra->product->proveedor->ubicacionFinca->vereda }}, {{ $compra->product->proveedor->ubicacionFinca->corregimiento }}<br>
                                                    {{ $compra->product->proveedor->ubicacionFinca->ciudad }}, {{ $compra->product->proveedor->ubicacionFinca->departamento }}, {{ $compra->product->proveedor->ubicacionFinca->pais }}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    {{--</div>--}}
                                </div>
                            </div>
                            <br><br>
                            <div class="row">
                                <div class="col-md-4 col-md-offset-2">
                                    @if($user instanceof \App\Models\Comprador)
                                        <h3 class="title">Administrador encargado</h3>
                                        <div class="">
                                            <div class="media">
                                                <a class="pull-left">
                                                    <i class="fa fa-user fa-3x"></i>
                                                </a>
                                                <div class="media-body">
                                                    <h4 class="media-heading">
                                                        {{ $compra->product->admin->nombres }} {{ $compra->product->admin->apellidos }}
                                                    </h4>
                                                    <h6 class="text-muted"></h6>
                                                    <ul class="list-unstyled">
                                                        <li>
                                                            <strong>Cédula Ciudadanía: </strong>{{ $compra->product->admin->id }}
                                                        </li>
                                                        <li>
                                                            <strong>Correo Electrónico: </strong>{{ $compra->product->admin->correoElectronico }}
                                                        </li>
                                                        <li>
                                                            <strong>Telefono: </strong>{{ $compra->product->admin->telefono }}
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif($user instanceof \App\Models\Administrador)
                                        <h3 class="title">Comprador</h3>
                                        <div class="">
                                            <div class="media">
                                                <a class="pull-left">
                                                    <i class="fa fa-user fa-3x"></i>
                                                </a>
                                                <div class="media-body">
                                                    <h4 class="media-heading">
                                                        {{ $compra->comprador->nombres }} {{ $compra->comprador->apellidos }}
                                                    </h4>
                                                    <h6 class="text-muted"></h6>
                                                    <ul class="list-unstyled">
                                                        <li>
                                                            <strong>Cédula Ciudadanía: </strong>{{ $compra->comprador->id }}
                                                        </li>
                                                        <li>
                                                            <strong>Correo Electrónico: </strong>{{ $compra->comprador->correoElectronico }}
                                                        </li>
                                                        <li>
                                                            <strong>Telefono: </strong>{{ $compra->comprador->telefono }}
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <h3 class="title">Dirección de entrega</h3>
                                    <div class="">
                                        <div class="media">
                                            <a class="pull-left">
                                                <i class="fa fa-map-marker fa-3x"></i>
                                            </a>
                                            <div class="media-body">
                                                <h4 class="media-heading">
                                                    {{ $compra->comprador->nombres }} {{ $compra->comprador->apellidos }}
                                                </h4>
                                                <h6 class="text-muted"></h6>
                                                <ul class="list-unstyled">
                                                    <li>
                                                        {{ $compra->comprador->telefono }}<br>
                                                        {{ $compra->comprador->direccion->direccion }}<br>
                                                        "{{ $compra->comprador->direccion->direccionAuxiliar }}"<br>
                                                        {{ $compra->comprador->direccion->ciudad }}, {{ $compra->comprador->direccion->departamento }}, {{ $compra->product->proveedor->ubicacionFinca->pais }}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br><br>
                        <div class="section">
                            <div class="row">
                                <div class="col-md-4 col-md-offset-2">
                                    <h3 class="title">Pago</h3>
                                    <div class="">
                                        <ul class="list-unstyled">
                                            <li>
                                        <span class="fa-stack fa-lg">
                                            <i class="fa fa-money fa-stack-1x"></i>
                                            @if($compra->estadoCompra->estado == 'aceptada')
                                                <i class="fa fa-check fa-stack-x fa-pull-right text-success"></i>
                                            @elseif($compra->estadoCompra->estado == 'rechazada' || $compra->estadoCompra->estado == 'devuelto')
                                                <i class="fa fa-times fa-stack-x fa-pull-right text-danger"></i>
                                            @else
                                                <i class="fa fa-exclamation fa-stack-x fa-pull-right text-warning"></i>
                                            @endif
                                        </span> <strong>{{ ucwords($compra->estadoCompra->estado) }}</strong>
                                            </li>
                                        </ul>
                                    </div>
                                    {{--<div class="row">--}}
                                    <div class="">
                                        <table class="table table-responsive">
                                            <tr><td>Producto ({{money_format('%n', (($compra->valorTotal / (1+0.19)) / $compra->cantidad)) }} x {{ $compra->cantidad }} u.)</td><td>{{ money_format('%n', $compra->product->precioEmpaque * $compra->cantidad) }}</td></tr>
                                            <tr><td>IVA (19%) </td><td>{{ money_format('%n', ($compra->valorTotal / (1+0.19))*0.19) }}</td></tr>
                                            <tr><td><strong>Total pagado</strong></td><td><strong>{{ money_format('%n', $compra->valorTotal) }}</strong></td></tr>
                                        </table>
                                    </div>
                                    {{--</div>--}}
                                </div>
                            </div>
                        </div>
                        @if($compra->estadoCompra->estado == 'aceptada')
                        <br><br>
                        <div class="section">
                            <div class="row">
                                <div class="col-md-6 col-md-offset-2">
                                    <h3 class="title">Calificación</h3>
                                    <div class="">
                                        @if(isset($compra->calificacion))
                                        <div class="media">
                                            <div class="media-body">
                                                <h4 class="media-heading">{{ $compra->comprador->nombres }} {{ $compra->comprador->apellidos }}</h4>
                                                <input id="calificacion" name="calificacion" value="{{ $compra->calificacion->calificacion }}" class="rating kv-ltr-theme-fa-star rating-loading" data-display-only="true" data-theme="krajee-fa" data-size="xs">
                                                <p>{!! nl2br(e($compra->calificacion->comentario)) !!}</p>
                                                @can('editReview', $compra)
                                                <a href="{{ route('purchase::review::edit', $compra->idOrden) }}">Modificar</a>
                                                @endcan
                                            </div>
                                        </div>
                                        @else
                                            @can('review', $compra)
                                            <div class="media media-post">
                                                <div class="media-body">
                                                    <form role="form" action="{{ route('purchase::review', $compra->idOrden) }}" method="POST">
                                                        {!! csrf_field() !!}
                                                        @include('partials.formreview')
                                                        <div class="media-footer text-center">
                                                            <button class="btn btn-primary btn-round">Publicar Calificación</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            @endcan
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @can('refund', $compra)
                        <br><br>
                        <div class="section">
                            <div class="row">
                                <div class="col-md-6 col-md-offset-2">
                                    <a href="{{ route('purchase::refund', $compra->idOrden) }}">Solicitar devolución</a>
                                </div>
                            </div>
                        </div>
                        @endcan
                        @endif
                    </div>
                </div>
                <div class="card-footer text-center">
                    <a class="btn btn-round btn-primary" href="{{ route('request::index') }}">Volver al listado</a>
                </div>
            </div>
        </div>
    </div>
@endsection