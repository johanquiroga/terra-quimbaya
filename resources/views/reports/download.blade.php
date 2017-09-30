@extends('home')

@section('page', 'signup-page')

@section('styles')
    @parent
    <!-- CSS Files -->
    <link href="{{asset('css/custom/custom_material-kit.css')}}" rel="stylesheet"/>
@endsection

@section('main_content')
    <div class="header header-filter" style="background-image: url('{{asset("img/ImagenesTerra/DSCN7055.JPG")}}'); background-size: cover; background-position: top center;">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 col-sm-6 col-sm-offset-3">
                    <div class="card card-signup"><!--Header-->
                        <div class="header header-primary text-center">
                            <h4><i class="fa fa-file-pdf-o"></i> Informe Generado</h4>
                        </div>
                        <div class="content">
                            <div class="row center">
                                <h3>El Informe se ha generado Correctamente.</h3>
                            </div>
                            <div class="row center">
                                {{--<a class="btn btn-simple btn-success btn-lg" href="{{ route('report::download', $report->id) }}">Descargar Informe</a>--}}
                                <a class="btn btn-simple btn-success btn-lg" href="{{ route('storage::download', ["reports/$report->id"."_".str_replace([":","-"," "],["","_","_"], $report->fechaGeneracion).".pdf", "true"]) }}">Descargar Informe</a>
                                <p>O</p>
                                <a class="btn btn-simple btn-info btn-lg" href="{{ route('report::index') }}">Finalizar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
