@extends('dashboard.dashboard')

@include("dashboard.$board_user.sidebar", [
    'menuGestion'.ucfirst($type) => 'active',
])

@section('Page-title', 'Generar Informe')

@section('content')

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header" data-background-color="brown">
                            <h4 class="title">Generar Informe</h4>
                            <p class="category">Complete los campos para generar el Informe</p>
                        </div>
                        <div class="card-content">
                            <form role="form" action="{{route($type.'::store')}}" method="POST">
                                {!! csrf_field() !!}
                                @include('partials.form' . $type)
                            </form>
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