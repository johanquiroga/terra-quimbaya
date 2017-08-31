<th></th>
<th>Id</th>
<th>Tipo de Solicitud</th>
@if($user instanceof App\Models\Administrador)
<th>Comprador</th>
@elseif($user instanceof App\Models\Comprador)
<th>Administrador</th>
@endif
<th>Mensaje</th>
<th>Respuesta</th>
<th>Estado</th>
<th>Fecha de Creación</th>
@can('answerIndex', App\Models\Solicitud::class)
<th class="dt-center">Responder</th>
@endcan
{{--<th class="dt-center">Eliminar</th>--}}

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

                console.log(d);
                var attributes =
                    '<table class="table table-hover table-responsive no-footer">' +
                    '<tbody>';

                @if($user instanceof App\Models\Administrador)
                attributes += '<tr role="row"><td><b>Comprador: </b></td><td><p><strong>Nombre Completo:</strong> ' + d.comprador.nombres + ' ' + d.comprador.apellidos + '</p>'
                    + '<p><strong>Cédula:</strong> ' + d.comprador.id + '</p>'
                    + '<p><strong>Correo Electrónico:</strong> ' + d.comprador.correoElectronico + '</p>'
                    + '<p><strong>Telefono:</strong> ' + d.comprador.telefono + '</p>'
                    + '</td></tr>';

                @elseif($user instanceof App\Models\Comprador)
                    attributes += '<tr role="row"><td><b>Administrador encargado: </b></td><td><p><strong>Nombre Completo:</strong> ' + d.admin.nombres + ' ' + d.admin.apellidos + '</p>'
                    + '<p><strong>Correo Electrónico:</strong> ' + d.admin.correoElectronico + '</p>'
                    + '<p><strong>Telefono:</strong> ' + d.admin.telefono + '</p>'
                    + '</td></tr>';
                @endif

                if(d.requestable_type === 'App\\Models\\Compra' || d.requestable_type === 'App\\Models\\Devolucion') {
                    attributes += '<tr role="row"><td><b>Dirección comprador: </b></td><td>' + "<strong>Pais:</strong> " + d.comprador.direccion.pais + "<p>"
                        + "<p><strong>Departamento:</strong> " + d.comprador.direccion.departamento + "</p>"
                        + "<p><strong>Municipio:</strong> " + d.comprador.direccion.ciudad + "</p>"
                        + "<p><strong>Dirección:</strong> " + d.comprador.direccion.direccion + "</p>"
                        + "<p><strong>Dirección Auxiliar:</strong> " + d.comprador.direccion.direccionAuxiliar + "</p>"
                    '</td></tr>';

                    var compra;
                    if(d.requestable_type === 'App\\Models\\Compra') {
                        compra = d.requestable;
                    } else {
                        compra = d.requestable.compra;
                    }

                    var total = Number(compra.valorTotal);
                    var subtotal = total /(1 + {{ config('app.iva') }});
                    var iva = subtotal * {{ config('app.iva') }};
                    var precioEmpaque = subtotal / compra.cantidad;

                    attributes += '<tr role="row"><td><b>Compra: </b></td><td><p><strong>Referencia:</strong><a href="{{ route("purchase::show", ':PID') }}"> :PID</a></p>'
                        + '<p><strong>Id Producto:</strong><a href="{{ route("product::show", ':ID') }}"> :ID</a></p>'
                        + '<p><strong>Cantidad:</strong> ' + compra.cantidad + '</p>'
                        + '<p><strong>Precio por unidad:</strong> $ ' + precioEmpaque.formatMoney('2', ',', '.') + '</p>'
                        + '<p><strong>Subtotal:</strong> $ ' + subtotal.formatMoney('2', ',', '.') + '</p>'
                        + '<p><strong>IVA:</strong> $ ' + iva.formatMoney('2', ',', '.') + '</p>'
                        + '<p><strong>Total:</strong> $ ' + total.formatMoney('2', ',', '.') + '</p>'
                        + '</td></tr>';
                    attributes = attributes.replace(/:ID/g, compra.product.idPublicacion).replace(/:PID/g, compra.idOrden);
                }

                attributes +=
                    '</tbody>' +
                    '</table>';

                return attributes;
            }

            var table = $('#requests-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('request::search') }}',
                deferRender: true,
                columns: [
                    {
                        "className":      'details-control',
                        "orderable":      false,
                        "searchable":     false,
                        "sortable": false,
                        "data":           null,
                        "defaultContent": ''
                    },
                    { data: 'id', name: 'id' },
                    {
                        data: 'tipo_solicitud.tipo',
                        name: 'tipoSolicitud.tipo',
                        "className": "dt-center",
                        render: function(data,type,set) {
                            var actions = '';
                            if(data === 'pregunta') {
                                actions+= '<a href="{{ route('product::show',':ID') }}"><span class="label label-info">Pregunta</span></a>';
                                actions = actions.replace(/:ID/g, set.requestable.product.idPublicacion);
                            } else if(data === 'devolucion') {
                                actions += '<a href="{{ route('purchase::show',':ID') }}"><span class="label label-warning">Devolución</span></a>';
                                actions = actions.replace(/:ID/g, set.requestable.compra.idOrden);
                            } else if(data === 'compra') {
                                actions+= '<a href="{{ route('purchase::show',':ID') }}"><span class="label label-success">Compra</span></a>';
                                actions = actions.replace(/:ID/g, set.requestable.idOrden);
                            } else {
                                return '<span class="label label-danger>'+ data +'</span>';
                            }
                            return actions;
                        }
                    },
                    @if($user instanceof App\Models\Administrador)
                    {
                        data: 'comprador',
                        name: 'comprador.nombres',
                        render: function(data) {
                            return data.nombres + ' ' + data.apellidos;
                        }
                    },
                    @elseif($user instanceof App\Models\Comprador)
                    {
                        data: 'admin',
                        name: 'admin.nombres',
                        render: function(data) {
                            return data.nombres + ' ' + data.apellidos;
                        }
                    },
                    @endif
                    { data: 'mensaje', name: 'mensaje' },
                    { data: 'respuesta', name: 'respuesta' },
                    { data: 'estado', name: 'estado' },
                    { data: 'created_at', name: 'created_at'},
                    @can('answerIndex', App\Models\Solicitud::class)
                    {
                        name: 'actions',
                        data: null,
                        sortable: false,
                        searchable: false,
                        "className": "dt-center",
                        render: function (data) {
                            var actions = '';
                            actions += '<a class="btn btn-primary btn-simple btn-xs" href="{{ route('request::answer',':ID') }}"><i class="material-icons">open_in_new</i></a>';
                            return actions.replace(/:ID/g, data.id);
                        }
                    }
                    @endcan
                    {{--{--}}
                        {{--name: 'actions',--}}
                        {{--data: null,--}}
                        {{--sortable: false,--}}
                        {{--searchable: false,--}}
                        {{--"className": "dt-center",--}}
                        {{--render: function (data) {--}}
                            {{--var actions = '';--}}
                            {{--actions += '\--}}
                                {{--<div class="checkbox">\--}}
                                    {{--<label>\--}}
                                        {{--<input type="checkbox" name="optionsCheckboxes">\--}}
                                        {{--<span class="checkbox-material"><span class="check"></span></span>\--}}
                                    {{--</label>\--}}
                                {{--</div>';--}}
                            {{--return actions.replace(/:id/g, data.id);--}}
                        {{--}--}}
                    {{--}--}}
                ],
                order: [[1, 'asc']],
                "oLanguage": {
                    "sLengthMenu": '_MENU_',
                    "sSearch": ''},
                "createdRow": function( row, data ) {
                    @if($user instanceof \App\Models\Administrador)
                    if ( !data.leidoAdmin )
                    @else
                    if ( !data.leidoComprador )
                    @endif
                    {
                        $(row).addClass('red');
                    }
                }
            });
            $(".dataTables_filter input").addClass("form-control").attr("placeholder", "Buscar");
            $(".dataTables_length select").addClass("form-control");

            // Listener for detail button
            $('#requests-table tbody').on('click', 'td.details-control', function () {
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