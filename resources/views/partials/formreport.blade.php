@section('styles')
    @parent
    <!-- CSS Files -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" />
@endsection

<div class="row">
    <div class="col-md-offset-2 col-md-4">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-calendar-o fa-2x text-primary"></i></span>
            <div class="form-group label-floating{{ $errors->has('fechaInicio') ? ' has-error' : '' }}">
                <label class="label" id="fechaInicioLabel" for="fechaInicio" data-error="Incorrecto">Fecha de Incio</label>
                <input id="fechaInicio" class="form-control" name="fechaInicio" required type="date" value="{{ old('fechaInicio') ? old('fechaInicio') : $inicio }}">
                @if ($errors->has('fechaInicio'))
                    <span class="material-icons form-control-feedback">clear</span>
                    <small class="text-danger"><strong>{{ $errors->first('fechaInicio') }}</strong></small>
                @endif
                <strong>
                    <small id="fechaInicioHelp" class="text-muted">Especifica una fecha de Inicio para el Informe.
                    </small>
                </strong>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-calendar-o fa-2x text-primary"></i></span>
            <div class="form-group label-floating{{ $errors->has('fechaCierre') ? ' has-error' : '' }}">
                <label class="label" id="fechaCierreLabel" for="fechaCierre" data-error="Incorrecto">Fecha de Cierre</label>
                <input id="fechaCierre" class="form-control" name="fechaCierre" required type="date" value="{{ old('fechaCierre') ? old('fechaCierre') : $final }}">
                @if ($errors->has('fechaCierre'))
                    <span class="material-icons form-control-feedback">clear</span>
                    <small class="text-danger"><strong>{{ $errors->first('fechaCierre') }}</strong></small>
                @endif
                <strong>
                    <small id="fechaCierreHelp" class="text-muted">Especifica una fecha de Cierre para el Informe.
                    </small>
                </strong>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-offset-2 col-md-4">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-user fa-2x text-primary" aria-hidden="true"></i></span>
            <div class="form-group label-floating{{ $errors->has('tipoUsuario') ? ' has-error' : '' }}">
                <label class="control-label" id="tipoUsuarioLabel" for="tipoUsuario2" data-error="Incorrecto">Tipo de Usuario</label>
                <select id="tipoUsuario2" class="form-control validate" name="tipoUsuario" required aria-describedby="tipoUsuarioLabel"></select>
                @if ($errors->has('tipoUsuario'))
                    <span class="material-icons form-control-feedback">clear</span>
                    <small class="text-danger"><strong>{{ $errors->first('tipoUsuario') }}</strong></small>
                @endif
                <strong>
                    <small id="tipoUsuarioHelp" class="text-muted">Especifique el tipo de Usuario.
                    </small>
                </strong>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-users fa-2x text-primary" aria-hidden="true"></i></span>
            <div class="form-group label-floating{{ $errors->has('usuarios') ? ' has-error' : '' }}">
                <label class="label" id="iusuariosLabel" for="usuarios2" data-error="Incorrecto">Usuarios</label>
                <select id="usuarios2" class="form-control validate" name="usuarios[]" required aria-describedby="usuariosLabel" multiple="multiple" >
                    <option></option>
                </select>
                @if ($errors->has('usuarios'))
                    <span class="material-icons form-control-feedback">clear</span>
                    <small class="text-danger"><strong>{{ $errors->first('usuarios') }}</strong></small>
                @endif
                <strong>
                    <small id="usuariosHelp" class="text-muted">Especifique los Usuarios que se incluirán para el Informe.
                    </small>
                </strong>
            </div>
        </div>
    </div>
</div>

<div class="row">

</div>

<div class="row">

</div>

<div align="center">
    <div class="form-group">
        <button value="Preview" name="type" onclick="$('form').attr('target', '_blank');"
                class="btn btn-warning btn-round pull-center">Vista Previa</button>
        <button value="Submit" name="type" onclick="$('form').attr('target', '');"
                class="btn btn-success btn-round pull-center">Generar</button>
        <a type="button" href="{{ route($type.'::index') }}" class="btn btn-danger btn-round pull-center">Cancelar</a>
    </div>
</div>
<div class="clearfix"></div>

@section('scripts')
    @parent

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            var usuarios = $("#usuarios2").select2({
                theme: "bootstrap",
                placeholder: 'Seleccione los Usuarios',
                allowClear: false
            });
            usuarios.empty();
//            usuarios.append("<option value='' selected> Primero selecciona el tipo de usuario...</option>");

            var tipoUsuarioSelect = $("#tipoUsuario2");
            var data = ["Proveedores", "Compradores"];
            tipo(data);
            function tipo(data, status) {
                var count = Object.keys(data).length;
                tipoUsuarioSelect.empty();
                tipoUsuarioSelect.append("<option value=''></option>");
                for (i = 0; i < count; i++) {
                    tipoUsuarioSelect.append("<option value='" + data[i] + "'" + (('{{ old('tipoUsuario') }}' == data[i]) ? 'selected' : '') + "> " + data[i] + "</option>");
                }
                tipoUsuarioSelect.change();
            }

//            $('.datepicker').datepicker();
        });

        $("#tipoUsuario2").change(function(event) {
            var usuarios = $("#usuarios2");
            var tipo = event.target.value;
            if(tipo === "") {
                usuarios.empty();
//                usuarios.append("<option value='' selected> Primero selecciona el tipo de usuario...</option>").change();
            } else {
                if (tipo === "Proveedores")
                    var data = [@foreach ($providers as $provider)["{{$provider->id}}","{{$provider->nombres.' '.$provider->apellidos}}", "{{ in_array("$provider->id", ((old("usuarios.*")) ? old("usuarios.*") : [])) ? 'selected' : '' }}"],@endforeach];
                else if (tipo === "Compradores")
                    var data = [@foreach ($buyers as $buyer)["{{$buyer->id}}","{{$buyer->nombres.' '.$buyer->apellidos}}", "{{ in_array($buyer->id, ((old('usuarios.*')) ? old('usuarios.*') : [])) ? 'selected' : '' }}"],@endforeach];
                console.log(data);
                users(data);
                function users(data, status) {
                    var count = Object.keys(data).length;
                    usuarios.empty();
//                    usuarios.append("<option value='' selected></option>");
                    for(i=0; i<count;  i++) {
                        {{--var old = '{{ old('usuarios') ? old('usuarios'): [] }}';--}}
                        var value = data[i][0];
                        var name = data[i][1];
                        var selected = data[i][2];
                        usuarios.append("<option value='"+value+"' "+selected+"> "+name+"</option>");
                    }
                    usuarios.change();
                }
            }
        });

    </script>

@endsection