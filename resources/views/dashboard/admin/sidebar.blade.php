@section('sidebarMenu')
    @parent
    <li class="{{$menuPerfil or ''}}">
        <a href="{{ route('profile::profile') }}">
            <i class="material-icons">person</i>
            <p>Perfil</p>
        </a>
    </li>
    <li>
        @if(isset($menuGestionAdmin) or isset($menuGestionProvider))
            <?php $state = 'true' ?>
            <?php $style = '' ?>
            <?php $drop = 'in' ?>
        @endif
        <a data-toggle="collapse" href="#pages" class="collapsed" aria-expanded="{{ $state or 'false'}}">
            <i class="material-icons">settings</i>
            <p>Gestión de Usuarios
                <b class="caret"></b>
            </p>
        </a>
        <div class="collapse {{ $drop or '' }}" id="pages" aria-expanded="{{ $state or 'false' }}"
             style="{{ $style or 'height: 0px;' }}">
            <ul class="nav">
                <li class="{{$menuGestionAdmin or ''}}">
                    <a href="{{route('admin::index')}}">
                        <i class="material-icons">settings</i>
                        <p>Administradores</p>
                    </a>
                </li>
                <li class="{{$menuGestionProvider or ''}}">
                    <a href="{{route('provider::index')}}">
                        <i class="material-icons">people</i>
                        <p>Proveedores</p>
                    </a>
                </li>
            </ul>
        </div>
    </li>
    <li class="{{$menuGestionProduct or ''}}">
        <a href="{{ route('product::index') }}">
            <i class="material-icons">shop</i>
            <p>Productos</p>
        </a>
    </li>
    <li class="{{$menuGestionRequest or ''}}">
        <a href="{{ route('request::index') }}">
            <i class="material-icons">assignment</i>
            <p>Gestión de Solicitudes</p>
        </a>
    </li>
    <li class="{{$menuGestionReport or ''}}">
        <a href="{{ route('report::index') }}">
            <i class="material-icons">attach_file</i>
            <p>Gestión de Informes</p>
        </a>
    </li>

@stop

{{--@section('sidebarMenu')--}}
    {{--@parent--}}
    {{--<li class="{{$menuPerfil or ''}}">--}}
        {{--<a href="{{ route('profile') }}">--}}
            {{--<i class="material-icons">person</i>--}}
            {{--<p>Perfil</p>--}}
        {{--</a>--}}
    {{--</li>--}}
    {{--<li class="{{$menuGestionAdmin or ''}}">--}}
        {{--<a href="{{route('admin::index')}}"> --}}{{--href="{{url('administradores')}}">--}}
            {{--<i class="material-icons">settings</i>--}}
            {{--<p>Gestión Administradores</p>--}}
        {{--</a>--}}
    {{--</li>--}}
{{--@stop--}}


@section('sidebarMenu')
    {{--<div class="sidebar-menu">--}}
        {{--<ul class="sidebar-nav">--}}
            {{--<li class="active">--}}
                {{--<a href="{{url('/')}}">--}}
                    {{--<div class="icon">--}}
                        {{--<i class="fa fa-tasks" aria-hidden="true"></i>--}}
                    {{--</div>--}}
                    {{--<div class="title">Perfil</div>--}}
                {{--</a>--}}
            {{--</li>--}}
            {{--<li class="dropdown">--}}
                {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown">--}}
                    {{--<div class="icon">--}}
                        {{--<i class="fa fa-file-o" aria-hidden="true"></i>--}}
                    {{--</div>--}}
                    {{--<div class="title">Gestión de Usuarios</div>--}}
                {{--</a>--}}
                {{--<div class="dropdown-menu">--}}
                    {{--<ul>--}}
                        {{--<li class="section"><i class="fa fa-file-o" aria-hidden="true"></i> Administrador</li>--}}
                        {{--<li><a href="{{url('administradores')}}">Administradores</a></li>--}}
                        {{--<li><a href="{{url('proveedores')}}">Proveedores</a></li>--}}
                    {{--</ul>--}}
                {{--</div>--}}
            {{--</li>--}}
        {{--</ul>--}}
    {{--</div>--}}

    {{--<li class="active">--}}
        {{--<a href="dashboard.blade.php">--}}
            {{--<i class="material-icons">dashboard</i>--}}
            {{--<p>Dashboard</p>--}}
        {{--</a>--}}
    {{--</li>--}}
    {{--<li class="@yield('menuPerfil')">--}}
        {{--<a href="user.html">--}}
            {{--<i class="material-icons">person</i>--}}
            {{--<p>Perfil</p>--}}
        {{--</a>--}}
    {{--</li>--}}
    {{--<li class="@yield('menu')">--}}
        {{--<a href="table.html">--}}
            {{--<i class="material-icons">content_paste</i>--}}
            {{--<p>Table List</p>--}}
        {{--</a>--}}
    {{--</li>--}}
    {{--<li class="@yield('menu')">--}}
        {{--<a href="typography.html">--}}
            {{--<i class="material-icons">library_books</i>--}}
            {{--<p>Typography</p>--}}
        {{--</a>--}}
    {{--</li>--}}
    {{--<li class="@yield('menu')">--}}
        {{--<a href="icons.html">--}}
            {{--<i class="material-icons">bubble_chart</i>--}}
            {{--<p>Icons</p>--}}
        {{--</a>--}}
    {{--</li>--}}
    {{--<li class="@yield('menu')">--}}
        {{--<a href="maps.html">--}}
            {{--<i class="material-icons">location_on</i>--}}
            {{--<p>Maps</p>--}}
        {{--</a>--}}
    {{--</li>--}}
    {{--<li>--}}
        {{--<a href="notifications.html">--}}
            {{--<i class="material-icons text-gray">notifications</i>--}}
            {{--<p>Notifications</p>--}}
        {{--</a>--}}
    {{--</li>--}}
    {{--<li class="active-pro">--}}
        {{--<a href="upgrade.html">--}}
            {{--<i class="material-icons">unarchive</i>--}}
            {{--<p>Upgrade to PRO</p>--}}
        {{--</a>--}}
    {{--</li>--}}
@endsection

