
@extends('home')

@section('page', 'profile-page')

@section('header')
@include('headers.provider')
@endsection

@section('info-proveedor')
    <div class="row">
        <div class="col-md-8 col-md-offset-3" align="left">
            <h4>
                <strong>Nombre: </strong>
                {{ $provider->nombres }} {{ $provider->apellidos }}

            </h4>
            <h4>
                <strong>Teléfono: </strong>
                {{ $provider->telefono }}
            </h4>
            <h4>
                <strong>Edad: </strong>
                {{ $provider->edadProveedor }}
            </h4>
        </div>
    </div>
@endsection

@section('info-finca')
    <div class="row">
        <div class="col-md-8 col-md-offset-3" align="left">
            <h4>
                <strong>Nombre de la Finca: </strong>
                {{ $provider->nombreFinca }}

            </h4>
            <h4>
                <strong>Altura de la finca: </strong>
                {{ $provider->alturaFinca }} <small>m s. n. m.</small>
            </h4>
            <h4>
                <strong>Extensión de la Finca: </strong>
                {{ $provider->extensionFinca }} <small>ha</small>
            </h4>
            <h4>
                <strong>Densidad de Siembra: </strong>
                {{ $provider->densidadSiembra->tipo }}
            </h4>
            <h4>
                <strong>Años del Cafetal: </strong>
                {{ $provider->añosCafetal }}
            </h4>
            <h4>
                <strong>Edad desde la última Zoca: </strong>
                {{ $provider->edadUltimaZoca->tipo }}
            </h4>
            <h4>
                <strong>Variedad de café: </strong>
                @foreach($provider->variedadesCafe as $variedad)
                    {{ $variedad->tipo }},
                @endforeach
            </h4>
            <h4>
                <strong>Tipo de Beneficio / Beneficiado: </strong>
                {{ $provider->tipoBeneficio->tipo }}
            </h4>
            <h4>
                <strong>Ecotopo: </strong>
                {{ $provider->ecotopo->tipo }}
            </h4>
        </div>
    </div>
@endsection

@section('main_content')

{{--<main id="mainContainer">--}}
    <div class="main main-raised">
        <div class="profile-content">
            <!-- Main Container -->
            <div class="container">
                <div class="row">
                    <div class="profile">
                        <div class="avatar">
                            <?php $foto = $provider->fotos->first(); ?>
                            <img src="{{route('storage::get', $foto->path . $foto->nombreArchivo)}}" class="img-rounded img-responsive img-raised" alt="Circle Image">
                        </div>
                        <div class="name">
                            <h3 class="title">{{ $provider->nombres }} {{ $provider->apellidos }}</h3>
                            <h6>{{ $provider->nombreFinca }}</h6>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="profile-tabs">
                            <div class="nav-align-center">
                                <ul class="nav nav-pills" role="tablist">
                                    <li class="active">
                                        <a href="#info_proveedor" role="tab" data-toggle="tab" aria-expanded="true">
                                            <i class="material-icons">person</i>
                                            Proveedor
                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="#info_finca" role="tab" data-toggle="tab" aria-expanded="false">
                                            <i class="material-icons">nature_people</i>
                                            Finca
                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="#fotos" role="tab" data-toggle="tab" aria-expanded="false">
                                            <i class="material-icons">photo_library</i>
                                            Fotos
                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="#productos" role="tab" data-toggle="tab" aria-expanded="true">
                                            <i class="fa fa-coffee"></i>
                                            Productos
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content gallery">
                                    <div class="tab-pane active" id="info_proveedor">
                                        @yield('info-proveedor')
                                    </div>
                                    <div class="tab-pane" id="info_finca">
                                        @yield('info-finca')
                                    </div>
                                    <div class="tab-pane text-center" id="fotos">
                                        <div class="row">
                                            <div class="col-md-8 col-md-offset-2">
                                                <!-- Carousel Card -->
                                                <div class="card card-raised card-carousel">
                                                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                                                        <div class="carousel slide" data-ride="carousel">

                                                            <!-- Indicators -->
                                                            <ol class="carousel-indicators">
                                                                @for($i=0; $i<count($provider->fotos); $i++)
                                                                    <li data-target="#carousel-example-generic" data-slide-to="{{$i}}" class="{{ $i == 0 ? 'active' : '' }}"></li>
                                                                @endfor
                                                            </ol>

                                                            <!-- Wrapper for slides -->
                                                            <div class="carousel-inner">
                                                                @foreach($provider->fotos as $index => $foto)
                                                                    <div class="item{{ $index == 0 ? ' active' : '' }}">
                                                                        <img src="{{route('storage::get', $foto->path . $foto->nombreArchivo) }}" alt="Imagen_{{$index}}">
                                                                    </div>
                                                                @endforeach
                                                            </div>

                                                            <!-- Controls -->
                                                            <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                                                                <i class="material-icons">keyboard_arrow_left</i>
                                                            </a>
                                                            <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                                                                <i class="material-icons">keyboard_arrow_right</i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End Carousel Card -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane text-center" id="productos">
                                        <div class="row">
                                        @forelse($provider->productos as $product)
                                            <div class="col-md-4">
                                                @include('partials.show_product', ['producto' => $product])
                                            </div>
                                        @empty
                                            <div class="col-md-12">
                                                <h2 class="title">No hay productos!!</h2>
                                            </div>
                                        @endforelse
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- End Profile Tabs -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.Main Container -->
    
@endsection
