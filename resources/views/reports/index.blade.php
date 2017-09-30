@extends('dashboard.dashboard')

@include("dashboard.$board_user.sidebar", [
    'menuGestion'.ucfirst($type) => 'active',
])

@section('content')

            <div class="row">

                <div class="col-md-12">
                    <div class="card card-raised">
                        <div class="card-header" data-background-color="brown">
                            <h3 class="title">Informes</h3>
                            <div class="text-right">
                                <a class="btn btn-success btn-round" href="{{ route('report::create') }}">
                                    <i class="fa fa-fw fa-plus fa-lg" aria-hidden="true"></i>Generar Informe
                                </a>
                            </div>
                        </div>
                        <div class="card-content table-responsive">
                            <table class="table table-hover table-responsive" id="report-table" cellspacing="0" width="100%">
                                <thead>
                                @include('partials.DataTable_'.$type)
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

@endsection