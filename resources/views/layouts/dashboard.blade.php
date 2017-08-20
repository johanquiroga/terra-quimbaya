@extends('app')


{{--@section('title','<title>Dashboard</title>')--}}

@section('styles')
    @parent
    <!-- Bootstrap core CSS     -->
    {{--<link href="{{ asset('assets-dashboard/css/material-dashboard/bootstrap.min.css') }}" rel="stylesheet" />--}}

    <!--  Material Dashboard CSS    -->
    <link href="{{ asset('material-dashboard/material-dashboard.css') }}" rel="stylesheet"/>

    <!--  Custom Material Dashboard CSS    -->
    <link href="{{ asset('custom-assets/custom_material-dashboard.css') }}" rel="stylesheet"/>

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
        <div class="sidebar" data-color="@yield('ColorBoard', 'brown')" data-image="/assets-dashboard/img/sidebar-5.jpg">
            <div class="logo">
                <a href="{{url('/')}}" class="simple-text">
                    <div class="logo-img">
                        <img style="display: inline-block;
                                 margin-left: 0px;
                                 margin-right: 10px;
                                 text-align: center;" src="{{ asset('img/logo.JPG') }}" class="img-rounded img-responsive img-raised" width="60" height="auto" alt="Terra Quimbaya Logo"/>
                    </div>
                    {{--Terra Quimbaya--}}
                </a>
            </div>
            <div class="sidebar-wrapper">
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
                        <a class="navbar-brand" href=""><strong>@yield('Page-title', 'Terra Quimbaya')</strong></a>
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">
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
                    <div class="content">
                        <div class="col-md-8">
                            <ul>
                                {{--<li>--}}
                                    {{--<a href="//www.utp.edu.co/" title="Universidad Tecnológica de Pereira">--}}
                                        {{--<img src="{{asset('img/logo_utp.png')}}" height="62" alt="Escudo Universidad Tecnologica de Pereira">--}}
                                        {{--Universidad Tecnológica de Pereira--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                    {{--<a href="//isc.utp.edu.co/" title="Ingeniería de Sistemas y Computación">--}}
                                        {{--<img src="{{asset('img/logo_isc.png')}}" height="62" alt="Ingeniería de Sistemas y Computacion">--}}
                                        {{--Ingeniería de Sistemas y Computación--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                            </ul>
                        </div>
                        <!--Copyright-->
                        <p class="copyright pull-right">
                            &copy; <script>document.write(new Date().getFullYear())</script>, hecho por Johan Camilo Quiroga Granda y Jimy Andrés Alzate Ramírez para <a href="{{url('/')}}">Terra Quimbaya</a>
                        </p>
                        <!--/.Copyright-->
                    </div>
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
    <script src="{{ asset('assets-dashboard/js/material-dashboard/bootstrap-notify.js') }}"></script>

    <!--  Google Maps Plugin    -->
    {{--<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>--}}

    <!-- Material Dashboard javascript methods -->
    {{--<script src="{{ asset('assets-dashboard/js/material-dashboard/material-dashboard.js') }}"></script>--}}

    <!-- DataTables -->
    <script src="{{asset('assets-dashboard/js/material-dashboard/material-dashboard.js')}}"></script>
    <script src="{{asset('assets-dashboard/js/material-kit/material-kit.js')}}" type="text/javascript"></script>
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
        var pusher = new Pusher('{{env("PUSHER_KEY")}}', {
            cluster: 'us2',
            encrypted: true
        });

        var channel = pusher.subscribe('{{ "notifications_" . $user->id }}');


        channel.bind('notifications', function(data) {
            showNotification(data);
        });
    </script>
@endsection
