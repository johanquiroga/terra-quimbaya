@extends('layouts.dashboard')

@include('layouts.' . $board_user . '.sidebar', [
    'menuGestion'.ucfirst($type) => 'active',
])

@section('content')

            <div class="row">

                <div class="col-md-12">
                    <div class="card card-raised">
                        <div class="card-header" data-background-color="green-dark">
                            <h3 class="title">Solicitudes</h3>
                            {{--<div class="text-right">--}}
                                {{--<a class="btn btn-success btn-round" href="{{ route('request::create') }}">--}}
                                    {{--<i class="fa fa-fw fa-plus fa-lg" aria-hidden="true"></i>Añadir producto--}}
                                {{--</a>--}}
                                {{--<button class="btn btn-danger btn-round" data-toggle="modal" data-target="#delete" >--}}
                                    {{--<i class="fa fa-fw fa-trash fa-lg" aria-hidden="true"></i>Eliminar producto--}}
                                {{--</button>--}}
                            {{--</div>--}}
                        </div>
                        <div class="card-content table-responsive">
                            <table class="table table-hover table-responsive" id="requests-table" cellspacing="0" width="100%">
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