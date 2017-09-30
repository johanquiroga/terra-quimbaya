@extends('dashboard.dashboard')

@include("dashboard.$board_user.sidebar", [
    'menuGestion'.ucfirst($type) => 'active',
])

{{--@include('layouts/form' . $tipo_datos)--}}

@section('content')

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header" data-background-color="green-dark">
                            <h4 class="title">Crear {{($type == 'admin') ? "Administrador" : "Proveedor"}}</h4>
                            <p class="category">Complete los campos para el registro</p>
                        </div>
                        <div class="card-content">
                            @if ( $type != 'provider')
                            <form role="form" action="{{route($type.'::store')}}" method="POST">
                                {!! csrf_field() !!}
                                @include('partials.form' . $type)
                            </form>
                            @else
                                @include('partials.form' . $type)
                            @endif
                        </div>
                    </div>
                </div>
            </div>

@endsection

@section('scripts')
    @parent

    @include('partials.scriptSoloNumeros')
    @include('partials.scriptSoloLetras')

@endsection

