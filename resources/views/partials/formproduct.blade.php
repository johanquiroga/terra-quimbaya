<div class="row">
    <div class="col-md-6">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-user fa-2x"></i></span>
            <div class="form-group label-floating{{ $errors->has('idProveedor') ? ' has-error' : '' }}">
                <label class="control-label" id="idProveedorLabel" for="idProveedor" data-error="Incorrecto">Selecciona el proveedor...</label>
                <select id="idProveedor" class="form-control validate" name="idProveedor" required aria-describedby="idProveedorLabel" {{ isset($edit) ? 'readonly' : '' }}>
                    <option></option>
                    @foreach($providers as $provider)
                        <option value="{{ $provider->id }}" {{ (isset($producto) ? $producto->idProveedor : old('idProveedor')) == $provider->id ? 'selected' : '' }}>{{ $provider->nombres }} {{ $provider->apellidos }}</option>
                    @endforeach
                </select>
                {{--<input id="idProveedor" type="text" class="form-control validate" name="id" value="{{ $usuario->id or old("id") }}" required aria-describedby="idLabel" minlength="10" maxlength="10" onkeypress="return soloNumeros(event)">--}}
                @if ($errors->has('idProveedor'))
                    <span class="material-icons form-control-feedback">clear</span>
                    <small class="text-danger"><strong>{{ $errors->first('idProveedor') }}</strong></small>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-coffee fa-2x"></i></span>
            <div class="form-group label-floating{{ $errors->has('idVariedadCafe') ? ' has-error' : '' }}">
                <label class="control-label" id="idVariedadCafeLabel" for="idVariedadCafe" data-error="Incorrecto">Variedad de Café</label>
                <select id="idVariedadCafe" class="form-control validate" name="idVariedadCafe" required aria-describedby="idVariedadCafeLabel">
                    <option></option>
                    @foreach($tipos_cafe as $tipo)
                        <option value="{{ $tipo->id }}" {{ (isset($producto) ? $producto->idVariedadCafe : old('idVariedadCafe')) == $tipo->id ? 'selected' : '' }}>{{ studly_case(strtolower($tipo->tipo)) }}</option>
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
            <span class="input-group-addon"><i class="fa fa-info fa-2x"></i></span>
            <div class="form-group label-floating{{ $errors->has('nombre') ? ' has-error' : '' }}">
                <label class="control-label" id="nombreLabel" for="nombre" data-error="Incorrecto">Nombre del Producto</label>
                <input id="nombre" type="text" class="form-control validate" name="nombre" value="{{ $producto->nombre or old("nombre") }}" required  aria-describedby="nombreLabel" maxlength="45" onkeypress="return soloLetras(event)">
                @if ($errors->has('nombre'))
                    <span class="material-icons form-control-feedback">clear</span>
                    <small class="text-danger"><strong>{{ $errors->first('nombre') }}</strong></small>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-user fa-2x"></i></span>
            <div class="form-group label-floating{{ $errors->has('descripcion') ? ' has-error' : '' }}">
                <label class="control-label" id="descripcionLabel" for="descripcion" data-error="Incorrecto">Descripcion del producto</label>
                <textarea id="descripcion" type="text" class="form-control validate" name="descripcion" rows="3" required aria-describedby="descripcionLabel" maxlength="255">{{ $producto->descripcion or old("descripcion") }}</textarea>
                @if ($errors->has('descripcion'))
                    <span class="material-icons form-control-feedback">clear</span>
                    <small class="text-danger"><strong>{{ $errors->first('descripcion') }}</strong></small>
                @endif
            </div>
        </div>
    </div>
