@extends('layouts.dashboard')

@include('layouts.' . $board_user . '.sidebar', [
    'menuGestion'.ucfirst($type) => 'active',
])

@section('content')

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-raised">
                        <div class="card-header" data-background-color="green-dark">
                            <h3 class="title">Productos</h3>
                            <div class="text-right">
                                <a class="btn btn-success btn-round" href="{{ route('product::create') }}">
                                    <i class="fa fa-fw fa-plus fa-lg" aria-hidden="true"></i>Añadir producto
                                </a>
                                {{--<button class="btn btn-danger btn-round" data-toggle="modal" data-target="#delete" >--}}
                                    {{--<i class="fa fa-fw fa-trash fa-lg" aria-hidden="true"></i>Eliminar producto--}}
                                {{--</button>--}}
                            </div>
                        </div>
                        <div class="card-content table-responsive">
                            <table class="table table-hover table-responsive" id="products-table" cellspacing="0" width="100%">
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
                        <h3>¿Estas seguro de eliminar el producto?</h3>
                        <input type="text" name="id" id="id" value="" readonly hidden>
                    </div>
                    <div class="modal-footer text-center">
                        <a type="button" class="btn btn-danger btn-simple" data-dismiss="modal">No</a>
                        <button class="btn btn-primary btn-simple">Eliminar</button>
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

                console.log(button);
                $("#delete").find(".modal-body #id").val(id);
            });
        });
    </script>
@endsection