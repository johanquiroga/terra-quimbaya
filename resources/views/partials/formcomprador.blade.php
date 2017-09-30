@section('styles')
    @parent
    <!-- CSS Files -->
    <link href="{{ asset('assets-wizard/css/material-bootstrap-wizard.css')}}" rel="stylesheet" />
    <link href="{{ asset('custom-assets/custom_material-bootstrap-wizard.css')}}" rel="stylesheet" />
@endsection

<div class="col-sm-16">
    <div class="wizard-container">
        <div class="wizard-card" data-color="primary" id="wizardProfile">
            @if(isset($edit) and $edit)
                <form role="form" action="{{ route('profile::update', $user->id) }}" method="POST">
            @else
                <form role="form" action="{{ route('register') }}" method="POST">
            @endif
                {!! csrf_field() !!}
                <div class="wizard-navigation">
                    <ul>
                        <li><a href="#cuenta" data-toggle="tab">Cuenta</a></li>
                        <li><a href="#ubicacion" data-toggle="tab">Ubicación</a></li>
                        <li><a href="#preferencias" data-toggle="tab">Preferencias del Café</a></li>
                    </ul>
                </div>

                <div class="tab-content">
                    <div class="tab-pane" id="cuenta">
                        <h4 class="info-text"> Información Personal </h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-id-card fa-2x"></i>
                                    </span>
                                    <div class="form-group label-floating{{ $errors->has('id') ? ' has-error' : '' }}">
                                        <label class="control-label"
                                               id="idLabel" for="id" data-error="Incorrecto">Cédula Ciudadanía</label>
                                        <input id="id" type="text" class="form-control validate"
                                               name="id" value="{{ $usuario->id or old('id') }}"
                                               required aria-describedby="idLabel"
                                               minlength="8" maxlength="10"
                                               onkeypress="return soloNumeros(event)">
                                        @if ($errors->has('id'))
                                            <span class="material-icons form-control-feedback">clear</span>
                                            <small class="text-danger">
                                                <strong>{{ $errors->first('id') }}</strong>
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-user fa-2x"></i>
                                    </span>
                                    <div class="form-group label-floating{{ $errors->has('nombres') ? ' has-error' : '' }}">
                                        <label class="control-label"
                                               id="nombresLabel" for="nombres" data-error="Incorrecto">Nombre</label>
                                        <input id="nombres" type="text" class="form-control validate"
                                               name="nombres" value="{{ $usuario->nombres or old('nombres') }}" required
                                               aria-describedby="nombresLabel" maxlength="45"
                                               onkeypress="return soloLetras(event)">
                                        @if ($errors->has('nombres'))
                                            <span class="material-icons form-control-feedback">clear</span>
                                            <small class="text-danger">
                                                <strong>{{ $errors->first('nombres') }}</strong>
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-user fa-2x"></i>
                                    </span>
                                    <div class="form-group label-floating{{ $errors->has('apellidos') ? ' has-error' : '' }}">
                                        <label class="control-label"
                                               id="apellidosLabel" for="apellidos" data-error="Incorrecto">Apellido</label>
                                        <input id="apellidos" type="text" class="form-control validate"
                                               name="apellidos" value="{{ $usuario->apellidos or old('apellidos') }}" required
                                               aria-describedby="apellidosLabel" maxlength="45"
                                               onkeypress="return soloLetras(event)">
                                        @if ($errors->has('apellidos'))
                                            <span class="material-icons form-control-feedback">clear</span>
                                            <small class="text-danger">
                                                <strong>{{ $errors->first('apellidos') }}</strong>
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                @if(isset($edit))
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-envelope fa-2x" aria-hidden="true"></i>
                                        </span>
                                        <div class="form-group label-floating{{ $errors->has('correoElectronico') ? ' has-error' : '' }}">
                                            <label class="control-label" id="emailLabel" for="email">Tu E-mail</label>
                                            <input type="email" id="email" class="form-control validate"
                                                   name="correoElectronico" value="{{ $usuario->correoElectronico or old("correoElectronico") }}"
                                                   required aria-describedby="emailLabel">
                                            @if ($errors->has('correoElectronico'))
                                                <span class="material-icons form-control-feedback">clear</span>
                                                <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                                                <small class="text-danger"><strong>{{ $errors->first('correoElectronico') }}</strong></small>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-envelope fa-2x" aria-hidden="true"></i>
                                        </span>
                                        <div class="form-group label-floating{{ $errors->has('email') ? ' has-error' : '' }}">
                                            <label class="control-label" id="emailLabel" for="email">Tu E-mail</label>
                                            <input type="email" id="email" class="form-control validate"
                                                   name="email" value="{{ old('email') }}" required
                                                   aria-describedby="emailLabel">
                                            @if ($errors->has('email'))
                                                <span class="material-icons form-control-feedback">clear</span>
                                                <small class="text-danger">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            @if(isset($edit))
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-lock prefix fa-2x" aria-hidden="true"></i></span>
                                        <div class="form-group label-floating{{ $errors->has('contraseña') ? ' has-error' : '' }}" id="formGroupPass">
                                            <label class="control-label" id="contraseñaLabel" for="contraseña" data-error="Incorrecto">Contraseña</label>
                                            <input type="password" id="contrasena" class="form-control validate" name="contraseña" aria-describedby="contraseñaLabel" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$">
                                            @if ($errors->has('contraseña'))
                                                <span class="material-icons form-control-feedback">clear</span>
                                                <small class="text-danger"><strong>{{ $errors->first('contraseña') }}</strong></small>
                                            @endif
                                        </div>
                                        <small id="contrasenaHelp" class="text-muted"><strong>Tu contraseña debe ser de por lo menos de 8 caracteres, incluyendo mayúsculas y números.</strong></small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-check fa-2x"></i></span>
                                        <div class="form-group label-floating" id="formGroupPassConf">
                                            <label class="control-label" for="contrasena-confirm">Confirmar Contraseña</label>
                                            <input id="contrasena-confirm" type="password" class="form-control validate" name="contraseña_confirmation" aria-describedby="passwordConfirmationLabel">
                                            <small id="passwordConfirmationLabel"></small>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-lock prefix fa-2x" aria-hidden="true"></i>
                                        </span>
                                        <div class="form-group label-floating{{ $errors->has('password') ? ' has-error' : '' }}" id="formGroupPass">
                                            <label class="control-label" id="passwordLabel"
                                                   for="password" data-error="Incorrecto">Tu contraseña</label>
                                            <input type="password" id="password" class="form-control validate"
                                                   name="password" required
                                                   aria-describedby="passwordLabel"
                                                   pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$">
                                            @if ($errors->has('password'))
                                                <span class="material-icons form-control-feedback">clear</span>
                                                {{--<span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>--}}
                                                <small class="text-danger"><strong>{{ $errors->first('password') }}</strong></small>
                                            @endif
                                        </div>
                                        <small id="passwordHelp" class="text-muted">
                                            <strong>Tu contraseña debe ser de por lo menos de 8 caracteres, incluyendo mayúsculas y números.</strong>
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-check fa-2x"></i>
                                        </span>
                                        <div class="form-group label-floating" id="formGroupPassConf">
                                            <label class="control-label" for="password-confirm">Confirmar Contraseña</label>
                                            <input id="password-confirm" type="password" class="form-control validate"
                                                   name="password_confirmation" required
                                                   aria-describedby="passwordConfirmationLabel">
                                            <small id="passwordConfirmationLabel"></small>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-phone fa-2x"></i>
                                    </span>
                                    <div class="form-group label-floating{{ $errors->has('telefono') ? ' has-error' : '' }}">
                                        <label class="control-label" id="telefonoLabel"
                                               for="telefono" data-error="Incorrecto">Telefono</label>
                                        <input id="telefono" type="text" class="form-control validate"
                                               name="telefono" value="{{ $usuario->telefono or old('telefono') }}" required
                                               aria-describedby="telefonoLabel" minlength="7" maxlength="10"
                                               onkeypress="return soloNumeros(event)">
                                        @if ($errors->has('telefono'))
                                            <span class="material-icons form-control-feedback">clear</span>
                                            <small class="text-danger">
                                                <strong>{{ $errors->first('telefono') }}</strong>
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-graduation-cap fa-2x" aria-hidden="true"></i>
                                    </span>
                                    <div class="form-group label-floating{{ $errors->has('idNivelEstudios') ? ' has-error' : '' }}">
                                        <label class="control-label" id="idNivelEstudiosLabel"
                                               for="idNivelEstudios" data-error="Incorrecto">Nivel de Estudios</label>
                                        <select id="idNivelEstudios" class="form-control validate"
                                                name="idNivelEstudios" required aria-describedby="idNivelEstudiosLabel">
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

                    <div class="tab-pane" id="ubicacion">
                        <h4 class="info-text"> Ubicación </h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-map-marker fa-2x"></i></span>
                                    <div class="form-group {{ $errors->has('pais') ? ' has-error' : '' }}">
                                        <label class="control-label" id="paisLabel2" for="pais2" data-error="Incorrecto">País</label>
                                        <select id="pais2" class="form-control validate" name="pais" required aria-describedby="paisLabel2"></select>
                                        @if ($errors->has('pais'))
                                            <span class="material-icons form-control-feedback">clear</span>
                                            <small class="text-danger"><strong>{{ $errors->first('pais') }}</strong></small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-map fa-2x"></i></span>
                                    <div class="form-group {{ $errors->has('departamento') ? ' has-error' : '' }}">
                                        <label class="control-label" id="departamentoLabel" for="departamento2" data-error="Incorrecto">Departamento</label>
                                        <select id="departamento2" class="form-control validate" name="departamento" required aria-describedby="departamentoLabel"></select>
                                        @if ($errors->has('departamento'))
                                            <span class="material-icons form-control-feedback">clear</span>
                                            <small class="text-danger"><strong>{{ $errors->first('departamento') }}</strong></small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-location-arrow fa-2x"></i></span>
                                    <div class="form-group {{ $errors->has('ciudad') ? ' has-error' : '' }}">
                                        <label class="control-label" id="ciudadLabel" for="ciudad2" data-error="Incorrecto">Ciudad</label>
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
                                    <span class="input-group-addon"><i class="fa fa-home fa-2x"></i></span>
                                    <div class="form-group label-floating{{ $errors->has('direccion') ? ' has-error' : '' }}">
                                        <label class="control-label" id="direccionLabel" for="direccion" data-error="Incorrecto">Dirección</label>
                                        <input id="direccion" type="text" class="form-control validate" name="direccion" value="{{ $usuario->direccion->direccion or old('direccion') }}" required  aria-describedby="direccionLabel" maxlength="60" autocomplete="on">
                                        @if ($errors->has('direccion'))
                                            <span class="material-icons form-control-feedback">clear</span>
                                            <small class="text-danger"><strong>{{ $errors->first('direccion') }}</strong></small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-info fa-2x"></i></span>
                                    <div class="form-group label-floating{{ $errors->has('direccionAuxiliar') ? ' has-error' : '' }}">
                                        <label class="control-label" id="direccionAuxLabel" for="direccionAuxiliar" data-error="Incorrecto">Dirección auxiliar: (Apt. Mz.)</label>
                                        <input id="direccionAuxiliar" type="text" class="form-control validate" name="direccionAuxiliar" value="{{ $usuario->direccion->direccionAuxiliar or old('direccionAuxiliar') }}"  aria-describedby="direccionAuxLabel" maxlength="60">
                                        @if ($errors->has('direccionAuxiliar'))
                                            <span class="material-icons form-control-feedback">clear</span>
                                            <small class="text-danger"><strong>{{ $errors->first('direccionAuxiliar') }}</strong></small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-envelope fa-2x"></i></span>
                                    <div class="form-group label-floating{{ $errors->has('codigoPostal') ? ' has-error' : '' }}">
                                        <label class="control-label" id="codigoPostalLabel" for="codigoPostal" data-error="Incorrecto">Codigo Postal</label>
                                        <input id="codigoPostal" type="text" class="form-control validate" name="codigoPostal" value="{{ $usuario->direccion->codigoPostal or old('codigoPostal') }}" required  aria-describedby="codigoPostalLabel" maxlength="10" onkeypress="return soloNumeros(event)">
                                        @if ($errors->has('codigoPostal'))
                                            <span class="material-icons form-control-feedback">clear</span>
                                            <small class="text-danger"><strong>{{ $errors->first('codigoPostal') }}</strong></small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="preferencias">
                        <h4 class="info-text"> Preferencias del Café</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-repeat fa-2x" aria-hidden="true"></i>
                                    </span>
                                    <div class="form-group label-floating{{ $errors->has('idFrecuenciaCompraCafe') ? ' has-error' : '' }}">
                                        <label class="control-label" id="idFrecuenciaCompraCafeLabel"
                                               for="idFrecuenciaCompraCafe" data-error="Incorrecto">Frecuencia en la compra de Café:</label>
                                        <select id="idFrecuenciaCompraCafe" class="form-control validate"
                                                name="idFrecuenciaCompraCafe" required aria-describedby="idFrecuenciaCompraCafeLabel">
                                            <option></option>
                                            @foreach($frecuenciaCompraCafe as $frecuencia)
                                                <option
                                                        value="{{ $frecuencia->id }}"
                                                        {{ (isset($usuario) ? $usuario->frecuenciaCompraCafe->id : old('idFrecuenciaCompraCafe')) == $frecuencia->id ? 'selected' : '' }}>
                                                    {{ $frecuencia->tipo }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('idFrecuenciaCompraCafe'))
                                            <span class="material-icons form-control-feedback">clear</span>
                                            <small class="text-danger"><strong>{{ $errors->first('idFrecuenciaCompraCafe') }}</strong></small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">

                            </div>
                        </div>
                        <?php $i = 0; ?>
                        @forelse($attributes as $attribute)
                            @if($i == 0)
                                <div class="row">
                                    @endif
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-check fa-2x"></i></span>
                                            <div class="form-group label-floating{{ $errors->has("'" . $attribute->nombreAtributo . "'") ? ' has-error' : '' }}">
                                                <label class="control-label" id="{{ $attribute->nombreAtributo }}Label" for="{{ $attribute->nombreAtributo }}" data-error="Incorrecto">{{  ucwords(preg_replace('/(?!^)[A-Z]{2,}(?=[A-Z][a-z])|[A-Z][a-z]|[0-9]{1,}/', ' $0', $attribute->nombreAtributo)) }}</label>
                                                @if(!is_null($attribute->opciones))
                                                    <select id="{{ $attribute->nombreAtributo }}" class="form-control validate" name="{{ $attribute->nombreAtributo }}" aria-describedby="{{ $attribute->nombreAtributo }}Label">
                                                        <option></option>
                                                        @foreach($attribute->opciones as $opcion)
                                                            <option value="{{ $opcion }}" {{(isset($usuario) ? $usuario->atributos[$attribute->id - 1]->pivot->valorAtributo : old($attribute->nombreAtributo)) == $opcion ? 'selected' : '' }}>{!! $opcion !!}</option>
                                                        @endforeach
                                                    </select>
                                                @else
                                                    <input id="{{ $attribute->nombreAtributo }}" type="text" class="form-control validate" name="{{ $attribute->nombreAtributo }}" value="{{ $usuario->atributos[$attribute->id - 1]->pivot->valorAtributo or old($attribute->nombreAtributo) }}" aria-describedby="{{ $attribute->nombreAtributo }}Label" onkeypress="return soloLetras(event)">
                                                @endif
                                                {{--<input id="idTipoCafe" type="text" class="form-control validate" name="id" value="{{ $usuario->id or old("id") }}" required aria-describedby="idLabel" minlength="10" maxlength="10" onkeypress="return soloNumeros(event)">--}}
                                                @if ($errors->has("'" . $attribute->nombreAtributo . "'"))
                                                    <span class="material-icons form-control-feedback">clear</span>
                                                    <small class="text-danger"><strong>{{ $errors->first("'" . $attribute->nombreAtributo . "'") }}</strong></small>
                                                @endif
                                            </div>
                                            <small id="{{ $attribute->nombreAtributo }}Help" class="text-muted"><strong>{!! $attribute->descripcionAtributo !!}</strong></small>
                                        </div>
                                    </div>
                                    @if($i == 1)
                                </div>
                                <?php $i=0; ?>
                            @elseif($i == 0)
                                <?php $i++; ?>
                            @endif
                        @empty
                        @endforelse
                    </div>
                </div>
                <div class="wizard-footer">
                    <div class="row">
                        <div class="pull-right">
                            <input type='button' class='btn btn-next btn-round btn-fill btn-success btn-wd' name='next' value='Seguir' />
                            @if (! empty($edit) and $edit)
                                <input type='submit' class='btn btn-finish btn-round btn-fill btn-success btn-wd' name='finish' value='Actualizar Perfil' />
                                {{--<button class="btn btn-success btn-round pull-center">Editar Producto</button>--}}
                            @else
                                <input type='submit' class='btn btn-finish btn-round btn-fill btn-success btn-wd' name='finish' value='Crear' />
                                {{--<button class="btn btn-success btn-round pull-center">Crear Producto</button>--}}
                            @endif
                            {{--<button class="btn btn-success btn-round pull-center">Crear Producto</button>--}}
                        </div>
                        <div class="pull-left">
                            <input type='button' class='btn btn-previous btn-fill btn-round btn-default btn-wd' name='previous' value='Anterior' />
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="row">
                        <div class="text-center">
                            @if(!isset($edit))
                                <p>O</p>
                                <a class="btn btn-simple btn-info btn-lg" href="{{ route('login') }}">Iniciar Sesión</a>
                            @else
                                <a type="button" href="{{ route('profile::profile') }}" class="btn btn-danger btn-round btn-wd pull-center">Cancelar</a>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
    @parent

    <!--   Core JS Files   -->
    <script src="{{ asset('assets-wizard/js/jquery.bootstrap.js')}}" type="text/javascript"></script>

    <!--  Plugin for the Wizard -->
    <script src="{{ asset('assets-wizard/js/material-bootstrap-wizard.js')}}"></script>

    <!--  More information about jquery.validate here: http://jqueryvalidation.org/	 -->
    <script src="{{ asset('assets-wizard/js/jquery.validate.min.js')}}"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $("#{{ isset($edit) ? 'contrasena' : 'password'}}").on('keyup', function() {
                var pattern = $("#{{ isset($edit) ? 'contrasena' : 'password'}}").val();
                var password_input = $("#{{ isset($edit) ? 'contrasena' : 'password'}}-confirm");
                var group = $("#formGroupPass");

                if(!group.hasClass('is-empty')) {
                    password_input.attr('required', true);
                    password_input.attr('pattern', pattern);
                    password_input.attr('title', "Las contraseñas no coinciden.");
                    validateConfirm(pattern);
                } else {
                    password_input.removeAttr('required');
                    password_input.removeAttr('pattern');
                    password_input.removeAttr('title');
                }
            });

            function validateConfirm(password) {
                var confirmation = $("#{{ isset($edit) ? 'contrasena' : 'password'}}-confirm");
                var label = $("#passwordConfirmationLabel");
                var group = $("#formGroupPassConf");

                if(!group.hasClass('is-empty')) {
                    if(password !== confirmation.val()) {
                        confirmation.addClass('invalid');
                        group.removeClass('has-success');
                        group.addClass('has-error');
                        label.removeClass("text-success");
                        label.addClass("text-danger");
                        label.html("<strong>No coinciden</strong>");
                    } else {
                        confirmation.removeClass('invalid');
                        confirmation.addClass('valid');
                        group.removeClass('has-error');
                        group.addClass('has-success');
                        label.removeClass("text-danger");
                        label.addClass("text-success");
                        label.html("<strong>Coinciden</strong>");
                    }
                }
            }

            $("#{{ isset($edit) ? 'contrasena' : 'password'}}-confirm").blur(function (e) {
//                var password = $(this).val();
                var label = $("#passwordConfirmationLabel");
                var passwordGroup = $("#formGroupPassConf");
                //console.log(password);
                //console.log($("#password").val());
                if($(this).is(":valid")) {
                    passwordGroup.addClass('has-success');
                    label.addClass("text-success");
                    label.html("<strong>Coinciden</strong>");
                }
                else {
                    passwordGroup.removeClass('has-success');
                    label.removeClass("text-success");
                    label.addClass("text-danger");
                    label.html("<strong>No coinciden</strong>");
                }
            });
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
                    if('{{$usuario->direccion->pais or old('pais')}}' === data[i]) {
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
                    departamento.append("<option value='' selected> Selecciona tu departamento...</option>");
                    for(i=1; i<=count;  i++) {
                        if('{{$usuario->direccion->departamento or old('departamento')}}' === data[i]) {
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
                ciudad.append("<option value='' selected> Primero selecciona tu departamento...</option>");
            } else {
                $.get("{{url('cities')}}/" + departamento, function (data, status) {
                    var count = Object.keys(data).length;
                    ciudad.empty();
                    ciudad.append("<option value='' selected> Selecciona tu ciudad...</option>");
                    for(i=1; i<=count;  i++) {
                        if('{{$usuario->direccion->ciudad or old('ciudad')}}' === data[i]) {
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