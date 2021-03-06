<div class="header header-filter" style="background-image: url('{{asset("img/ImagenesTerra/DSCN7055.JPG")}}');">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <img style="max-width: 75%; height: auto; filter: brightness(100); overflow: hidden; margin: 0 auto;" src="{{ asset('img/icon.png') }}" class="img img-responsive">
                {{--<div class="embed-responsive embed-responsive-4by3">--}}
                {{--<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/qDUwsxlTlbI" allowfullscreen></iframe>--}}
                {{--</div>--}}
            </div>
            <div class="col-md-6">
                {{--<div class="brand">--}}
                {{--<h1 class="title">Proyecto Café</h1>--}}
                {{--</div>--}}
                <h1 class="title">Terra Quimbaya</h1>
                <h4>Promovemos la sustentabilidad y el desarrollo de la economía local a través de la comercialización de productos de la biodiversidad de alto valor agregado.
                    <br>
                    Con esta plataforma, biotrade store&reg;, se busca acercar a productores y compradores, permitiendo el reconocimiento de las características de cada producto especial para aquellas personas que buscan los más altos estándares de calidad.
                </h4>
                <h5>Ahora puedes visitarnos desde:</h5>
                {{--<br />--}}
                <div align="center">
                    <ul class="list-inline">
                        <li>
                            <a href="{{ route('app', ['platform' => 'android']) }}" class="btn btn-simple btn-white btn-just-icon btn-lg" data-toggle="tooltip" data-placement="top" title="Descárga la app para Android">
                                <i class="material-icons" style="font-size: 48px;">android</i>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('app', ['platform' => 'web']) }}" target="_blank" class="btn btn-simple btn-white btn-just-icon btn-lg" data-toggle="tooltip" data-placement="top" title="Visita nuestra tienda en línea">
                                <i class="material-icons" style="font-size: 48px;">computer</i>
                            </a>
                        </li>
                    </ul>
                </div>
                {{--<br />--}}
                {{--<a href="#" class="btn btn-danger btn-raised btn-lg">--}}
                {{--<i class="fa fa-play"></i> Watch video--}}
                {{--</a>--}}
            </div>
        </div>
    </div>
</div>