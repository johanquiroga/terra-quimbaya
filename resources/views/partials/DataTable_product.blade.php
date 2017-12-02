{{--@section('columnsNames')--}}
    <th></th>
    <th>Id</th>
    <th>Nombre</th>
    <th>Variedad de Café</th>
    <th>Cantidad</th>
    <th>Precio por Empaque</th>
    <th>Proveedor</th>
    <th>Administrador</th>
    <th>Estado</th>
    <th class="dt-center">Acciones</th>
    {{--<th class="dt-center">Eliminar</th>--}}
{{--@endsection--}}

{{--@section('script_dataTable')--}}
@section('scripts')
    @parent

    <script>
        Number.prototype.formatMoney = function(c, d, t){
            var n = this,
                c = isNaN(c = Math.abs(c)) ? 2 : c,
                d = d == undefined ? "." : d,
                t = t == undefined ? "," : t,
                s = n < 0 ? "-" : "",
                i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
                j = (j = i.length) > 3 ? j % 3 : 0;
            return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
        };

        $(function() {
            function format ( d ) {

                var attributes =
                    '<table class="table table-hover table-responsive no-footer">' +
                    '<tbody>';

                attributes += '<tr role="row"><td><b>Descripción: </b></td><td>' + DOMPurify.sanitize(d.descripcion) + '</td></tr>';
                attributes += '<tr role="row"><td><b>Calificación: </b></td><td>' + d.calificacion + '</td></tr>';
                attributes += '<tr role="row"><td colspan="2" align="center"><b>ATRIBUTOS</b></td></tr>';

                for (var i = 0; i < d.atributos.length; i++) {
                    attributes += '<tr role="row"><td><b>' + d.atributos[i].nombreAtributo.replace(/((?!^)[A-Z]{2,}(?=[A-Z][a-z])|[A-Z][a-z]|[0-9]{1,})/g, ' $1').replace(/^./, function(str){ return str.toUpperCase(); }) + ': </b></td><td>' + (d.atributos[i].valorAtributo ? d.atributos[i].valorAtributo : '') + '</td></tr>';
                }

                attributes +=
                    '</tbody>' +
                    '</table>';

                return attributes;
            }

            var table = $('#products-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('product::search') }}',
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
                        name: 'idPublicacion',
                        data: null,
                        "className": "dt-center",
                        render: function (data) {
                            var actions = '';
                            actions += '<a href="{{ route('product::show','ID') }}">ID<div class="ripple-container"></div></a>';
                            return actions.replace(/ID/g, data.idPublicacion);
                        }
                    },
//                    { data: 'id', name: 'id' },
                    { data: 'nombre', name: 'nombre' },
                    { data: 'variedad_cafe.tipo', name: 'variedadCafe.tipo' },
                    { data: 'cantidad', name: 'cantidad' },
                    {
                        data: 'precioEmpaque',
                        name: 'precioEmpaque',
                        render: function (data) {
                            return '$ ' + Number(data).formatMoney('2', ',', '.');
                        }
                    },
                    { data: 'proveedor.nombres', name: 'proveedor.nombres' },
                    { data: 'admin.nombres', name: 'admin.nombres' },
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
                            actions += '<a class="btn btn-primary btn-simple btn-xs" title="Modificar producto" href="{{ route('product::edit','ID') }}"><i class="material-icons">edit</i></a>';
                            if(data.estado == 1) {
                                actions += '<button data-toggle="modal" data-target="#delete" data-id="ID" rel="tooltip" title="Eliminar producto" class="btn btn-danger btn-simple btn-xs" data-original-title="Eliminar producto">' +
                                    '<i class="material-icons">close</i>'+
                                    '</button>';
                            }
                            return actions.replace(/ID/g, data.idPublicacion);
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
//                            return actions.replace(/:id/g, data.idPublicacion);
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
            $('#products-table tbody').on('click', 'td.details-control', function () {
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