@section('sidebarMenu')
@parent
            <li class="{{$menuPerfil or ''}}">
                <a href="{{ route('profile::profile') }}">
                    <i class="material-icons">person</i>
                    <p>Perfil</p>
                </a>
            </li>
            <li class="{{$menuGestionAdmin or ''}}">
                <a href="{{route('admin::index')}}"> {{--href="{{url('administradores')}}">--}}
                    <i class="material-icons">settings</i>
                    <p>Gestión Administradores</p>
                </a>
            </li>
@stop



