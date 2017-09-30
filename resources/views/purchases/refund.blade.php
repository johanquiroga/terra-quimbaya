@extends('dashboard.dashboard')

@include("dashboard.$board_user.sidebar", [
    'menuGestion'.ucfirst($type) => 'active',
])

@section('Page-title', 'Solicitar Devolución')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" data-background-color="brown">
                    <h4 class="title">Solicitar Devolución</h4>
                    <p class="category">Complete los campos que se le solicitan</p>
                </div>
                <div class="card-content">
                    <form role="form" action="{{ route('purchase::refund', $compra->idOrden) }}" method="POST">
                        {!! csrf_field() !!}

                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-comment fa-2x text-primary"></i></span>
                            <div class="form-group label-floating{{ $errors->has('mensaje') ? ' has-error' : '' }}">
                                <label class="control-label" id="mensajeLabel" for="mensaje" data-error="Incorrecto">Escribe las razones por las que deseas realizar la devolución aquí...</label>
                                <textarea id="mensaje" class="form-control validate" name="mensaje" rows="6" required aria-describedby="mensajeLabel" maxlength="800">{{ old("mensaje") }}</textarea>
                                <strong><small id="charNummensajeHelp" class="text-muted">Tu mensaje no debe sobrepasar los 800 caracteres. <div id="textarea_feedback"></div></small></strong>
                                @if ($errors->has('mensaje'))
                                    <span class="material-icons form-control-feedback">clear</span>
                                    <small class="text-danger">
                                        <strong>{{ $errors->first('mensaje') }}</strong>
                                    </small>
                                @endif
                            </div>
                        </div>

                        <div class="footer text-center">
                            {{--<button type="button" class="btn btn-simple btn-primary btn-lg">Iniciar Sesión</button>--}}
                            <button class="btn btn-round btn-primary pull-center">Enviar</button>
                            <a href="{{ route('purchase::show', $compra->idOrden) }}" class="btn btn-danger btn-round btn-wd pull-center">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script>
        $(document).ready(function() {
            var text_max = 800;
            $('#textarea_feedback').html(text_max + ' caracteres restantes');

            $('#mensaje').keyup(function() {
                var text_length = $('#mensaje').val().length;
                var text_remaining = text_max - text_length;

                $('#textarea_feedback').html(text_remaining + ' caracteres restantes');
            });
        });
    </script>
@endsection