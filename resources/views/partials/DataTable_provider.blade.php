{{--@section('columnsNames')--}}
    <th></th>
    <th>Cédula Ciudadanía</th>
    <th>Nombres</th>
    <th>Apellidos</th>
    <th>Teléfono</th>
    <th>Nombre Finca</th>
    <th>Edad del Proveedor</th>
    <th>Estado</th>
    <th class="dt-center">Acciones</th>
    {{--<th class="dt-center">Eliminar</th>--}}
{{--@endsection--}}

{{--@section('script_dataTable')--}}
@section('scripts')
    @parent
    <script>
        $(function() {
            function format ( d ) {

                var attributes =
                    '<table class="table table-hover table-responsive no-footer">' +
                    '<tbody>';

                attributes += '<tr role="row"><td><b>Ubicación Finca: </b></td><td>' + "<strong>Pais:</strong> " + d.ubicacion_finca.pais + "<p>"
                    + "<p><strong>Departamento:</strong> " + d.ubicacion_finca.departamento + "</p>"
                    + "<p><strong>Municipio:</strong> " + d.ubicacion_finca.ciudad + "</p>"
                    + "<p><strong>Corregimiento:</strong> " + d.ubicacion_finca.corregimiento + "</p>"
                    + "<p><strong>Vereda:</strong> " + d.ubicacion_finca.vereda + "</p>"
                    '</td></tr>';
                attributes += '<tr role="row"><td><b>Altura Finca: </b></td><td>' + d.alturaFinca + ' m.s.n.n</td></tr>';
                attributes += '<tr role="row"><td><b>Extensión Finca: </b></td><td>' + d.extensionFinca + ' ha</td></tr>';
                attributes += '<tr role="row"><td><b>Extensión Lote: </b></td><td>' + d.extensionLotes + ' ha</td></tr>';
                attributes += '<tr role="row"><td><b>Densidad Siembra: </b></td><td>' + d.densidad_siembra.tipo + '</td></tr>';
                attributes += '<tr role="row"><td><b>Años Cafetal: </b></td><td>' + d.añosCafetal + ' años</td></tr>';
                attributes += '<tr role="row"><td><b>Edad Ultima Zoca: </b></td><td>' + d.edad_ultima_zoca.tipo + '</td></tr>';
                attributes += '<tr role="row"><td><b>Variedad de café: </b></td><td>';
                    for (var i in d.variedades_cafe) {
                        attributes += '<p>' + d.variedades_cafe[i].tipo + '</p>';
                    }
                    attributes += '</td></tr>';
                attributes += '<tr role="row"><td><b>Tipo de Beneficio / Beneficiado: </b></td><td>' + d.tipo_beneficio.tipo + '</td></tr>';
                attributes += '<tr role="row"><td><b>Ecotopo: </b></td><td>' + d.ecotopo.tipo + '</td></tr>';
                attributes += '<tr role="row"><td><b>Núcleo Familiar: </b></td><td>' + d.nucleoFamiliar + ' personas</td></tr>';
                attributes += '<tr role="row"><td><b>Nivel Estudios: </b></td><td>' + d.nivel_estudios.tipo + '</td></tr>';
                attributes += '<tr role="row"><td><b>Personas Dependientes: </b></td><td>' + d.personasDependientesFinca + ' personas</td></tr>';

                attributes +=
                    '</tbody>' +
                    '</table>';

                return attributes;
            }

            var table = $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('provider::search') }}',
                columns: [
                    {
                        "className":      'details-control',
                        "orderable":      false,
                        "searchable":     false,
                        "sortable": false,
                        "data":           null,
                        "defaultContent": ''
                    },
                    {
                        name: 'id',
                        data: null,
                        "className": "dt-center",
                        render: function (data) {
                            var actions = '';
                            actions += '<a class="" href="{{ route('provider::show','ID') }}">ID';
                            actions += '<div class="ripple-container"></div></a>';
                            return actions.replace(/ID/g, data.id);
                        }
                    },
                    { data: 'nombres', name: 'nombres' },
                    { data: 'apellidos', name: 'apellidos' },
                    { data: 'telefono', name: 'telefono' },
                    { data: 'nombreFinca', name: 'nombreFinca' },
                    { data: 'edadProveedor', name: 'edadProveedor' },
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
                    {
                        name: 'actions',
                        data: null,
                        sortable: false,
                        searchable: false,
                        "className": "dt-center",
                        render: function (data) {
                            var actions = '';
                            actions += '<a class="btn btn-primary btn-simple btn-xs" href="{{ route('provider::edit','ID') }}"><i class="material-icons">edit</i></a>';
                            if(data.estado) {
                                actions += '<button data-toggle="modal" data-target="#delete" data-id="ID" rel="tooltip" title="Eliminar usuario" class="btn btn-danger btn-simple btn-xs" data-original-title="Eliminar usuario">' +
                                    '<i class="material-icons">close</i>'+
                                    '</button>';
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
//                            actions += '\
//                                <div class="checkbox">\
//                                    <label>\
//                                        <input type="checkbox" name="optionsCheckboxes">\
//                                        <span class="checkbox-material"><span class="check"></span></span>\
//                                    </label>\
//                                </div>';
//                            return actions.replace(/:id/g, data.id);
//                        }
//                    }
                ],
                order: [[1, 'asc']],
                "oLanguage": {
                    "sLengthMenu": '_MENU_',
                    "sSearch": ''}
            });
            $(".dataTables_filter input").addClass("form-control").attr("placeholder", "Buscar");
            $(".dataTables_length select").addClass("form-control");

            // Listener for detail button
            $('#users-table tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row( tr );

                if ( row.child.isShown() ) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    // Open this row
                    row.child( format( row.data() ) ).show();
                    tr.addClass('shown');
                }
            });

        });
    </script>
@endsection