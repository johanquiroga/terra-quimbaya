@extends('home')

@section('page', 'signup-page')

@section('styles')
    @parent
    <link href="{{asset('custom-assets/custom_material-kit.css')}}" rel="stylesheet"/>
@endsection

@section('main_content')
    <div class="header header-filter" style="background-image: url('{{asset("assets-dashboard/img/sidebar-5.jpg")}}'); background-size: cover; background-position: top center;">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 col-sm-6 col-sm-offset-3">
                    <div class="card card-signup">
                        <form role="form" method="POST" action="{{ url('/password/reset') }}">
                            <div class="header header-primary text-center">
                                <h4><i class="material-icons">lock</i> Iniciar Sesión</h4>
                            </div>
                            <div class="content">
                                {{ csrf_field() }}

                                <input type="hidden" name="token" value="{{ $token }}">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-envelope fa-2x" aria-hidden="true"></i>
                                                </span>
                                            <div class="form-group label-floating{{ $errors->has('email') ? ' has-error' : '' }}">
                                                <label class="control-label" id="emailLabel" for="email">Tu E-mail</label>
                                                <input type="email" id="email" class="form-control validate"
                                                       name="email" value="{{ old('email') }}" required
                                                       aria-describedby="emailLabel">
                                                @if ($errors->has('email'))
                                                    <span class="material-icons form-control-feedback">clear</span>
                                                    <small class="text-danger">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-lock prefix fa-2x" aria-hidden="true"></i>
                                                </span>
                                            <div class="form-group label-floating{{ $errors->has('password') ? ' has-error' : '' }}" id="formGroupPass">
                                                <label class="control-label" id="passwordLabel"
                                                       for="password" data-error="Incorrecto">Tu contraseña</label>
                                                <input type="password" id="password" class="form-control validate"
                                                       name="password" required
                                                       aria-describedby="passwordLabel"
                                                       pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$">
                                                @if ($errors->has('password'))
                                                    <span class="material-icons form-control-feedback">clear</span>
                                                    {{--<span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>--}}
                                                    <small class="text-danger"><strong>{{ $errors->first('password') }}</strong></small>
                                                @endif
                                            </div>
                                            <small id="passwordHelp" class="text-muted">
                                                <strong>Tu contraseña debe ser de por lo menos de 8 caracteres, incluyendo mayúsculas y números.</strong>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-check fa-2x"></i>
                                                </span>
                                            <div class="form-group label-floating" id="formGroupPassConf">
                                                <label class="control-label" for="password-confirm">Confirmar Contraseña</label>
                                                <input id="password-confirm" type="password" class="form-control validate"
                                                       name="password_confirmation" required
                                                       aria-describedby="passwordConfirmationLabel">
                                                <small id="passwordConfirmationLabel"></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="footer text-center">
                                {{--<button type="button" class="btn btn-simple btn-primary btn-lg">Iniciar Sesión</button>--}}
                                <button class="btn btn-simple btn-primary btn-lg">Restablecer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    @parent
    <script type="text/javascript">
        $(document).ready(function () {
            $("#password").on('keyup', function() {
                var pattern = $("#password").val();
                var password_input = $("#password-confirm");
                var group = $("#formGroupPass");

                if(!group.hasClass('is-empty')) {
                    password_input.attr('required', true);
                    password_input.attr('pattern', pattern);
                    password_input.attr('title', "Las contraseñas no coinciden.");
                    validateConfirm(pattern);
                } else {
                    password_input.removeAttr('required');
                    password_input.removeAttr('pattern');
                    password_input.removeAttr('title');
                }
            });

            function validateConfirm(password) {
                var confirmation = $("#password-confirm");
                var label = $("#passwordConfirmationLabel");
                var group = $("#formGroupPassConf");

                if(!group.hasClass('is-empty')) {
                    if(password !== confirmation.val()) {
                        confirmation.addClass('invalid');
                        group.removeClass('has-success');
                        group.addClass('has-error');
                        label.removeClass("text-success");
                        label.addClass("text-danger");
                        label.html("<strong>No coinciden</strong>");
                    } else {
                        confirmation.removeClass('invalid');
                        confirmation.addClass('valid');
                        group.removeClass('has-error');
                        group.addClass('has-success');
                        label.removeClass("text-danger");
                        label.addClass("text-success");
                        label.html("<strong>Coinciden</strong>");
                    }
                }
            }

            $("#password-confirm").blur(function (e) {
//                var password = $(this).val();
                var label = $("#passwordConfirmationLabel");
                var passwordGroup = $("#formGroupPassConf");
                //console.log(password);
                //console.log($("#password").val());
                if($(this).is(":valid")) {
                    passwordGroup.addClass('has-success');
                    label.addClass("text-success");
                    label.html("<strong>Coinciden</strong>");
                }
                else {
                    passwordGroup.removeClass('has-success');
                    label.removeClass("text-success");
                    label.addClass("text-danger");
                    label.html("<strong>No coinciden</strong>");
                }
            });
        });
    </script>
@endsection