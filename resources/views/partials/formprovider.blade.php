@section('styles')
    @parent
    <!-- CSS Files -->
    {{--<link href="{{ asset('assets-wizard/css/bootstrap.min.css')}}" rel="stylesheet" />--}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" />
    <link href="{{ asset('css/custom/custom_material-bootstrap-wizard.css')}}" rel="stylesheet" />
    <link href="{{ asset('material-wizard/css/material-bootstrap-wizard.css')}}" rel="stylesheet" />
@endsection

<div class="col-sm-16 ">
    <!--      Wizard container        -->
    <div class="wizard-container">
        <div class="wizard-card" data-color="primary" id="wizardProfile">
            @if ( ! empty($edit) and $edit)
                <form role="form" action="{{ route($type.'::update', $data->id) }}" method="POST" enctype="multipart/form-data">
            @else
                <form role="form" action="{{route($type.'::store')}}" method="POST" enctype="multipart/form-data">
            @endif
                {!! csrf_field() !!}
                <!--        You can switch " data-color="purple" "  with one of the next bright colors: "green", "orange", "red", "blue"       -->
                <div class="wizard-header">
                    <h4>Se deben llenar todos los campos para continuar con los pasos.</h4>
                </div>
                <div class="wizard-navigation">
                    <ul>
                        <li><a href="#personal" data-toggle="tab">Datos Personales</a></li>
                        <li><a href="#finca" data-toggle="tab">Datos de la Finca</a></li>
                        <li><a href="#familiar" data-toggle="tab">Datos Familiares</a></li>
                    </ul>
                </div>

                <div class="tab-content">
                    <div class="tab-pane" id="personal">
                        <h4 class="info-text"> Información personal del Proveedor: </h4>
                        <div class="row">
                            {{--<div class="col-sm-4 col-sm-offset-1">--}}
                                {{--<div class="picture-container">--}}
                                    {{--<div class="picture">-
                                        {{--<img src="{{ asset('assets-wizard/img/default-avatar.png')}}" class="picture-src" id="wizardPicturePreview" title=""/>--}}
                                        {{--<input type="file" id="wizard-picture">--}}
                                    {{--</div>--}}
                                    {{--<h6>Choose Picture</h6>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-id-card fa-2x" aria-hidden="true"></i></span>
                                    <div class="form-group label-floating{{ $errors->has('id') ? ' has-error' : '' }}">
                                        <label class="control-label" readonly="readonly" id="idLabel" for="id" data-error="Incorrecto">Cédula Ciudadanía</label>
                                        <input id="id" type="text" class="form-control validate" name="id"
                                               value="{{ $usuario->id or old("id") }}"
                                               required aria-describedby="idLabel" minlength="8" maxlength="10" onkeypress="return soloNumeros(event)">
                                        @if ($errors->has('id'))
                                            <span class="material-icons form-control-feedback">clear</span>
                                            <small class="text-danger"><strong>{{ $errors->first('id') }}</strong></small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user fa-2x" aria-hidden="true"></i></span>
                                    <div class="form-group label-floating{{ $errors->has('nombres') ? ' has-error' : '' }}">
                                        <label class="control-label" id="nombresLabel" for="nombres" data-error="Incorrecto">Nombre</label>
                                        <input id="nombres" type="text" class="form-control validate" name="nombres"
                                               value="{{ $usuario->nombres or old("nombres") }}"
                                               required aria-describedby="nombresLabel" maxlength="45" onkeypress="return soloLetras(event)">
                                        @if ($errors->has('nombres'))
                                            <span class="material-icons form-control-feedback">clear</span>
                                            <small class="text-danger"><strong>{{ $errors->first('nombres') }}</strong></small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user fa-2x" aria-hidden="true"></i></span>
                                    <div class="form-group label-floating{{ $errors->has('apellidos') ? ' has-error' : '' }}">
                                        <label class="control-label" id="apellidosLabel" for="apellidos" data-error="Incorrecto">Apellido</label>
                                        <input id="apellidos" type="text" class="form-control validate" name="apellidos"
                                               value="{{ $usuario->apellidos or old("apellidos") }}"
                                               required aria-describedby="apellidosLabel" maxlength="45" onkeypress="return soloLetras(event)">
                                        @if ($errors->has('apellidos'))
                                            <span class="material-icons form-control-feedback">clear</span>
                                            <small class="text-danger"><strong>{{ $errors->first('apellidos') }}</strong></small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-repeat fa-2x" aria-hidden="true"></i></span>
                                    <div class="form-group label-floating{{ $errors->has('edadProveedor') ? ' has-error' : '' }}">
                                        <label class="control-label" id="edadProveedorLabel" for="edadProveedor" data-error="Incorrecto">Edad del Propietario</label>
                                        <input id="edadProveedor" type="number" class="form-control validate" name="edadProveedor"
                                               value="{{ $usuario->edadProveedor or old("edadProveedor") }}"
                                               required aria-describedby="edadProveedorLabel" min="18" max="150" maxlength="3" onkeypress="return soloNumeros(event)">
                                        <strong>
                                            <small id="edadProveedorHelp" class="text-muted">
                                                La edad debe ser entre 18 y 150 años.
                                            </small>
                                        </strong>
                                        @if ($errors->has('edadProveedor'))
                                            <span class="material-icons form-control-feedback">clear</span>
                                            <small class="text-danger"><strong>{{ $errors->first('edadProveedor') }}</strong></small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-phone fa-2x"></i></span>
                                    <div class="form-group label-floating{{ $errors->has('telefono') ? ' has-error' : '' }}">
                                        <label class="control-label" id="telefonoLabel" for="telefono" data-error="Incorrecto">Teléfono de Contacto</label>
                                        <input id="telefono" type="text" class="form-control validate" name="telefono" value="{{ $usuario->telefono or old('telefono') }}" required  aria-describedby="telefonoLabel" minlength="7" maxlength="10" onkeypress="return soloNumeros(event)">
                                        @if ($errors->has('telefono'))
                                            <span class="material-icons form-control-feedback">clear</span>
                                            <small class="text-danger"><strong>{{ $errors->first('telefono') }}</strong></small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-graduation-cap fa-2x" aria-hidden="true"></i></span>
                                    <div class="form-group label-floating{{ $errors->has('idNivelEstudios') ? ' has-error' : '' }}">
                                        <label class="control-label" id="idNivelEstudiosLabel" for="idNivelEstudios" data-error="Incorrecto">Nivel de Estudios</label>
                                        <select id="idNivelEstudios" class="form-control validate" name="idNivelEstudios" required aria-describedby="idNivelEstudiosLabel">
                                            <option></option>
                                            @foreach($nivelEstudios as $nivel)
                                                <option
                                                        value="{{ $nivel->id }}"
                                                        {{ (isset($usuario) ? $usuario->nivelEstudios->id : old('idNivelEstudios')) == $nivel->id ? 'selected' : '' }}>
                                                    {{ $nivel->tipo }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('idNivelEstudios'))
                                            <span class="material-icons form-control-feedback">clear</span>
                                            <small class="text-danger"><strong>{{ $errors->first('idNivelEstudios') }}</strong></small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="finca">
                        <h4 class="info-text"> Información acerca de la Finca: </h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-envira fa-2x" aria-hidden="true"></i></span>
                                    <div class="form-group label-floating{{ $errors->has('nombreFinca') ? ' has-error' : '' }}">
                                        <label class="control-label" id="nombreFincaLabel" for="nombreFinca" data-error="Incorrecto">Nombre de la Finca</label>
                                        <input id="nombreFinca" type="text" class="form-control validate" name="nombreFinca"
                                               value="{{ $usuario->nombreFinca or old("nombreFinca") }}"
                                               required aria-describedby="nombreFincaLabel" maxlength="100" onkeypress="return soloLetras(event)">
                                        @if ($errors->has('nombreFinca'))
                                            <span class="material-icons form-control-feedback">clear</span>
                                            <small class="text-danger"><strong>{{ $errors->first('nombreFinca') }}</strong></small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-map-marker fa-2x" aria-hidden="true"></i></span>
                                    <div class="form-group label-floating{{ $errors->has('pais') ? ' has-error' : '' }}">
                                        <label class="control-label" id="paisLabel" for="pais2" data-error="Incorrecto">País</label>
                                        <select id="pais2" class="form-control validate" name="pais" required aria-describedby="paisLabel"></select>
                                        @if ($errors->has('pais'))
                                            <span class="material-icons form-control-feedback">clear</span>
                                            <small class="text-danger"><strong>{{ $errors->first('pais') }}</strong></small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-map fa-2x" aria-hidden="true"></i></span>
                                    <div class="form-group label-floating{{ $errors->has('departamento') ? ' has-error' : '' }}">
                                        <label class="control-label" id="departamentoLabel" for="departamento2" data-error="Incorrecto">Departamento</label>
                                        <select id="departamento2" class="form-control validate" name="departamento" required aria-describedby="departamentoLabel"></select>
                                        @if ($errors->has('departamento'))
                                            <span class="material-icons form-control-feedback">clear</span>
                                            <small class="text-danger"><strong>{{ $errors->first('departamento') }}</strong></small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-location-arrow fa-2x" aria-hidden="true"></i></span>
                                    <div class="form-group label-floating{{ $errors->has('ciudad') ? ' has-error' : '' }}">
                                        <label class="control-label" id="ciudadLabel" for="ciudad2" data-error="Incorrecto">Municipio</label>
                                        <select id="ciudad2" class="form-control validate" name="ciudad" required aria-describedby="ciudadLabel"></select>
                                        @if ($errors->has('ciudad'))
                                            <span class="material-icons form-control-feedback">clear</span>
                                            <small class="text-danger"><strong>{{ $errors->first('ciudad') }}</strong></small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-envira fa-2x" aria-hidden="true"></i></span>
                                    <div class="form-group label-floating{{ $errors->has('corregimiento') ? ' has-error' : '' }}">
                                        <label class="control-label" id="corregimientoLabel" for="corregimiento" data-error="Incorrecto">Corregimiento</label>
                                        <input id="corregimiento" type="text" class="form-control validate" name="corregimiento"
                                               value="{{ $usuario->ubicacionFinca->corregimiento or old("corregimiento") }}"
                                               required aria-describedby="corregimientoLabel" maxlength="100" onkeypress="return soloLetras(event)">
                                        @if ($errors->has('corregimiento'))
                                            <span class="material-icons form-control-feedback">clear</span>
                                            <small class="text-danger"><strong>{{ $errors->first('corregimiento') }}</strong></small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-envira fa-2x" aria-hidden="true"></i></span>
                                    <div class="form-group label-floating{{ $errors->has('vereda') ? ' has-error' : '' }}">
                                        <label class="control-label" id="veredaLabel" for="vereda" data-error="Incorrecto">Vereda</label>
                                        <input id="vereda" type="text" class="form-control validate" name="vereda"
                                               value="{{ $usuario->ubicacionFinca->vereda or old("vereda") }}"
                                               required aria-describedby="veredaLabel" maxlength="100" onkeypress="return soloLetras(event)">
                                        @if ($errors->has('vereda'))
                                            <span class="material-icons form-control-feedback">clear</span>
                                            <small class="text-danger"><strong>{{ $errors->first('vereda') }}</strong></small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-arrows-v fa-2x" aria-hidden="true"></i></span>
                                    <div class="form-group label-floating{{ $errors->has('alturaFinca') ? ' has-error' : '' }}">
                                        <label class="control-label" id="alturaFincaLabel" for="alturaFinca" data-error="Incorrecto">Altura de la Finca</label>
                                        <input id="alturaFinca" type="number" class="form-control validate" name="alturaFinca"
                                               value="{{ $usuario->alturaFinca or old("alturaFinca") }}"
                                               required aria-describedby="alturaFincaLabel" min="1000" max="4000" minlength="4" maxlength="4" onkeypress="return soloNumeros(event)">
                                        <strong>
                                            <small id="alturaFincaHelp" class="text-muted">
                                                La altura de la finca debe ser entre 1000 y 4000 metros sobre el nivel del mar.
                                            </small>
                                        </strong>
                                        @if ($errors->has('alturaFinca'))
                                            <span class="material-icons form-control-feedback">clear</span>
                                            <small class="text-danger"><strong>{{ $errors->first('alturaFinca') }}</strong></small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-circle fa-2x" aria-hidden="true"></i></span>
                                    <div class="form-group label-floating{{ $errors->has('extensionFinca') ? ' has-error' : '' }}">
                                        <label class="control-label" id="extensionFincaLabel" for="extensionFinca" data-error="Incorrecto">Extensión de Finca</label>
                                        <input id="extensionFinca" type="number" class="form-control validate" name="extensionFinca"
                                               value="{{ $usuario->extensionFinca or old("extensionFinca") }}"
                                               required aria-describedby="extensionFincaLabel" min="1" step="0.1" minlength="1" maxlength="10">
                                        <strong>
                                            <small id="extensionFincaHelp" class="text-muted">
                                                La medida es en Hectáreas.
                                            </small>
                                        </strong>
                                        @if ($errors->has('extensionFinca'))
                                            <span class="material-icons form-control-feedback">clear</span>
                                            <small class="text-danger"><strong>{{ $errors->first('extensionFinca') }}</strong></small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-circle fa-2x" aria-hidden="true"></i></span>
                                    <div class="form-group label-floating{{ $errors->has('extensionLotes') ? ' has-error' : '' }}">
                                        <label class="control-label" id="extensionLotesLabel" for="extensionLotes" data-error="Incorrecto">Extensión del Lote o Lotes que proviene el café</label>
                                        <input id="extensionLotes" type="number" class="form-control validate" name="extensionLotes"
                                               value="{{ $usuario->extensionLotes or old("extensionLotes") }}"
                                               required aria-describedby="extensionLotesLabel" min="1" step="0.1" minlength="1" maxlength="10">
                                        <strong>
                                            <small id="extensionLotesHelp" class="text-muted">
                                                La medida es en Hectáreas.
                                            </small>
                                        </strong>
                                        @if ($errors->has('extensionLotes'))
                                            <span class="material-icons form-control-feedback">clear</span>
                                            <small class="text-danger"><strong>{{ $errors->first('extensionLotes') }}</strong></small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-coffee fa-2x" aria-hidden="true"></i></span>
                                    <div class="form-group label-floating{{ $errors->has('idVariedadCafe') ? ' has-error' : '' }}">
                                        <label class="control-label" id="idVariedadCafeLabel" for="idVariedadCafe" data-error="Incorrecto">Variedad de Café</label>
                                        <select id="idVariedadCafe" class="form-control validate" name="idVariedadCafe[]" required aria-describedby="idVariedadCafeLabel" multiple="multiple" style="width: 100%">
                                            <option></option>
                                            @foreach($tipos_cafe as $tipo)
                                                <option value="{{ $tipo->id }}" {{ in_array($tipo->id, (isset($usuario) ? $usuario->variedadesCafe()->pluck('id')->toArray() : (old('idVariedadCafe') ? old('idVariedadCafe'): []))) ? 'selected' : '' }}>{{ studly_case(strtolower($tipo->tipo)) }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('idVariedadCafe'))
                                            <span class="material-icons form-control-feedback">clear</span>
                                            <small class="text-danger"><strong>{{ $errors->first('idVariedadCafe') }}</strong></small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-circle fa-2x" aria-hidden="true"></i></span>
                                    <div class="form-group label-floating{{ $errors->has('idDensidadSiembra') ? ' has-error' : '' }}">
                                        <label class="control-label" id="idDensidadSiembraLabel" for="idDensidadSiembra" data-error="Incorrecto">Densidad de Siembra</label>
                                        <select id="idDensidadSiembra" class="form-control validate" name="idDensidadSiembra" required aria-describedby="idDensidadSiembraLabel">
                                            <option></option>
                                            @foreach($densidadSiembra as $densidad)
                                                <option
                                                        value="{{ $densidad->id }}"
                                                        {{ (isset($usuario) ? $usuario->densidadSiembra->id : old('idDensidadSiembra')) == $densidad->id ? 'selected' : '' }}>
                                                    {{ $densidad->tipo }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('idDensidadSiembra'))
                                            <span class="material-icons form-control-feedback">clear</span>
                                            <small class="text-danger"><strong>{{ $errors->first('idDensidadSiembra') }}</strong></small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-pagelines fa-2x" aria-hidden="true"></i></span>
                                    <div class="form-group label-floating{{ $errors->has('añosCafetal') ? ' has-error' : '' }}">
                                        <label class="control-label" id="añosCafetalLabel" for="añosCafetal" data-error="Incorrecto">Años del Cafetal</label>
                                        <input id="añosCafetal" type="number" class="form-control validate" name="añosCafetal"
                                               value="{{ $usuario->añosCafetal or old("añosCafetal") }}"
                                               required aria-describedby="añosCafetalLabel" min="1" max="80" minlength="1" maxlength="2" onkeypress="return soloNumeros(event)">
                                        <strong>
                                            <small id="añosCafetalHelp" class="text-muted">
                                                La edad debe ser entre 1 y 80 años.
                                            </small>
                                        </strong>
                                        @if ($errors->has('añosCafetal'))
                                            <span class="material-icons form-control-feedback">clear</span>
                                            <small class="text-danger"><strong>{{ $errors->first('añosCafetal') }}</strong></small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-circle fa-2x" aria-hidden="true"></i></span>
                                    <div class="form-group label-floating{{ $errors->has('idEdadUltimaZoca') ? ' has-error' : '' }}">
                                        <label class="control-label" id="idEdadUltimaZocaLabel" for="idEdadUltimaZoca" data-error="Incorrecto">
                                            Edad la última Zoca (del lote que proviene el café)
                                        </label>
                                        <select id="idEdadUltimaZoca" class="form-control validate" name="idEdadUltimaZoca" required aria-describedby="idEdadUltimaZocaLabel">
                                            <option></option>
                                            @foreach($edadUltimaZoca as $zoca)
                                                <option
                                                        value="{{ $zoca->id }}"
                                                        {{ (isset($usuario) ? $usuario->edadUltimaZoca->id : old('idEdadUltimaZoca')) == $zoca->id ? 'selected' : '' }}>
                                                    {{ $zoca->tipo }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('idEdadUltimaZoca'))
                                            <span class="material-icons form-control-feedback">clear</span>
                                            <small class="text-danger"><strong>{{ $errors->first('idEdadUltimaZoca') }}</strong></small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-file-text-o fa-2x" aria-hidden="true"></i></span>
                                    <div class="form-group label-floating{{ $errors->has('idEcotopo') ? ' has-error' : '' }}">
                                        <label class="control-label" id="idEcotopoLabel" for="idEcotopo" data-error="Incorrecto">Ecotopo</label>
                                        <select id="idEcotopo" class="form-control validate" name="idEcotopo" required aria-describedby="idEcotopoLabel">
                                            <option></option>
                                            @foreach($ecotopo as $ecotopos)
                                                <option
                                                        value="{{ $ecotopos->id }}"
                                                        {{ (isset($usuario) ? $usuario->ecotopo->id : old('idEcotopo')) == $ecotopos->id ? 'selected' : '' }}>
                                                    {{ $ecotopos->tipo }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('idEcotopo'))
                                            <span class="material-icons form-control-feedback">clear</span>
                                            <small class="text-danger"><strong>{{ $errors->first('idEcotopo') }}</strong></small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-file-text-o fa-2x" aria-hidden="true"></i></span>
                                    <div class="form-group label-floating{{ $errors->has('idTipoBeneficio') ? ' has-error' : '' }}">
                                        <label class="control-label" id="idTipoBeneficioLabel" for="idTipoBeneficio" data-error="idTipoBeneficio">Tipo de Beneficio / Beneficiado</label>
                                        <select id="idTipoBeneficio" class="form-control validate" name="idTipoBeneficio" required aria-describedby="idTipoBeneficioLabel">
                                            <option></option>
                                            @foreach($tipoBeneficio as $beneficio)
                                                <option
                                                        value="{{ $beneficio->id }}"
                                                        {{ (isset($usuario) ? $usuario->tipoBeneficio->id : old('idTipoBeneficio')) == $beneficio->id ? 'selected' : '' }}>
                                                    {{ $beneficio->tipo }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('idTipoBeneficio'))
                                            <span class="material-icons form-control-feedback">clear</span>
                                            <small class="text-danger"><strong>{{ $errors->first('idTipoBeneficio') }}</strong></small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="familiar">
                        <h4 class="info-text"> Información Familiar:</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group{{ $errors->has('nucleoFamiliar') ? ' has-error' : '' }}">
                                    <span class="input-group-addon"><i class="fa fa-users fa-2x" aria-hidden="true"></i></span>
                                    <div class="form-group label-floating">
                                        <label class="control-label" id="nucleoFamiliarLabel" for="nucleoFamiliar" data-error="Incorrecto">Núcleo Familiar</label>
                                        <input id="nucleoFamiliar" type="number" class="form-control validate" name="nucleoFamiliar"
                                               value="{{ $usuario->nucleoFamiliar or old("nucleoFamiliar") }}"
                                               required aria-describedby="nucleoFamiliarLabel" min="1" max="30" minlength="1" maxlength="2" onkeypress="return soloNumeros(event)">
                                        <strong>
                                            <small id="edadHelp" class="text-muted">
                                                Cuántas personas conforman el núcleo familiar.
                                            </small>
                                        </strong>
                                        @if ($errors->has('nucleoFamiliar'))
                                            <span class="material-icons form-control-feedback">clear</span>
                                            <small class="text-danger"><strong>{{ $errors->first('nucleoFamiliar') }}</strong></small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-users fa-2x" aria-hidden="true"></i></span>
                                    <div class="form-group label-floating{{ $errors->has('personasDependientesFinca') ? ' has-error' : '' }}">
                                        <label class="control-label" id="personasDependientesFincaLabel" for="personasDependientesFinca" data-error="Incorrecto">Personas Dependientes de la Finca</label>
                                        <input id="personasDependientesFinca" type="number" class="form-control validate" name="personasDependientesFinca"
                                               value="{{ $usuario->personasDependientesFinca or old("personasDependientesFinca") }}"
                                               required aria-describedby="personasDependientesFincaLabel" min="1" max="500" minlength="1" maxlength="3" onkeypress="return soloNumeros(event)">
                                        <strong>
                                            <small id="edadHelp" class="text-muted">
                                                Número de personas que dependen económicamente de la finca: Trabajadores + familia.
                                            </small>
                                        </strong>
                                        @if ($errors->has('personasDependientesFinca'))
                                            <span class="material-icons form-control-feedback">clear</span>
                                            <small class="text-danger"><strong>{{ $errors->first('personasDependientesFinca') }}</strong></small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-camera-retro fa-2x"></i></span>
                                    <div class="form-group label-floating{{ $errors->has('fotos') ? ' has-error' : '' }}">
                                        <label class="control-label" id="fotosLabel" for="nombresFotos" data-error="Incorrecto">Fotos del Proveedor</label>
                                        <input id="fotos" type="file" name="fotos[]" multiple="" {{ isset($edit) ? '' : 'required' }} accept="image/png, image/jpeg, image/jpg">
                                        <input id="nombresFotos" type="text" readonly="" class="form-control validate" {{ isset($edit) ? '' : 'required' }} aria-describedby="fotosLabel">
                                        @if ($errors->has('fotos'))
                                            <span class="material-icons form-control-feedback">clear</span>
                                            <small class="text-danger"><strong>{{ $errors->first('fotos') }}</strong></small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(isset($edit))
                            @if($estado == 0)
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-question fa-2x"></i></span>
                                        <div class="form-group label-floating{{ $errors->has('estado') ? ' has-error' : '' }}">
                                            <label class="control-label" id="estadoLabel" for="estado" data-error="Incorrecto">Estado del proveedor</label>
                                            <select id="estado" class="form-control validate" name="estado" required aria-describedby="estadoLabel">
                                                <option></option>
                                                <option value="0" {{ (isset($usuario) ? $usuario->estado : old('estado')) == "0" ? 'selected' : '' }}>Inactivo</option>
                                                <option value="1" {{ (isset($usuario) ? $usuario->estado : old('estado')) == "1" ? 'selected' : '' }}>Activo</option>
                                            </select>
                                            @if($errors->has('estado'))
                                                <span class="material-icons form-control-feedback">clear</span>
                                                <small class="text-danger"><strong>{{ $errors->first('estado') }}</strong></small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endif
                    </div>
                </div>
                <div class="wizard-footer">
                    <div class="pull-right">
                        <input type='button' class='btn btn-next btn-round btn-fill btn-success btn-wd' name='next' value='Seguir' />
                        @if (! empty($edit) and $edit)
                            <input type='submit' class='btn btn-finish btn-round btn-fill btn-success btn-wd' name='finish' value='Editar' />
                            {{--<button class="btn btn-success btn-round pull-center">Editar Producto</button>--}}
                        @else
                            <input type='submit' class='btn btn-finish btn-round btn-fill btn-success btn-wd' name='finish' value='Crear' />
                            {{--<button class="btn btn-success btn-round pull-center">Crear Producto</button>--}}
                        @endif

                    </div>

                    <div class="pull-left">
                        <input type='button' class='btn btn-previous btn-fill btn-round btn-default btn-wd' name='previous' value='Anterior' />
                    </div>

                    <div class="center">
                        <a type="button" href="{{ route($type.'::index') }}" class="btn btn-danger btn-round btn-wd pull-center">Cancelar</a>
                    </div>

                    <div class="clearfix"></div>
                </div>
            </form>
        </div>
    </div> <!-- wizard container -->
</div>

@section('scripts')
    @parent
    <!--   Core JS Files   -->
    {{--<script src="{{ asset('assets-wizard/js/jquery-2.2.4.min.js')}}" type="text/javascript"></script>--}}
    {{--<script src="{{ asset('assets-wizard/js/bootstrap.min.js')}}" type="text/javascript"></script>--}}
    <script src="{{ asset('material-wizard/js/jquery.bootstrap.js')}}" type="text/javascript"></script>

    <!--  Plugin for the Wizard -->
    <script src="{{ asset('material-wizard/js/material-bootstrap-wizard.js')}}"></script>

    <!--  More information about jquery.validate here: http://jqueryvalidation.org/	 -->
    <script src="{{ asset('material-wizard/js/jquery.validate.min.js')}}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#idVariedadCafe").select2({
                theme: "bootstrap",
                placeholder: 'Selecciona una variedad de café...',
                allowClear: true
            });
            //$.material.init();
//            $("#idTipoCafe").selectize({
//                allowEmptyOption: true,
//            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            var departamento = $("#departamento2");
            departamento.empty();
            departamento.append("<option value='' selected> Primero selecciona tu país...</option>");

            var ciudad = $("#ciudad2");
            ciudad.empty();
            ciudad.append("<option value='' selected> Primero selecciona tu departamento...</option>");

            var paisSelect = $("#pais2");
            $.get('{{url('country')}}', function(data, status) {
                var count = Object.keys(data).length;
                paisSelect.empty();
                paisSelect.append("<option value=''> Selecciona tu país...</option>");
                for(i=1; i<=count;  i++) {
                    if('{{(!empty($usuario))? $usuario->ubicacionFinca->pais : $pais }}' === data[i]) {
                        selected = 'selected';
                    } else {
                        selected = '';
                    }
                    paisSelect.append("<option value='"+data[i]+"' "+selected+"> "+data[i]+"</option>");
                }
                paisSelect.change();
            });
        });

        $("#pais2").change(function(event) {
            var departamento = $("#departamento2");
            var country = event.target.value;
            if(country === "") {
                departamento.empty();
                departamento.append("<option value='' selected> Primero selecciona tu país...</option>").change();
            } else {
                $.get("{{url('departments')}}/" + country, function (data, status) {
                    var count = Object.keys(data).length;
                    departamento.empty();
                    departamento.append("<option value='' selected></option>");
                    for(i=1; i<=count;  i++) {
                        if('{{$usuario->ubicacionFinca->departamento or old('departamento')}}' === data[i]) {
                            selected = 'selected';
                        } else {
                            selected = '';
                        }
                        departamento.append("<option value='"+data[i]+"' "+selected+"> "+data[i]+"</option>");
                    }
                    departamento.change();
                });
            }
        });

        $("#departamento2").change(function(event) {
            var ciudad = $("#ciudad2");
            var departamento = event.target.value;
            if(departamento === "") {
                ciudad.empty();
                ciudad.append("<option></option>");
            } else {
                $.get("{{url('cities')}}/" + departamento, function (data, status) {
                    var count = Object.keys(data).length;
                    ciudad.empty();
                    ciudad.append("<option value='' selected> </option>");
                    for(i=1; i<=count;  i++) {
                        if('{{$usuario->ubicacionFinca->ciudad or old('ciudad')}}' === data[i]) {
                            selected = 'selected';
                        } else {
                            selected = '';
                        }
                        ciudad.append("<option value='"+data[i]+"' "+selected+"> "+data[i]+"</option>");
                    }
                    ciudad.change();
                });
            }
        });
    </script>
@endsection