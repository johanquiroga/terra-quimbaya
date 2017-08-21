@extends('layouts.dashboard')

@include('layouts.' . $board_user . '.sidebar', [
    'menuGestion'.ucfirst($type) => 'active',
])

@section('Page-title', 'Modificar Producto')

@section('styles')
    @parent
    {{--<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />--}}
    {{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" />--}}
@endsection

@section('content')

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header" data-background-color="green">
                            <h4 class="title">Modificar Producto</h4>
                            <p class="category">Edite los campos los campos que desea actualizar</p>
                        </div>
                        <div class="card-content">
                            <form role="form" action="{{ route($type.'::update', $data->idPublicacion) }}" method="POST" enctype="multipart/form-data">
                                {!! csrf_field() !!}
                                @if(!(count($errors) > 0))
                                    @include('partials.form' . $type, ['edit' => true, 'producto' => $data, 'estado' => $data->estado])
                                @else
                                    @include('partials.form' . $type, ['edit' => true, 'estado' => $data->estado])
                                @endif
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