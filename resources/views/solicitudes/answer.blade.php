@extends('layouts.dashboard')

@include('layouts.' . $board_user . '.sidebar', [
    'menuGestion'.ucfirst($type) => 'active',
])

@section('Page-title', 'Responder Solicitud')

@section('content')

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header" data-background-color="brown">
                            <h4 class="title">Responder Solicitud</h4>
                            <p class="category">Llene los campos los campos necesarios</p>
                        </div>
                        <div class="card-content">
                            <form role="form" action="{{ route($type.'::update', $solicitud->id) }}" method="POST" enctype="multipart/form-data">
                                {!! csrf_field() !!}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-question fa-2x"></i></span>
                                            <div class="form-group label-floating{{ $errors->has('tipoSolicitud') ? ' has-error' : '' }}">
                                                <label class="control-label" id="tipoSolicitudLabel" for="tipoSolicitud" data-error="Incorrecto">Tipo de Solicitud</label>
                                                <input id="tipoSolicitud" type="text" class="form-control validate" name="tipoSolicitud" value="{{ ucwords($solicitud->tipoSolicitud->tipo) }}" required readonly aria-describedby="tipoSolicitudLabel" maxlength="45" onkeypress="return soloLetras(event)">
                                                @if ($errors->has('tipoSolicitud'))
                                                    <span class="material-icons form-control-feedback">clear</span>
                                                    <small class="text-danger"><strong>{{ $errors->first('tipoSolicitud') }}</strong></small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-user fa-2x"></i></span>
                                            <div class="form-group label-floating{{ $errors->has('comprador') ? ' has-error' : '' }}">
                                                <label class="control-label" id="compradorLabel" for="comprador" data-error="Incorrecto">Comprador</label>
                                                <input id="comprador" type="text" class="form-control validate" name="comprador" value="{{ $solicitud->comprador->nombres }} {{ $solicitud->comprador->apellidos }}" required readonly aria-describedby="compradorLabel" maxlength="45" onkeypress="return soloLetras(event)">
                                                @if ($errors->has('comprador'))
                                                    <span class="material-icons form-control-feedback">clear</span>
                                                    <small class="text-danger"><strong>{{ $errors->first('comprador') }}</strong></small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-comment fa-2x"></i></span>
                                            <div class="form-group label-floating{{ $errors->has('mensaje') ? ' has-error' : '' }}">
                                                <label class="control-label" id="mensajeLabel" for="mensaje" data-error="Incorrecto">Mensaje</label>
                                                <input id="mensaje" type="text" class="form-control validate" name="mensaje" value="{{ $solicitud->mensaje or old("mensaje") }}" required readonly aria-describedby="nombresLabel" maxlength="45">
                                                @if ($errors->has('mensaje'))
                                                    <span class="material-icons form-control-feedback">clear</span>
                                                    <small class="text-danger"><strong>{{ $errors->first('mensaje') }}</strong></small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-check-square fa-2x"></i></span>
                                            <div class="form-group label-floating{{ $errors->has('estado') ? ' has-error' : '' }}">
                                                <label class="control-label" id="estadoLabel" for="estado" data-error="Incorrecto">Estado de Solicitud</label>
                                                <select id="estado" class="form-control validate" name="estado" required aria-describedby="estadoLabel" {{ (($solicitud->requestable instanceof App\Models\Compra || $solicitud->requestable instanceof App\Models\Devolucion) && $solicitud->estado != 'pendiente') ? 'readonly' : '' }}>
                                                    <option></option>
                                                    <option value="rechazada" {{ $solicitud->estado == 'rechazada' ? 'selected' : '' }}>Rechazar</option>
                                                    <option value="aceptada" {{ $solicitud->estado == 'aceptada' ? 'selected' : '' }}>Aceptar</option>
                                                </select>
                                                <small class="text-muted"><strong>Si es una solicitud de tipo pregunta de producto, debes poner como estado "Aceptar"; si es una confirmación de pago debes seleccionar "Aceptar" en caso de que se haya completado, "Rechazar" en caso contrario.</strong></small>
                                                @if ($errors->has('estado'))
                                                    <span class="material-icons form-control-feedback">clear</span>
                                                    <small class="text-danger"><strong>{{ $errors->first('estado') }}</strong></small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-comments fa-2x"></i></span>
                                            <div class="form-group label-floating{{ $errors->has('respuesta') ? ' has-error' : '' }}">
                                                <label class="control-label" id="respuestaLabel" for="respuesta" data-error="Incorrecto">Respuesta a la Solicitud</label>
                                                <textarea id="respuesta" type="text" class="form-control validate" name="respuesta" rows="6" required aria-describedby="descripcionLabel" maxlength="800"
                                                        {{ (($solicitud->requestable instanceof App\Models\Compra || $solicitud->requestable instanceof App\Models\Devolucion) && $solicitud->estado != 'pendiente') ? 'readonly' : '' }}>{{ $solicitud->respuesta or old("respuesta") }}</textarea>
                                                <strong><small id="charNumconsultaHelp" class="text-muted">Aquí debes poner la respuesta a la solicitud: si es una pregunta, la respuesta a la misma; si es una devolución, la respuesta según el estado previamente seleccionado; si es una confirmación de pago, debes poner alguna observación si ha ocurrido algo.<div id="textarea_feedback"></div></small></strong>
                                                @if ($errors->has('respuesta'))
                                                    <span class="material-icons form-control-feedback">clear</span>
                                                    <small class="text-danger"><strong>{{ $errors->first('respuesta') }}</strong></small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div align="center">
                                    <div class="form-group">
                                        @if(!(($solicitud->requestable instanceof App\Models\Compra || $solicitud->requestable instanceof App\Models\Devolucion) && $solicitud->estado != 'pendiente'))
                                        <button class="btn btn-success btn-round pull-center">Responder Solicitud</button>
                                        @endif
                                        <a type="button" href="{{ route($type.'::index') }}" class="btn btn-danger btn-round pull-center">Volver al listado</a>
                                    </div>
                                </div>
                                {{--@if(!(count($errors) > 0))--}}
                                    {{--@include('partials.form' . $type, ['edit' => true, 'producto' => $solicitud])--}}
                                {{--@else--}}
                                    {{--@include('partials.form' . $type, ['edit' => true])--}}
                                {{--@endif--}}
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
            $('#textarea_feedback').html(text_max + ' carácteres restantes');

            $('#respuesta').keyup(function() {
                var text_length = $('#respuesta').val().length;
                var text_remaining = text_max - text_length;

                $('#textarea_feedback').html(text_remaining + ' carácteres restantes');
            });
        });
    </script>
@endsection