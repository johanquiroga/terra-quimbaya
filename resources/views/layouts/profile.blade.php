@extends('layouts.dashboard')

@include('layouts/' . $type . '/sidebar', [
    'menuPerfil' => 'active',
    ])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" data-background-color="brown">
                    <h4 class="title">Editar Perfil</h4>
                    <p class="category">Completa tu perfil</p>
                    @can('delete-account')
                        <div class="text-right">
                            <button class="btn btn-danger btn-round" data-toggle="modal" data-target="#delete-account" data-id="{{ $user->id }}">
                                <i class="fa fa-fw fa-trash" aria-hidden="true"></i> Eliminar Cuenta
                            </button>
                        </div>
                    @endcan
                </div>
                <div class="card-content">
                    @if( $type == 'comprador')
                        @if(!(count($errors) > 0))
                            @include('partials.form' . $type, ['profile' => true, 'edit' => true, 'usuario' => $user])
                        @else
                            @include('partials.form' . $type, ['profile' => true, 'edit' => true])
                        @endif
                    @else
                    <form role="form" action="{{ route('profile::update', $user->id) }}" method="POST">
                        {!! csrf_field() !!}
                        @if(!(count($errors) > 0))
                            @include('partials.form' . $type, ['profile' => true, 'edit' => true, 'usuario' => $user])
                        @else
                            @include('partials.form' . $type, ['profile' => true, 'edit' => true])
                        @endif
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    @parent

    @can('delete-account')
    <div class="modal fade" id="delete-account" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('profile::destroy') }}">
                {!! csrf_field() !!}
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Confirmar acción</h4>
                    </div>
                    <div class="modal-body text-center">
                        <h3>¿Estas seguro de eliminar tu cuenta?</h3>
                        <input type="text" name="id" id="id" value="" hidden readonly>
                    </div>
                    <div class="modal-footer text-center">
                        <a type="button" class="btn btn-danger btn-simple" data-dismiss="modal">No</a>
                        <button class="btn btn-simple btn-success">Eliminar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endcan

@endsection

@section('scripts')
    @parent

    @include('partials.scriptSoloNumeros')
    @include('partials.scriptSoloLetras')

    <script type="text/javascript">
        $(document).ready(function () {
            $("#delete-account").on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');

                console.log(button);
                $("#delete-account").find(".modal-body #id").val(id);
            });
        });
    </script>

    @if($type != 'comprador')
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
    @endif
@endsection