@extends('home')

@section('page', 'signup-page')

@section('styles')
    @parent
    <link href="{{asset('custom-assets/custom_material-kit.css')}}" rel="stylesheet"/>
@endsection

    @section('main_content')
    <div class="header header-filter" style="background-image: url('{{asset("img/ImagenesTerra/DSCN7055.JPG")}}'); background-size: cover; background-position: center center;">
    <!--Form with header-->
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
                <div class="card card-signup">
                    <form role="form" method="POST" action="{{ route('login') }}" id="form-login">
                        {{ csrf_field() }}
                        <div class="header header-success text-center">
                            <h4><i class="material-icons">lock</i> Iniciar Sesión</h4>
                        </div>
                        <div class="content">

                            {{--<div class="form-group">--}}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope fa-2x" aria-hidden="true"></i></span>
                                <div class="form-group label-floating{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label class="control-label" id="emailLabel" for="email">Tu E-mail</label>
                                    <input type="email" id="email" class="form-control validate" name="email" value="{{ old('email') }}" required aria-describedby="emailLabel" tabindex="1">
                                    @if ($errors->has('email'))
                                        <span class="material-icons form-control-feedback">clear</span>
                                        {{--<span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>--}}
                                        <small class="text-danger"><strong>{{ $errors->first('email') }}</strong></small>
                                    @endif
                                </div>
                                <small class="text-muted">¿Aún no eres miembro? <a href="{{ route('register') }}">Regístrate ahora</a></small>
                            </div>

                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock prefix fa-2x" aria-hidden="true"></i></span>
                                <div class="form-group label-floating{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label class="control-label" id="passwordLabel" for="password">Tu contraseña</label>
                                    <input type="password" id="password" class="form-control validate" name="password" required aria-describedby="passwordLabel" tabindex="2">
                                    @if ($errors->has('password'))
                                        <span class="material-icons form-control-feedback">clear</span>
                                        {{--<span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>--}}
                                        <small class="text-danger"><strong>{{ $errors->first('password') }}</strong></small>
                                    @endif
                                </div>
                                <small class=text-muted"><a href="{{  url('/password/email') }}">¿Olvidaste tu contraseña?</a></small>
                            </div>

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember" checked tabindex="3">
                                    Recordar mi cuenta
                                </label>
                            </div>

                            <!-- If you want to add a checkbox to this form, uncomment this code

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="optionsCheckboxes" name="remember" checked>
                                    Recordar mi cuenta
                                </label>
                            </div> -->
                        </div>
                        <div class="footer text-center">
                            {{--<button type="button" class="btn btn-simple btn-primary btn-lg">Iniciar Sesión</button>--}}
                            <button id="login-button" class="btn btn-simple btn-primary btn-lg">Iniciar Sesión</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    </div>
    @endsection


{{--<form role="form" method="POST" action="{{ route('login') }}" id="form-login">
    {{ csrf_field() }}
    <div class="md-form form-group{{ $errors->has('email') ? ' has-danger' : '' }} brown-text">
        <i class="fa fa-envelope prefix"></i>
        <input type="email" id="email" class="form-control validate" name="email" value="{{ old('email') }}" required aria-describedby="emailLabel">
        <label id="emailLabel" for="email" data-error="Incorrecto" data-succes="">Tu E-mail</label>
        @if ($errors->has('email'))
            <small id="emailError" class="form-control-feedback animated flash"><strong>{{ $errors->first('email') }}</strong></small>
        @endif
        <small class="form-text text-right text-muted">¿Aún no eres miembro? <a href="{{ route('register') }}">Regístrate ahora</a></small>
    </div>

    <div class="md-form form-group{{ $errors->has('password') ? ' has-danger' : '' }} brown-text">
        <i class="fa fa-lock prefix"></i>
        <input type="password" id="password" class="form-control validate" name="password" required aria-describedby="passwordLabel">
        <label id="passwordLabel" for="password" data-error="" data-success="">Tu contraseña</label>
        @if ($errors->has('password'))
            <div id="passwordError" class="form-control-feedback">{{ $errors->first('password') }}</div>
        @endif
        <small class="form-text text-right text-muted"><a href="{{  url('/password/email') }}">¿Olvidaste tu contraseña?</a></small>
    </div>

    <div class="form-group form-check">
        <label class="form-check-label">
            <input class="form-check-input" type="checkbox" name="remember" id="remember"> Recordar mi cuenta
        </label>
    </div>

    <div class="text-center">
        <button id="login-button" class="btn btn-brown">Iniciar Sesión</button>
    </div>
    <!--/Form with header-->
</form>--}}

@section('scripts')
    @parent
    <!--<script>
        $(document).ready(function() {
           $("#login-button").on('click', function() {
              loginAjax();
           });
        });

        function loginAjax() {
            $.ajax(url);
        }
    </script>-->
@stop