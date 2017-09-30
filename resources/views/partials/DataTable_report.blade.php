{{--@section('columnsNames')--}}
    <th>Id</th>
    <th>Fecha de Generación</th>
    <th>Administrador</th>
    <th class="dt-center">Acciones</th>
    {{--<th class="dt-center">Eliminar</th>--}}
{{--@endsection--}}

{{--@section('script_dataTable')--}}
@section('scripts')
    @parent
    <script>
        $(function() {
            $('#report-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('report::search') }}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'fechaGeneracion', name: 'fechaGeneracion' },
                    {
                        data: 'admin',
                        name: 'admin.nombres',
                        render: function(data) {
                            return DOMPurify.sanitize(data.nombres + ' ' + data.apellidos);
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
                            actions += '<a class="btn btn-primary btn-simple btn-xs" title="Descargar informe" href="{{ route('storage::download', ['reports/:ID', 'true']) }}"><i class="material-icons">file_download</i></a>';
                            return actions.replace(/:ID/g, data.id + "_" + data.fechaGeneracion.replace(/ |-/g,"_").replace(/:/g, "") + ".pdf");
                        }
                    },
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