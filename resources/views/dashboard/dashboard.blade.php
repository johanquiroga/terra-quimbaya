@extends('app')


{{--@section('title','<title>Dashboard</title>')--}}

@section('styles')
    @parent
    <!-- Bootstrap core CSS     -->
    {{--<link href="{{ asset('assets-dashboard/css/material-dashboard/bootstrap.min.css') }}" rel="stylesheet" />--}}

    <!--  Material Dashboard CSS    -->
    <link href="{{ asset('material-dashboard/material-dashboard.css') }}" rel="stylesheet"/>

    <!--  Custom Material Dashboard CSS    -->
    <link href="{{ asset('css/custom/custom_material-dashboard.css') }}" rel="stylesheet"/>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
    {{--<link rel="stylesheet" href="//cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css">--}}

    {{--<link href="{{asset('custom-assets/custom_material-kit.css')}}" rel="stylesheet">--}}
@endsection

{{--@section('styles')--}}
    {{--@parent--}}
    {{--<link rel="stylesheet" href="https://cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">--}}
{{--    <link href="{{asset('material-kit/material-kit.css')}}" rel="stylesheet">--}}
    {{--<link href="{{asset('custom-assets/custom_material-dashboard.css')}}" rel="stylesheet"/>--}}
    {{--<link href="{{asset('material-dashboard/material-dashboard.css')}}" rel="stylesheet"/>--}}
    {{--    <link href="{{asset('assets-dashboard/css/custom.css')}}" rel="stylesheet"/>--}}
{{--@endsection--}}

@section('body')

    <div class="wrapper">
        <div class="sidebar" data-color="@yield('ColorBoard', 'green-dark')" data-image="{{ asset('img/ImagenesTerra/DSCN7055.JPG') }}">
            <div class="sidebar-wrapper">
                <div class="logo">
                    <a href="{{route('home')}}" class="simple-text" style="padding: 0">
                        <div class="logo-img">
                            <img style="display: inline-block;
                                 margin-left: 0px;
                                 margin-right: 10px;
                                 width: 50%;
                                 background-color: white;
                                 padding: 5px;
                                 text-align: center;" src="{{ asset('img/Logo_TerraQuimbaya.svg') }}" class="img-rounded img-responsive img-raised" height="auto" alt="Your Coffee Logo"/>
                        </div>
                        {{--Terra Quimbaya--}}
                    </a>
                </div>
                <ul class="nav">
                    @yield('sidebarMenu')
                </ul>
            </div>
        </div>
        <div class="main-panel">
            <nav class="navbar navbar-fixed-top navbar-transparent navbar-absolute">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href=""><strong>@yield('Page-title', config('app.name'))</strong></a>
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="{{ route('home') }}"><i class="fa fa-fw fa-home"></i>Inicio</a></li>
                            @if($notify)
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="material-icons">notifications</i>
                                    <span class="notification" id="notifications" >
                                        {{$notifications->count()}}
                                    </span>
                                    <p class="hidden-lg hidden-md">Notificaciones</p>
                                </a>
                                <ul class="dropdown-menu" id="notifications-dropdown">
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
                                    <li><a href="{{ route('request::index') }}" class="center"><small>Ver Notificaciones</small></a></li>
                                </ul>
                            </li>
                            @endif
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="material-icons">person</i>
                                    <p class="hidden-lg hidden-md">Perfil</p>
                                </a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ route('profile::profile') }}"><i class="fa fa-fw fa-user"></i> {{$user->nombres}} {{$user->apellidos}}</a></li>
                                <li><a href="{{route('logout')}}"><i class="fa fa-fw fa-power-off"></i> Cerrar Sesión</a></li>
                                </ul>
                            </li>
                        </ul>

                        <form id="search-form" class="navbar-form navbar-right" role="search" method="GET" action="{{ url("/search") }}">
                            <div class="form-group">
                                {{--<select id="searchbox" name="keyword" class="form-control" placeholder="Buscar por productos..." style="width: 240px;"></select>--}}
                                <input type="text" id="searchbox" name="keyword" value="{{ old('nombre') }}" placeholder="Buscar por productos..." style="width: 240px;">
                                {{--<span class="input-group-btn">--}}
                                {{--<button class="btn btn-white btn-round btn-just-icon" type="button"><i class="material-icons">search</i></button>--}}
                                {{--</span>--}}
                                {{--<button class="btn btn-white btn-round btn-just-icon" type="submit"><i class="material-icons">search</i></button>--}}
                            </div>
                        </form>
                    </div>
                </div>
            </nav>

            <div class="content">
                <div class="container-fluid">

                    @yield('content')

                </div>
            </div>

            <footer class="footer">
                <!--Footer Links-->
                <div class="container-fluid">
                {{--<nav class="pull-left">--}}
                {{--<ul>--}}
                {{--<li>--}}
                {{--<a href="{{ url('/') }}">--}}
                {{--Inicio--}}
                {{--</a>--}}
                {{--</li>--}}
                {{--</ul>--}}
                {{--</nav>--}}
                <!--Copyright-->
                    <p class="copyright pull-right">
                        &copy; <script>document.write(new Date().getFullYear())</script>, hecho por <a href="http://johanquiroga.me" target="_blank">Johan Quiroga</a> y <a href="http://jimyandres.me" target="_blank">Jimy Andrés</a> para <a href="{{url('/')}}">{{ config('app.name') }}</a>
                    </p>
                    <!--/.Copyright-->
                </div>
                <!--/.Footer Links-->
            </footer>
        </div>
    </div>

