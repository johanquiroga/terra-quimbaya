@extends('layouts.dashboard')

@include('layouts.' . $board_user . '.sidebar', [
    'menuGestion'.ucfirst($type) => 'active',
])

@section('Page-title', 'Crear Producto')

@section('styles')
    @parent
    {{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.4/css/selectize.bootstrap3.min.css" />--}}
    {{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.4/css/selectize.default.min.css" />--}}
    {{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.4/css/selectize.css" />--}}
    {{--<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />--}}
    {{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" />--}}
{{--    <link href="{{asset('css/custom-select2.css')}}" rel="stylesheet"/>--}}
@endsection

@section('content')

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header" data-background-color="green">
                            <h4 class="title">Crear Producto</h4>
                            <p class="category">Complete los campos para el registro</p>
                        </div>
                        <div class="card-content">
                            <form role="form" action="{{route($type.'::store')}}" method="POST" enctype="multipart/form-data">
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