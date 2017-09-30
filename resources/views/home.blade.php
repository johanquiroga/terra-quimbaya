@extends('app')

@section('styles')
    @parent
    <link href="{{asset('material-dashboard/material-dashboard.css')}}" rel="stylesheet">
    <link href="{{asset('material-kit/material-kit.css')}}" rel="stylesheet">
@endsection

@section('body')

    <!-- Start your project here-->
    <nav class="navbar navbar-fixed-top navbar-primary navbar-transparent navbar-color-on-scroll" role="navigation">
        <div class="container">
            <div class="navbar-header">
                {{--navbar-toggler-right--}}
                <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbarNav1" aria-controls="navbarNav1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ route('home') }}">
                    Your Coffee
                </a>
                {{--<a class="navbar-brand" href="/">--}}
                    {{--<div class="logo">--}}
                        {{--<img class="img-rounded img-responsive img-raised" src="{{ asset('img/logo.JPG') }}" width="60" height="auto" alt="Terra Quimbaya Logo">--}}
                    {{--</div>--}}
                    {{--<strong>Terra Quimbaya</strong>--}}
                {{--</a>--}}
                {{--<a href="/">--}}
                    {{--<div class="logo-container">--}}
                        {{--<div class="logo">--}}
                            {{--<img src="{{ asset('img/logo.JPG') }}" class="img-rounded img-responsive" width="60" height ="60" alt="Terra Quimbaya Logo">--}}
                        {{--</div>--}}
                        {{--<div class="brand">--}}
                            {{--<strong>Terra Quimbaya</strong>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</a>--}}
            </div>
            <div class="collapse navbar-collapse" id="navbarNav1">
                <ul class="nav navbar-nav navbar-right">
                    <form id="search-form" class="navbar-form navbar-left" role="search" method="GET" action="{{ url("/search") }}">
                        <div class="form-group">
                            {{--<select id="searchbox" name="keyword" class="form-control" placeholder="Buscar por productos..." style="width: 240px;"></select>--}}
                            <input type="text" id="searchbox" name="keyword" value="{{ old('nombre') }}" placeholder="Buscar por productos..." style="width: 240px;">
                            {{--<span class="input-group-btn">--}}
                            {{--<button class="btn btn-white btn-round btn-just-icon" type="button"><i class="material-icons">search</i></button>--}}
                            {{--</span>--}}
                            {{--<button class="btn btn-white btn-round btn-just-icon" type="submit"><i class="material-icons">search</i></button>--}}
                        </div>
                    </form>
                    <li><a href="{{ route('home') }}"><i class="fa fa-fw fa-home"></i>Inicio</a></li>
                    @if(!$checked)
                        <li><a href="{{route('login')}}"><i class="fa fa-fw fa-sign-in"></i>Iniciar Sesión</a></li>
                        <li><a href="{{route('register')}}"><i class="fa fa-fw fa-user-circle"></i>Registrarse</a></li>
                    @else
                        @if($notify)
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="material-icons">notifications</i>
                                    <span class="notification" id="notifications" >
                                        {{$notifications->count()}}
                                    </span>
                                    <p class="hidden-lg hidden-md">Notificaciones</p>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right" id="notifications-dropdown">
                                    @forelse($notifications->slice(0, 5) as $solicitud)
                                        <li>
                                            <a href="{{ ($user instanceof \App\Models\Administrador)?
                                                            route('request::answer',$solicitud->id):
                                                            route('request::indexBuyer',$solicitud->id) }}">
                                                <strong>
                                                    {{ $solicitud->tipoSolicitud->tipo }}:
                                                </strong>
                                                {{ str_limit($solicitud->mensaje, $limit = 20, $end = '...') }}
                                            </a>
                                        </li>
                                    @empty
                                        <li><a><strong>¡No tienes nuevas Notificaciones!</strong></a></li>
                                    @endforelse
                                    <li><a href="{{ route('request::index') }}" style="text-align: center;"><small>Ver Notificaciones</small></a></li>
                                </ul>
                            </li>
                        @endif
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown">
                                <i class="material-icons">person</i>
                                <b class="caret"></b>
                                <p class="hidden-lg hidden-md">Perfil</p>
                                {{--<div class="ripple-container"></div>--}}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
                                <li><a href="{{ route('profile::profile') }}"><i class="fa fa-fw fa-user"></i> {{$user->nombres}} {{$user->apellidos}}<div class="ripple-container"></div></a></li>
                                <li><a href="{{route('logout')}}"><i class="fa fa-fw fa-sign-out"></i> Cerrar Sesión</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    <div class="wrapper">
        <!--Navbar-->

        @yield('header')

        @yield('main_content')

        <!-- Modal -->
    {{--<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <!--Content-->
            <div class="modal-content">
                <!--Header-->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title w-100" id="myModalLabel">Modal title</h4>
                </div>
                <!--Body-->
                <div class="modal-body">
                    ...
                </div>
                <!--Footer-->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
            <!--/.Content-->
        </div>
    </div>--}}

    <!--/.Navbar-->

        {{--<footer class="footer">--}}
            {{--<!--Footer Links-->--}}
            {{--<div class="container">--}}
                {{--<div class="content">--}}
                    {{--<div class="row">--}}
                        {{--<!--First column-->--}}
                        {{--<div class="col-md-4">--}}
                            {{--<h5 class="title">Terra Quimbaya</h5>--}}
                            {{--<p>Descripción del proyecto.</p>--}}
                        {{--</div>--}}
                        {{--<!--/.First column-->--}}
                        {{--<div class="center col-md-6">--}}
                            {{--<ul>--}}
                                {{--<li>--}}
                                    {{--<a href="//www.utp.edu.co/" title="Universidad Tecnológica de Pereira">--}}
                                        {{--<img src="{{asset('img/logo_utp.png')}}" height="62" alt="Escudo Universidad Tecnologica de Pereira">--}}
                                    {{--</a>--}}
                                    {{--<strong>Universidad Tecnológica de Pereira</strong>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                    {{--<a href="//isc.utp.edu.co/" title="Ingeniería de Sistemas y Computación">--}}
                                        {{--<img src="{{asset('img/logo_isc.png')}}" height="62" alt="Ingeniería de Sistemas y Computacion">--}}
                                    {{--</a>--}}
                                    {{--<strong>Ingeniería de Sistemas y Computación</strong>--}}
                                {{--</li>--}}
                            {{--</ul>--}}
                        {{--</div>--}}
                        {{--<!--Copyright-->--}}
                        {{--<p class="copyright pull-right">--}}
                            {{--&copy; <script>document.write(new Date().getFullYear())</script> <a href="{{url('/')}}">Terra Quimbaya</a>--}}
                        {{--</p>--}}
                        {{--<!--/.Copyright-->--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<!--/.Footer Links-->--}}
        {{--</footer>--}}
        <footer class="footer footer-big" style="text-align: center;">
            <div class="container">
                <div class="content">
                    <div class="row">
                        <div class="col-md-4">
                            <nav class="pull-left">
                                <ul>
                                    <!--First column-->
                                    <li><h5 class="title">Contáctanos</h5>
                                        <ul>
                                            <li style="display: block;">
                                                <a target="_blank" href="https://www.facebook.com/YourCoffeeApp/" data-toggle="tooltip" data-placement="right" title="YourCoffee en Facebook"><i class="fa fa-fw fa-facebook-official"></i> YourCoffee</a>
                                            </li>
                                            <li style="display: block;">
                                                <a target="_blank" href="https://twitter.com/YourCoffeeApp" data-toggle="tooltip" data-placement="right" title="YourCoffee en Twitter"><i class="fa fa-fw fa-twitter"></i> YourCoffee</a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
                <hr>
                <!--<li>
                    <a href="http://presentation.creative-tim.com">
                       About Us
                    </a>
                </li>
                <li>
                    <a href="http://blog.creative-tim.com">
                       Blog
                    </a>
                </li>
                <li>
                    <a href="http://www.creative-tim.com/license">
                        Licenses
                    </a>
                </li>
            </ul>
        </nav> -->
                <div class="copyright" style="display: inline-block; float: none;">
                    &copy; 2017, por <a href="{{ url('/') }}">Your Coffee</a>
                </div>
            </div>
        </footer>
    </div>

@endsection

@section('scripts')
    @parent
    {{--<script src="{{asset('assets-dashboard/js/material-dashboard/material-dashboard.js')}}"></script>--}}
    <script src="{{ asset('js/material-dashboard.js') }}" type="text/javascript"></script>
    {{--<script src="{{asset('assets-dashboard/js/material-kit/material-kit.js')}}" type="text/javascript"></script>--}}
    <script src="{{ asset('js/material-kit.js') }}" type="text/javascript"></script>

    <script src="{{asset('js/bootstrap-notify.min.js')}}" type="text/javascript"></script>

    @if(session('message-success'))
        <script type="text/javascript">
            $(document).ready(function () {
                $.notify('{{session('message-success')}}', {
                    type: 'success'
                });
            });
        </script>
    @elseif(session('message-error'))
        <script type="text/javascript">
            $(document).ready(function () {
                $.notify('{{session('message-error')}}', {
                    type: 'danger'
                });
            });
        </script>
    @endif
    @if($checked)
        <script>
            function showNotification(data) {
//                var text = data.nombres + " " + data.apellidos + data.notificacion;
                var text = data.notificacion;

                var number = parseFloat(document.getElementById("notifications").innerHTML);
                document.getElementById("notifications").innerHTML = number+1;

                var li = "<li><a href='" + data.href + "'><strong>" + data.tipo + ":</strong> " +
                    data.mensaje.substring(0,20) + "...</a></li>";

                $(li).prependTo("#notifications-dropdown");

                $(document).ready(function () {
                    $.notify(text, {
                        type: 'success',
//                        placement: {
//                            from: "bottom",
//                            align: "left"
//                        },
//                        title: 'Would you like some Foo ?'
                    });
                });
            }
            Pusher.logToConsole = true;
            var pusher = new Pusher('{{config('broadcasting.connections.pusher.key')}}', {
                cluster: '{{config('broadcasting.connections.pusher.options.cluster')}}',
                encrypted: {{config('broadcasting.connections.pusher.options.encrypted')}}
            });

            var channel = pusher.subscribe('{{ "notifications_" . $user->id }}');


            channel.bind('notifications', function(data) {
                showNotification(data);
            });
        </script>
    @endif

    {{--<script src="{{asset('assets-dashboard/js/material-kit/bootstrap-datepicker.js')}}" type="text/javascript"></script>--}}
{{--    <script src="{{asset('assets-dashboard/js/material-kit/nouislider.min.js')}}" type="text/javascript"></script>--}}
    {{--<script src="{{asset('assets-dashboard/js/material-dashboard/material-dashboard.js')}}"></script>--}}
@endsection