@endsection

@section('scripts')
    @parent

    <!--  Charts Plugin -->
    {{--<script src="{{ asset('assets-dashboard/js/material-dashboard/chartist.min.js') }}"></script>--}}

    <!--  Notifications Plugin    -->
    {{--<script src="{{ asset('assets-dashboard/js/material-dashboard/bootstrap-notify.js') }}"></script>--}}

    <!--  Google Maps Plugin    -->
    {{--<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>--}}

    <!-- Material Dashboard javascript methods -->
    {{--<script src="{{ asset('assets-dashboard/js/material-dashboard/material-dashboard.js') }}"></script>--}}

    <!-- DataTables -->
    {{--<script src="{{asset('assets-dashboard/js/material-dashboard/material-dashboard.js')}}"></script>--}}
    <script src="{{ asset('js/material-dashboard.js') }}" type="text/javascript"></script>
    {{--<script src="{{asset('assets-dashboard/js/material-kit/material-kit.js')}}" type="text/javascript"></script>--}}
    <script src="{{ asset('js/material-kit.js') }}" type="text/javascript"></script>

    <script src="{{asset('js/bootstrap-notify.min.js')}}" type="text/javascript"></script>

    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    {{--<script src="//cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>--}}

    {{--<script src="//cdn.datatables.net/1.10.15/js/dataTables.material.min.js"></script>--}}

    {{--<script type="text/javascript">
        $(document).ready(function(){

            // Javascript method's body can be found in assets/js/demos.js
            demo.initDashboardPageCharts();

        });
    </script>--}}
    @if(session('message-success'))
        <script type="text/javascript">
            $(document).ready(function () {
                $.notify('{{session('message-success')}}', {
                    type: 'success'
                });
            });
        </script>
    @endif
    @if(session('message-error'))
        <script type="text/javascript">
            $(document).ready(function () {
                $.notify('{{session('message-error')}}', {
                    type: 'danger'
                });
            });
        </script>
    @endif

    <script>
        function showNotification(data) {

//            var text = "Tienes una nueva notificación de tipo " + data.tipo +
//                " del Usuario " + data.nombres +
//                " " + data.apellidos + ".";

//            var text = data.nombres + " " + data.apellidos + data.notificacion;
            var text = data.notificacion;

            var number = parseFloat(document.getElementById("notifications").innerHTML);
            document.getElementById("notifications").innerHTML = number+1;

            var li = "<li><a href='" + data.href + "'><strong>" + data.tipo + ":</strong> " +
                data.mensaje.substring(0,20) + "...</a></li>";

            $(li).prependTo("#notifications-dropdown");

            $(document).ready(function () {
                $.notify(text, {
                    type: 'success'
//                    placement: {
//                        from: "bottom",
//                        align: "left"
//                    }
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
@endsection