</div>
{{--<div class="row">--}}
    <h3 class="info-title">Condiciones del Café</h3>
    {{--<div class="col-md-6">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-check-square-o fa-2x"></i></span>
            <div class="form-group label-floating{{ $errors->has('condicionesCafe') ? ' has-error' : '' }}">
                <label class="control-label" id="condicionesCafeLabel" for="condicionesCafe" data-error="Incorrecto">Condiciones del Café</label>
                <input id="condicionesCafe" type="text" class="form-control validate" name="condicionesCafe" value="{{ $producto->condicionesCafe or old("condicionesCafe") }}" required aria-describedby="condicionesCafeLabel" onkeypress="return soloLetras(event)">
                --}}{{--<input id="idTipoCafe" type="text" class="form-control validate" name="id" value="{{ $usuario->id or old("id") }}" required aria-describedby="idLabel" minlength="10" maxlength="10" onkeypress="return soloNumeros(event)">--}}{{--
                @if ($errors->has('condicionesCafe'))
                    <span class="material-icons form-control-feedback">clear</span>
                    <small class="text-danger"><strong>{{ $errors->first('condicionesCafe') }}</strong></small>
                @endif
            </div>
            --}}{{--<small id="cantidadHelp" class="text-muted"><strong>La cantidad de empaques disponibles.</strong></small>--}}{{--
        </div>
    </div>--}}
{{--</div>--}}
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
                                <option value="{{ $opcion }}" {{(isset($producto) ? $producto->atributos[$attribute->id - 1]->pivot->valorAtributo : old($attribute->nombreAtributo)) == $opcion ? 'selected' : '' }}>{!! $opcion !!}</option>
                            @endforeach
                        </select>
                    @else
                        <input id="{{ $attribute->nombreAtributo }}" type="text" class="form-control validate" name="{{ $attribute->nombreAtributo }}" value="{{ $producto->atributos[$attribute->id - 1]->pivot->valorAtributo or old($attribute->nombreAtributo) }}" aria-describedby="{{ $attribute->nombreAtributo }}Label" onkeypress="return soloLetras(event)">
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
<div class="row">
    <div class="col-md-6">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-calculator fa-2x"></i></span>
            <div class="form-group label-floating{{ $errors->has('cantidad') ? ' has-error' : '' }}">
                <label class="control-label" id="cantidadLabel" for="cantidad" data-error="Incorrecto">Cantidad del producto</label>
                <input id="cantidad" type="number" class="form-control validate" name="cantidad" value="{{ $producto->cantidad or old("cantidad") }}" required aria-describedby="cantidadLabel" min="0" onkeypress="return soloNumeros(event)">
                {{--<input id="idTipoCafe" type="text" class="form-control validate" name="id" value="{{ $usuario->id or old("id") }}" required aria-describedby="idLabel" minlength="10" maxlength="10" onkeypress="return soloNumeros(event)">--}}
                @if ($errors->has('cantidad'))
                    <span class="material-icons form-control-feedback">clear</span>
                    <small class="text-danger"><strong>{{ $errors->first('cantidad') }}</strong></small>
                @endif
            </div>
            <small id="cantidadHelp" class="text-muted"><strong>La cantidad de empaques disponibles.</strong></small>
        </div>
    </div>
    <div class="col-md-6">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-dollar fa-2x"></i></span>
            <div class="form-group label-floating{{ $errors->has('precioEmpaque') ? ' has-error' : '' }}">
                <label class="control-label" id="precioEmpaqueLabel" for="precioEmpaque" data-error="Incorrecto">Precio por empaque</label>
                <input id="precioEmpaque" type="number" class="form-control validate" name="precioEmpaque" value="{{ $producto->precioEmpaque or old("precioEmpaque") }}" required aria-describedby="precioEmpaqueLabel" min="0" onkeypress="return soloNumeros(event)">
                {{--<input id="idTipoCafe" type="text" class="form-control validate" name="id" value="{{ $usuario->id or old("id") }}" required aria-describedby="idLabel" minlength="10" maxlength="10" onkeypress="return soloNumeros(event)">--}}
                @if ($errors->has('precioEmpaque'))
                    <span class="material-icons form-control-feedback">clear</span>
                    <small class="text-danger"><strong>{{ $errors->first('precioEmpaque') }}</strong></small>
                @endif
            </div>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-md-6">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-file-photo-o fa-2x"></i></span>
            <div class="form-group label-floating{{ $errors->has('fotos') ? ' has-error' : '' }}">
                <label class="control-label" id="fotosLabel" for="nombresFotos" data-error="Incorrecto">Fotos del producto</label>
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
                    <label class="control-label" id="estadoLabel" for="estado" data-error="Incorrecto">Estado de la publicación</label>
                    <select id="estado" class="form-control validate" name="estado" required aria-describedby="estadoLabel">
                        <option></option>
                        <option value="0" {{ (isset($producto) ? $producto->estado : old('estado')) == "0" ? 'selected' : '' }}>Inactiva</option>
                        <option value="1" {{ (isset($producto) ? $producto->estado : old('estado')) == "1" ? 'selected' : '' }}>Activa</option>
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
    <div align="center">
        <div class="form-group">
            <button class="btn btn-success btn-round pull-center">Actualizar</button>
            <a type="button" href="{{ route($type.'::index') }}" class="btn btn-danger btn-round pull-center">Cancelar</a>
        </div>
    </div>
    <div class="clearfix"></div>
@else
    <div align="center">
        <div class="form-group">
            <button class="btn btn-success btn-round pull-center">Crear Producto</button>
            <a type="button" href="{{ route($type.'::index') }}" class="btn btn-danger btn-round pull-center">Cancelar</a>
        </div>
    </div>
    <div class="clearfix"></div>
@endif

@section('scripts')
    @parent
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>--}}
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.4/js/standalone/selectize.min.js"></script>--}}
    {{--<script type="text/javascript">--}}
        {{--$(document).ready(function () {--}}
            {{--$("#idTipoCafe").select2({--}}
                {{--theme: "bootstrap",--}}
                {{--tags: true,--}}
                {{--placeholder: 'Selecciona un tipo de café...',--}}
                {{--allowClear: true--}}
            {{--});--}}
            {{--//$.material.init();--}}
{{--//            $("#idTipoCafe").selectize({--}}
{{--//                allowEmptyOption: true,--}}
{{--//            });--}}
        {{--});--}}
    {{--</script>--}}
@endsection