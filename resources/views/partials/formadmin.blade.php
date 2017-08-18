<div class="row">
    <div class="col-md-6">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-id-card fa-2x" aria-hidden="true"></i></span>
            <div class="form-group label-floating{{ $errors->has('id') ? ' has-error' : '' }}">
                <label class="control-label" id="idLabel" for="id" data-error="Incorrecto">Cédula Ciudadanía</label>
                <input id="id" type="text" class="form-control validate" name="id" value="{{ $usuario->id or old("id") }}" required aria-describedby="idLabel" minlength="8" maxlength="10" onkeypress="return soloNumeros(event)">
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
            <span class="input-group-addon"><i class="fa fa-user fa-2x"></i></span>
            <div class="form-group label-floating{{ $errors->has('nombres') ? ' has-error' : '' }}">
                <label class="control-label" id="nombresLabel" for="nombres" data-error="Incorrecto">Nombre</label>
                <input id="nombres" type="text" class="form-control validate" name="nombres" value="{{ $usuario->nombres or old("nombres") }}" required  aria-describedby="nombresLabel" maxlength="45" onkeypress="return soloLetras(event)">
                @if ($errors->has('nombres'))
                    <span class="material-icons form-control-feedback">clear</span>
                    <small class="text-danger"><strong>{{ $errors->first('nombres') }}</strong></small>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-user fa-2x"></i></span>
            <div class="form-group label-floating{{ $errors->has('apellidos') ? ' has-error' : '' }}">
                <label class="control-label" id="apellidosLabel" for="apellidos" data-error="Incorrecto">Apellido</label>
                <input id="apellidos" type="text" class="form-control validate" name="apellidos" value="{{ $usuario->apellidos or old("apellidos") }}" required  aria-describedby="apellidosLabel" maxlength="45" onkeypress="return soloLetras(event)">
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
            <span class="input-group-addon"><i class="fa fa-envelope fa-2x" aria-hidden="true"></i></span>
            <div class="form-group label-floating{{ $errors->has('correoElectronico') ? ' has-error' : '' }}">
                <label class="control-label" id="emailLabel" for="email">E-mail</label>
                <input type="email" id="email" class="form-control validate" name="correoElectronico" value="{{ $usuario->correoElectronico or old("correoElectronico") }}" required  aria-describedby="emailLabel">
                @if ($errors->has('correoElectronico'))
                    <span class="material-icons form-control-feedback">clear</span>
                    {{--<span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>--}}
                    <small class="text-danger"><strong>{{ $errors->first('correoElectronico') }}</strong></small>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-lock prefix fa-2x" aria-hidden="true"></i></span>
            <div class="form-group label-floating{{ $errors->has('contraseña') ? ' has-error' : '' }}" id="formGroupPass">
                <label class="control-label" id="passwordLabel" for="password" data-error="Incorrecto">Contraseña</label>
                <input type="password" id="password" class="form-control validate" name="contraseña" {{ isset($edit) ? '' : 'required' }} aria-describedby="passwordLabel" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$">
                @if ($errors->has('contraseña'))
                    <span class="material-icons form-control-feedback">clear</span>
                    {{--<span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>--}}
                    <small class="text-danger"><strong>{{ $errors->first('contraseña') }}</strong></small>
                @endif
            </div>
            <small id="passwordHelp" class="text-muted"><strong>Tu contraseña debe ser de por lo menos de 8 caracteres, incluyendo mayúsculas y números.</strong></small>
        </div>
    </div>
    @if(isset($edit))
    <div class="col-md-6">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-check fa-2x"></i></span>
            <div class="form-group label-floating" id="formGroupPassConf">
                <label class="control-label" for="contraseña-confirmation">Confirmar Contraseña</label>
                <input id="password-confirm" type="password" class="form-control validate" name="contraseña_confirmation" aria-describedby="passwordConfirmationLabel">
                <small id="passwordConfirmationLabel"></small>
            </div>
        </div>
    </div>
    @endif
</div>
<div class="row">
    <div class="col-md-6">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-phone fa-2x"></i></span>
            <div class="form-group label-floating{{ $errors->has('telefono') ? ' has-error' : '' }}">
                <label class="control-label" id="telefonoLabel" for="telefono" data-error="Incorrecto">Telefono</label>
                <input id="telefono" type="text" class="form-control validate" name="telefono" value="{{ $usuario->telefono or old("telefono") }}" required  aria-describedby="telefonoLabel" minlength="7" maxlength="10" onkeypress="return soloNumeros(event)">
                @if ($errors->has('telefono'))
                    <span class="material-icons form-control-feedback">clear</span>
                    <small class="text-danger"><strong>{{ $errors->first('telefono') }}</strong></small>
                @endif
            </div>
        </div>
    </div>
</div>
@if(isset($edit))
    @if(isset($estado) && $estado == 0)
        <div class="row">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-question fa-2x"></i></span>
                    <div class="form-group label-floating{{ $errors->has('estado') ? ' has-error' : '' }}">
                        <label class="control-label" id="estadoLabel" for="estado" data-error="Incorrecto">Estado de la publicación</label>
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

@if(isset($edit))
    @if(isset($profile))
        <div class="footer text-center">
            {{--<button type="button" class="btn btn-simple btn-primary btn-lg">Iniciar Sesión</button>--}}
            <button class="btn btn-round btn-success">Actualizar perfil</button>
        </div>
        <div class="clearfix"></div>
    @else
        <div align="center">
            <div class="form-group">
                <button class="btn btn-success btn-round pull-center">Actualizar</button>
                <a type="button" href="{{ route($type.'::index') }}" class="btn btn-danger btn-round pull-center">Cancelar</a>
            </div>
        </div>
        <div class="clearfix"></div>
    @endif
@else
    <div align="center">
        <div class="form-group">
            <button class="btn btn-success btn-round pull-center">Crear Usuario</button>
            <a type="button" href="{{ route($type.'::index') }}" class="btn btn-danger btn-round btn-wd pull-center">Cancelar</a>
        </div>
    </div>
    <div class="clearfix"></div>
@endif