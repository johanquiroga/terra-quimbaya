@extends('home')

@section('page', 'signup-page')

@section('styles')
    @parent
    {{--<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />--}}
    <link href="{{asset('css/custom/custom_material-kit.css')}}" rel="stylesheet"/>
@endsection

@section('main_content')
    <div class="header header-filter" style="background-image: url('{{asset("img/ImagenesTerra/DSCN7055.JPG")}}'); background-size: cover; background-position: top center;">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 col-sm-6 col-sm-offset-3">
                    <div class="card card-signup"><!--Header-->
                        <div class="header header-primary text-center">
                            <h4><i class="fa fa-user-circle"></i> Registrarse</h4>
                        </div>
                        <div class="content">
                            @include('partials.formcomprador')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent

    @include('partials.scriptSoloNumeros')
    @include('partials.scriptSoloLetras')

@endsection
