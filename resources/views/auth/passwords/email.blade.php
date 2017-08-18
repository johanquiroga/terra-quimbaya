@extends('home')

@section('page', 'signup-page')

{{--@section('header')--}}
    {{--@include('headers.home')--}}
{{--@endsection--}}

@section('styles')
    @parent
    <link href="{{asset('custom-assets/custom_material-kit.css')}}" rel="stylesheet"/>
@endsection

@section('main_content')
    <div class="header header-filter" style="background-image: url('{{asset("assets-dashboard/img/sidebar-5.jpg")}}'); background-size: cover; background-position: top center;">
    <div class="container">
        <br>
        <div class="row">
            <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
                <div class="card card-signup">
                    <!--Body-->
                    <form role="form" method="POST" action="{{ url('/password/email') }}">
                        {{ csrf_field() }}
                        <!--Header-->
                        <div class="header header-primary text-center">
                            <h4><i class="fa fa-key"></i> Restablecer Contraseña</h4>
                        </div>
                        <div class="content">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope fa-2x" aria-hidden="true"></i></span>
                                <div class="form-group label-floating{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label class="control-label" id="emailLabel" for="email">Tu E-mail</label>
                                    <input type="email" id="email" class="form-control validate" name="email" value="{{ old('email') }}" required aria-describedby="emailLabel">
                                    @if ($errors->has('email'))
                                        <span class="material-icons form-control-feedback">clear</span>
                                        <small class="text-danger"><strong>{{ $errors->first('email') }}</strong></small>
                                    @endif
                                </div>
                            </div>
                            {{--<div class="input-group{{ $errors->has('email') ? ' has-error' : '' }}">--}}
                                {{--<span class="input-group-addon"><i class="fa fa-envelope fa-2x" aria-hidden="true"></i></span>--}}
                                {{--<label class="control-label" id="emailLabel" for="email">Tu E-mail</label>--}}
                                {{--<input type="email" id="email" class="form-control validate" name="email" value="{{ old('email') }}" required autofocus aria-describedby="emailLabel">--}}
                                {{--<span class="material-input"></span>--}}
                                {{--@if ($errors->has('email'))--}}
                                    {{--<span class="material-icons form-control-feedback">clear</span>--}}
                                    {{--<span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>--}}
                                {{--@endif--}}
                            {{--</div>--}}
                        </div>
                        <div class="footer text-center">
                            <button id="submitBtn" class="btn btn-simple btn-primary btn-lg">Enviar link para restablecer contraseña</button>
                        </div>
                        <!--/Form with header-->
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@stop

@section('scripts')
    @parent
    {{--<script type="text/javascript">--}}
        {{--$(document).ready(function () {--}}
            {{--$("#email").blur(function (e) {--}}
                {{--var email = $(this).val();--}}
                {{--check_username_ajax(email);--}}
            {{--});--}}

            {{--function check_username_ajax(email) {--}}
                {{--$.get('/password/email/' + email, function (data) {--}}
                    {{--//uncomment the line below to inspect the response in js console/firebug etc--}}
                    {{--//console.log(data);--}}
                    {{--if(data) {--}}
                        {{--var label = document.getElementById('emailLabel');--}}
                        {{--if($("#email").is(':valid')) {--}}
                            {{--label.dataset.error = "Email no encontrado";--}}
                            {{--$("#email").removeClass('valid');--}}
                            {{--$("#email").addClass('invalid');--}}
                        {{--}--}}
                        {{--$("#submitBtn").attr('disabled', true);--}}
                    {{--} else {--}}
                        {{--$("#submitBtn").attr('disabled', false);--}}
                    {{--}--}}
                {{--});--}}
            {{--}--}}
        {{--});--}}
    {{--</script>--}}
@stop