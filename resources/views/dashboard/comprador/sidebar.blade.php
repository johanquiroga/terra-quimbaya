@section('sidebarMenu')
    @parent
    <li class="{{$menuPerfil or ''}}">
        <a href="{{ route('profile::profile') }}">
            <i class="material-icons">person</i>
            <p>Perfil</p>
        </a>
    </li>
    <li class="{{$menuGestionRequest or ''}}">
        <a href="{{ route('request::index') }}">
            <i class="material-icons">assignment</i>
            <p>Gestión de Solicitudes</p>
        </a>
    </li>
@endsection