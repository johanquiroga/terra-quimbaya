@extends('layouts.dashboard')

@include('layouts.' . $board_user . '.sidebar', [
    'menuGestion'.ucfirst($type) => 'active',
])

@section('Page-title', 'Modificar Calificación')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" data-background-color="green">
                    <h4 class="title">Modificar Calificación</h4>
                    <p class="category">Edite los campos los campos que desea actualizar</p>
                </div>
                <div class="card-content">
                    <form role="form" action="{{ route('purchase::review::update', $compra->idOrden) }}" method="POST">
                        {!! csrf_field() !!}
                        @if(!(count($errors) > 0))
                            @include('partials.formreview', ['edit' => true, 'calificacion' => $compra->calificacion])
                        @else
                            @include('partials.formreview', ['edit' => true])
                        @endif
                        <div class="footer text-center">
                            {{--<button type="button" class="btn btn-simple btn-primary btn-lg">Iniciar Sesión</button>--}}
                            <button class="btn btn-round btn-success pull-center">Actualizar calificación</button>
                            <a type="button" href="{{ route('purchase::show', $compra->idOrden) }}" class="btn btn-danger btn-round btn-wd pull-center">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection