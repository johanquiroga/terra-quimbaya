@extends('layouts.dashboard')

@include('layouts/' . $board_user . '/sidebar', [
    'menuGestion'.ucfirst($type) => 'active',
])

{{--@include('layouts.DataTable_'.$type)--}}

@section('content')

            <div class="row">

                <div class="col-md-12">
                    <div class="card card-raised">
                        <div class="card-header" data-background-color="green-dark">
                            <h3 class="title">{{ ($type == 'admin') ? "Administradores" : "Proveedores"}}</h3>
                            <div class="text-right">
                                <a class="btn btn-success btn-round" href="{{ route($type.'::create') }}"> {{-- href="{{url('administradores/crearAdministrador')}}"> --}}
                                    <i class="fa fa-fw fa-plus fa-lg" aria-hidden="true"></i>Añadir usuarios
                                </a>
                                {{--<button class="btn btn-danger btn-round" data-toggle="modal" data-target="#delete" >--}}
                                    {{--<i class="fa fa-fw fa-trash fa-lg" aria-hidden="true"></i> Eliminar Usuarios--}}
                                {{--</button>--}}
                            </div>
                        </div>
                        <div class="card-content table-responsive">

                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <table class="table table-hover table-responsive" id="users-table" cellspacing="0" width="100%">
                                <thead>
                                    {{--@yield('columnsNames')--}}
                                    @include('partials.DataTable_'.$type)
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

@endsection

@section('modals')
    @parent

    {{--@can('delete-account')--}}
        <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" action="{{ route($type.'::destroy') }}">
                    {!! csrf_field() !!}
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel">Confirmar acción</h4>
                        </div>
                        <div class="modal-body text-center">
                            <h3>¿Estas seguro de eliminar el usuario?</h3>
                            <input type="text" name="id" id="id" value="" readonly hidden>
                            @if($type == 'admin')
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="n_admin">Administrador delegado</label>
                                            <select id="n_admin" class="form-control validate" name="n_admin" required>
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="modal-footer text-center">
                            <a type="button" class="btn btn-danger btn-simple" data-dismiss="modal">No</a>
                            <button class="btn btn-simple btn-primary">Eliminar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    {{--@endcan--}}

@endsection

@section('scripts')
    @parent
    <script type="text/javascript">
        $(document).ready(function () {
            $("#delete").on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');

                $("#delete").find(".modal-body #id").val(id);

                @if($type == 'admin')
                    var n_admin = $("#delete").find(".modal-body #n_admin");
                    n_admin.empty();
                    n_admin.append("<option value=''></option>");
                    @foreach($admins as $admin)
                        if('{{$admin->id}}' != id) {
                            n_admin.append("<option value=" + '{{ $admin->id }}' + ">{{ $admin->nombres }} {{ $admin->apellidos }}</option>");
                        }
                    @endforeach
                @endif
            });

            $("#delete").on('hide.bs.modal', function () {
                $("#delete").find(".modal-body #id").val();
                @if($type == 'admin')
                    $("#delete").find(".modal-body #n_admin").val('');
                @endif
            });

        });
    </script>
@endsection
    {{--@yield('script_dataTable')--}}
{{--@endsection--}}

{{--@section('modal-content')--}}

    {{--<form id="modificarUsuario" class="form-horizontal" role="form" method="POST">--}}
        {{--<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="editLabel" style="display: none;">--}}
            {{--<div class="modal-dialog">--}}
                {{--<div class="modal-content">--}}
                    {{--<div class="modal-header">--}}
                        {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>--}}
                        {{--<h4 class="modal-title">Modificar Usuario</h4>--}}
                    {{--</div>--}}
                    {{--<div class="modal-body">--}}
                        {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                        {{--@include('modificar_usuario')--}}
                    {{--</div>--}}
                    {{--<div class="modal-footer">--}}
                        {{--<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancelar</button>--}}
                        {{--<button type="button" class="btn btn-sm btn-success">Actualizar</button>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</form>--}}

{{--@endsection--}}


