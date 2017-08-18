{{--@section('columnsNames')--}}
    <th>Cédula Ciudadanía</th>
    <th>Nombres</th>
    <th>Apellidos</th>
    <th>Email</th>
    <th>Teléfono</th>
    @can('destroy', \App\Models\Administrador::class)
    <th>Estado</th>
    @endcan
    <th class="dt-center">Acciones</th>
    {{--<th class="dt-center">Eliminar</th>--}}
{{--@endsection--}}

{{--@section('script_dataTable')--}}
@section('scripts')
    @parent
    <script>
        $(function() {
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin::search') }}',
                columns: [
                    //                ['id', 'nombres', 'apellidos', 'correoElectronico', 'contraseña', 'telefono', 'estado']
                    { data: 'id', name: 'id' },
                    { data: 'nombres', name: 'nombres' },
                    { data: 'apellidos', name: 'apellidos' },
                    { data: 'correoElectronico', name: 'correoElectronico' },
                    { data: 'telefono', name: 'telefono'},
                    @can('destroy', \App\Models\Administrador::class)
                    {
                        data: null,
                        name: 'estado',
                        className: "dt-center",
                        render: function (data) {
                            if(data.estado) {
                                return '<span class="label label-success">Activo</span>';
                            } else {
                                return '<span class="label label-danger">Inactivo</span>';
                            }
                        }
                    },
                    @endcan
                    {
                        name: 'actions',
                        data: null,
                        sortable: false,
                        searchable: false,
                        "className": "dt-center",
                        render: function (data) {
                            var actions = '';
                            if( data.id !== '{{ $user->id }}') {
                                actions += '<a class="btn btn-primary btn-simple btn-xs" title="Modificar usuario" href="{{ route('admin::edit','ID') }}"><i class="material-icons">edit</i></a>';
                            }
                            if(data.estado) {
                                @can('destroy', \App\Models\Administrador::class)
                                    actions += '<button data-toggle="modal" data-target="#delete" data-id="ID" rel="tooltip" title="Eliminar usuario" class="btn btn-danger btn-simple btn-xs" data-original-title="Eliminar usuario">' +
                                    '<i class="material-icons">close</i>'+
                                    '</button>';
                                @endcan
                            }
                            return actions.replace(/ID/g, data.id);
                        }
                    },
//                    {
//                        name: 'actions',
//                        data: null,
//                        sortable: false,
//                        searchable: false,
//                        "className": "dt-center",
//                        render: function (data) {
//                            var actions = '';
//                            actions += '<button type="button" rel="tooltip" title="" class="btn btn-danger btn-simple btn-xs" data-original-title="Eliminar usuario">' +
//                                        '<i class="material-icons">close</i>'+
//                                        '</button>';
////                            actions += '\
////                                <div class="checkbox">\
////                                    <label>\
////                                        <input type="checkbox" name="optionsCheckboxes">\
////                                        <span class="checkbox-material"><span class="check"></span></span>\
////                                    </label>\
////                                </div>';
//                            return actions.replace(/:id/g, data.id);
//                        }
//                    }
                ],
                "oLanguage": {
                    "sLengthMenu": '_MENU_',
                    "sSearch": ''}
            });

            $(".dataTables_filter input").addClass("form-control").attr("placeholder", "Buscar");
            $(".dataTables_length select").addClass("form-control");

        });
    </script>
@endsection