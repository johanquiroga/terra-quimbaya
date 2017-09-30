@extends('dashboard.dashboard')

@include("dashboard.$board_user.sidebar", [
    'menuGestion'.ucfirst($type) => 'active',
])
{{--@include('layouts/form' . $tipo_datos, ['data' => $data])--}}

@section('content')

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header" data-background-color="brown">
                            <h4 class="title">Editar {{($type == 'admin') ? "Administrador" : "Proveedor"}}</h4>
                            <p class="category">Edite los campos los campos que desea actualizar</p>
                        </div>
                        <div class="card-content">
                            @if ( $type != 'provider')
                            <form role="form" action="{{ route($type.'::update', $data->id) }}" method="POST">
                                {!! csrf_field() !!}
                                @if(!(count($errors) > 0))
                                    @include('partials.form' . $type, ['edit' => true,'usuario' => $data, 'estado' => $data->estado])
                                @else
                                    @include('partials.form' . $type, ['edit' => true, 'estado' => $data->estado])
                                @endif
                            </form>
                            @else
                                @if(!(count($errors) > 0))
                                    @include('partials.form' . $type, ['edit' => true,'usuario' => $data, 'estado' => $data->estado])
                                @else
                                    @include('partials.form' . $type, ['edit' => true, 'estado' => $data->estado])
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>

@endsection

@section('scripts')
    @parent

    @include('partials.scriptSoloNumeros')
    @include('partials.scriptSoloLetras')

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