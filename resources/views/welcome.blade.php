@extends('app')

@section('metas')
    @parent

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@TerraQuimbaya">
    <meta name="twitter:title" content="{{ config('app.name') }}, biotrade store">
    <meta name="twitter:description" content="Check this awesome specialty coffee project">
    <meta name="twitter:creator" content="@TerraQuimbaya">
    <meta name="twitter:image" content="{{ asset('img/logo.JPG') }}">

    <!-- You can use Open Graph tags to customize link previews.
    Learn more: https://developers.facebook.com/docs/sharing/webmasters -->
    <meta property="og:url"           content="{{ url('/') }}" />
    <meta property="og:type"          content="website" />
    <meta property="og:title"         content="{{ config('app.name') }}, biotrade store" />
    <meta property="og:description"   content="Check this awesome specialty coffee project." />
    <meta property="og:image"         content="{{ asset('img/logo.JPG') }}" />
    <meta property="og:site_name" content="{{ config('app.name') }}" />
@endsection

@section('styles')
    @parent
    <link href="{{asset('material-dashboard/material-dashboard.css')}}" rel="stylesheet">
    <link href="{{asset('material-kit/material-kit.css')}}" rel="stylesheet">
    <link href="{{asset('css/custom/custom_logo.css')}}" rel="stylesheet"/>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet"/>
@endsection

@section('page', 'landing-page')

@section('body')
    <nav class="navbar navbar-transparent navbar-absolute">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ url('/') }}">
                    <strong>{{ config('app.name') }}</strong>
                </a>
            </div>

            <div class="collapse navbar-collapse" id="navigation-example" style="text-align: center;">
                <ul class="nav navbar-nav" style="display: inline-block; float: none;">
                    <li>
                        <a href="#registration">
                            <strong>Regístrate</strong>
                        </a>
                    </li>
                    <li>
                        <a href="#contact-us">
                            <strong>Contáctanos</strong>
                        </a>
                    </li>
                    {{--<li>
                        <a href="{{ route('home') }}">
                            Ver Tienda
                        </a>
                    </li>--}}
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="{{ config('app.fb') }}" target="_blank" class="btn btn-simple btn-white btn-just-icon" data-toggle="tooltip" data-placement="bottom" title="Like us on Facebook">
                            <i class="fa fa-facebook-square"></i>
                            <p class="hidden-lg hidden-md">Like us on Facebook</p>
                        </a>
                    </li>
                    <li>
                        <a href="{{ config('app.twitter') }}" target="_blank" class="btn btn-simple btn-white btn-just-icon" data-toggle="tooltip" data-placement="bottom" title="Follow us on Twitter">
                            <i class="fa fa-twitter"></i>
                            <p class="hidden-lg hidden-md">Follow us on Twitter</p>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('app', ['platform' => 'web']) }}" class="btn btn-simple btn-white btn-just-icon" data-toggle="tooltip" data-placement="bottom" title="Ver tienda en línea">
                            <i class="fa fa-home"></i>
                            <p class="hidden-lg hidden-md">Ver tienda en línea</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="wrapper">
        <div class="header header-filter" style="background-image: url('{{asset("img/ImagenesTerra/DSCN7055.JPG")}}');">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <img style="max-width: 100%; height: auto; filter: brightness(100); overflow: hidden; margin: 0 auto;" src="{{ asset('img/Logo_TerraQuimbaya.svg') }}" class="img img-responsive">
                    </div>
                    <div class="col-md-6">
                        <h2 class="title">Regístrate y empieza a comprar cafés especiales de la manera más fácil y cómoda</h2>
                        <h4>Somos una plataforma que promueve la sustentabilidad y el desarrollo de la economía local a través de la comercialización de productos de la biodiversidad de alto valor agregado.</h4>
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
                        {{--<div class="fb-share-button" data-href="https://www.facebook.com/YourCoffeeApp/" data-layout="button" data-size="large" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fwww.facebook.com%2FYourCoffeeApp%2F&amp;src=sdkpreparse">Compartir</a></div>--}}
                    </div>
                </div>
            </div>
        </div>

        <div class="main main-raised">
            <div class="container">
                <div class="section text-center section-landing">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <h2 class="title">Hablemos del producto</h2>
                            <h4>Con esta plataforma se busca acercar a productores y compradores, permitiendo el reconocimiento de las características de cada producto especial para aquellas personas que buscan los más altos estándares de calidad.</h4>
                        </div>
                    </div>

                    <div class="features">
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2">
                                <h2 class="title">Cafés para todos los gustos</h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2">
                                <div class="card card-raised">
                                    <div id="myCarousel" class="carousel slide" data-ride="carousel">
                                        <!-- Indicators -->
                                        <ol class="carousel-indicators">
                                            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                                            <li data-target="#myCarousel" data-slide-to="1"></li>
                                            <li data-target="#myCarousel" data-slide-to="2"></li>
                                            <li data-target="#myCarousel" data-slide-to="3"></li>
                                        </ol>

                                        <!-- Wrapper for slides -->
                                        <div class="carousel-inner">

                                            <div class="item">
                                                <img class="mask" src="{{ asset('img/caturra.jpg') }}" alt="Caturra">
                                                <div class="carousel-caption">
                                                    <h3>Café caturra</h3>
                                                    <strong>
                                                        <p class="hidden-xs">Variedad encontrada en Minas Gerais, Brasil.</p>
                                                        <p class="hidden-xs">Posiblemente originada como una mutación de un gene dominante del café Bourbon.</p>
                                                        <p class="hidden-xs">El Caturra se caracteriza por ser de porte bajo, tiene entrenudos cortos, tronco grueso y poco ramificado, y ramas laterales abundantes, cortas, con ramificación secundaria, lo que da a la planta un aspecto vigoroso y compacto.</p>
                                                        <p>Sabor agradable, de una calidad ligeramente inferior a la Typica.</p>
                                                    </strong>
                                                </div>
                                            </div>

                                            <div class="item">
                                                <img class="mask" src="{{ asset('img/maragogipe.jpg') }}" alt="Maragogipe" style="width: 100%;">
                                                <div class="carousel-caption">
                                                    <h3>Maragogipe</h3>
                                                    <strong>
                                                        <p class="hidden-xs">Es una variedad de Café Arabica, descubierta cerca  del pueblo de Maragogipe, en Bahía, Brasil. Variedad muy definida, con granos muy grandes.</p>
                                                        <p class="hidden-xs">Se trata de un Café azulado mate, que lo diferencia claramente de otras procedencias y hace de este, el Café Maragogipe, como uno de los más apreciados del mundo.</p>
                                                        <p>Café cálido al paladar, suave y perfumado.</p>
                                                    </strong>
                                                </div>
                                            </div>

                                            <div class="item">
                                                <img class="mask" src="{{ asset('img/bourbon.jpg') }}" alt="Bourbon">
                                                <div class="carousel-caption">
                                                    <h3>Bourbon</h3>
                                                    <strong>
                                                        <p class="hidden-xs">Los Bourbones son árboles de porte alto, necesitan podas para poder regular su crecimiento.</p>
                                                        <p class="hidden-xs">Dependiendo de las condiciones de la finca son altamente productivos.</p>
                                                        <p>Son cafés de buena dulzura con aromas y sabores frutales y acaramelados.</p>
                                                        <p class="hidden-xs">Son recolectados en un óptimo estado de maduración, sometidos a un proceso de fermentación controlada que ayudan a obtener una taza redonda, compleja y de sabor equilibrado.</p>
                                                    </strong>
                                                </div>
                                            </div>

                                            <div class="item active">
                                                <img class="mask" src="{{ asset('img/typica.jpg') }}" alt="Typica">
                                                <div class="carousel-caption">
                                                    <h3>Typica</h3>
                                                    <strong>
                                                        <p class="hidden-xs">Es la “columna vertebral” genética de muchas de las especies de cafés especiales de la actualidad.</p>
                                                        <p class="hidden-xs">Las primeras plantaciones de café que crecieron en América y en Asia, fueron de la variedad Typica y muchas de la gran variedad cultivada de clase arábica en la actualidad son descendientes directos de dicha planta.</p>
                                                        <p class="hidden-xs">En apariencia, es muy parecida a la planta Bourbon, aunque es generalmente identificable por sus puntas de hoja de bronce.</p>
                                                        <p>Este se caracteriza por ser de excelente calidad, con buen cuerpo y gran dulzura.</p>
                                                    </strong>
                                                </div>
                                            </div>

                                        </div>

                                        <!-- Left and right controls-->
                                        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                                            <i class="material-icons">keyboard_arrow_left</i>
                                        </a>

                                        <a class="right carousel-control" href="#myCarousel" data-slide="next">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="features">
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2">
                                <h2 class="title">¿Por qué nosotros?</h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2">
                                <ul style="font-size: 1.3em;" class="list-unstyled">
                                  <li class="list-group">Tendrás a tu disposición un amplio catálogo de cafés especiales, todos de pequeños/medianos caficultores que estarás apoyando directamente.</li>
                                  <li class="list-group">Podrás visualizar la información acerca de estos caficultores, así los podrás conocer mejor y podrás saber verdaderamente quién está cultivando tu café favorito.</li>
                                  <li class="list-group">Cada producto que veas tendrá una descripción detallada de sus características, incluyendo datos del perfil de taza proporcionados por el caficultor y verificados por nosotros.</li>
                                  <li class="list-group">Podrás realizar las preguntas que desees acerca de los productos que te interesen. Estas serán respondidas, a través de nosotros, por los caficultores.</li>
                                  <li class="list-group">Una vez realices una compra podrás dejar una calificación y comentario acerca de tu experiencia con dicho producto. Esta podrá ser visualizada por los demás usuarios y será de gran ayuda saber qué piensan los demás.</li>
                                </ul>
                            </div>
                        </div>
                        {{--<div class="row">
                            <div class="col-md-4">
                                <div class="card-testimonial" style="display: inline-block;
                                                                     position: relative;
                                                                     width: 100%;
                                                                     margin-bottom: 30px;
                                                                     border-radius: 6px;
                                                                     color: rgba(0,0,0, 0.87);
                                                                     background: #fff;
                                                                     box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.14), 0 3px 1px -2px rgba(0, 0, 0, 0.2), 0 1px 5px 0 rgba(0, 0, 0, 0.12);
                                    ">
                                    <div class="icon">
                                        <i class="material-icons">autorenew</i>
                                    </div>
                                    <div class="card-content">
                                        <h5 class="card-description">Tendrás a tu disposición la lista de todos los cafés especiales a la venta.</h5>
                                    </div>
                                </div>
                            </div>
                        </div>--}}
                    </div>

                    <div class="features">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="info">
                                    <div class="icon icon-primary">
                                        {{--<i class="material-icons">accessibility</i>--}}
                                        <i class="material-icons">tag_faces</i>
                                        {{--<i class="fa fa-bed"></i>--}}
                                    </div>
                                    <h4 class="info-title">Comodidad</h4>
                                    <p style="font-size: 1.2em; color: #000;">Consulta y adquiere productos de calidad desde tu dispositivo móvil, tablet o computadora, cuando y donde quieras.</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info">
                                    <div class="icon icon-info">
                                        <i class="material-icons">autorenew</i>
                                    </div>
                                    <h4 class="info-title">Variedad de marcas</h4>
                                    <p style="font-size: 1.2em; color: #000;">Con nosotros, tendrás a unos pocos clics de distancia una variedad de cafés especiales con características únicas, que no podrás encontrar en otro lado.</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info">
                                    <div class="icon icon-success">
                                        <i class="material-icons">access_time</i>
                                    </div>
                                    <h4 class="info-title">Rapidez en la compra de productos</h4>
                                    <p style="font-size: 1.2em; color: #000;">Olvídate de tener que esperar meses para poder obtener un café de calidad, con nuestra plataforma es tan fácil como ingresar con tu usuario, seleccionar el café que quieras y disfrutarlo cuando llegue a tu casa.</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info">
                                    <div class="icon icon-danger">
                                        <i class="material-icons">favorite</i>
                                    </div>
                                    <h4 class="info-title">Vive la experiencia</h4>
                                    <p style="font-size: 1.2em; color: #000;">En cada producto publicado podrás encontrar información detallada acerca de dónde proviene el café, quién lo cultiva, qué características posee y consejos de preparación por parte del mismo caficultor para exaltar sus propiedades.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section text-center">
                    <h2 class="title">Este es nuestro equipo</h2>

                    <div class="team">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="team-player">
                                    <img src="{{ asset('img/quiroga.jpg') }}" alt="Thumbnail Image" class="img-raised img-circle">
                                    <h4 class="title">Johan Camilo Quiroga<br />
                                        <small class="text-muted">Desarrollador</small>
                                    </h4>
                                    <p>El desarrollo de esta plataforma representa un gran desafío que da como resultado un lugar donde comprar los mejores cafés especiales y conectar con el paisaje cultural cafetero.</p>
                                    <a href="mailto:quirogacj@utp.edu.co" class="btn btn-simple btn-just-icon"><i class="fa fa-fw fa-envelope"></i></a>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="team-player">
                                    <img src="{{ asset('img/william.jpg') }}" alt="Thumbnail Image" class="img-raised img-circle">
                                    <h4 class="title">William Andrés Salazar<br />
                                        <small class="text-muted">Comercial</small>
                                    </h4>
                                    <p>La principal meta de esta plataforma es promover los cafés especiales del paisaje cultural cafetero a compradores de todo el mundo.</p>
                                    <a href="mailto:w.as.g@utp.edu.co" class="btn btn-simple btn-just-icon"><i class="fa fa-fw fa-envelope"></i></a>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="team-player">
                                    <img src="{{ asset('img/jimy.jpg') }}" alt="Thumbnail Image" class="img-raised img-circle">
                                    <h4 class="title">Jimy Andrés Alzate<br />
                                        <small class="text-muted">Diseñador</small>
                                    </h4>
                                    <p>Te presentamos una plataforma elegante y cómoda que te abrirá las puertas hacia un mundo de nuevos sabores.</p>
                                    <a href="mailto:jimyandres@utp.edu.co" class="btn btn-simple btn-just-icon"><i class="fa fa-fw fa-envelope"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="section landing-section" id="registration">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <h2 class="text-center title">¡Regístrate!</h2>
                            <h4 class="text-center">Si estás interesado en comprar con nosotros regístrate <a href="{{ route('register') }}" target="_blank" style="text-decoration: underline">aquí</a>, o si eres un caficultor y deseas ofrecer tus productos en nuestra plataforma, regístrate <a href="{{ config('app.provider_form') }}" target="_blank" style="text-decoration: underline">aquí</a>.</h4>
                        </div>
                    </div>
                </div>

                <div class="section landing-section" id="contact-us">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <h2 class="text-center title">¡Dinos tu opinión!</h2>
                            <h4 class="text-center">¿Tienes alguna duda o sugerencia? O simplemente cuéntanos qué piensas acerca del proyecto!</h4>
                            <form class="contact-form" action="{{ url('/') }}" method="POST" id="contact-form">
                                {!! csrf_field() !!}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group label-floating{{ $errors->has('name') ? ' has-error' : '' }}">
                                            <label class="control-label">Tu Nombre</label>
                                            <input name="name" type="text" value="{{ old('name') }}" class="form-control validate" required>
                                            @if ($errors->has('name'))
                                                <span class="material-icons form-control-feedback">clear</span>
                                                <small class="text-danger"><strong>{{ $errors->first('name') }}</strong></small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group label-floating{{ $errors->has('email') ? ' has-error' : '' }}">
                                            <label class="control-label">Tu Email</label>
                                            <input name="email" type="email" value="{{ old('email') }}" class="form-control validate" required>
                                            @if ($errors->has('email'))
                                                <span class="material-icons form-control-feedback">clear</span>
                                                <small class="text-danger"><strong>{{ $errors->first('email') }}</strong></small>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group label-floating{{ $errors->has('message') ? ' has-error' : '' }}">
                                    <label class="control-label">Tu Mensaje</label>
                                    <textarea name="message" class="form-control validate" rows="4" required>{{ old('message') }}</textarea>
                                    @if ($errors->has('message'))
                                        <span class="material-icons form-control-feedback">clear</span>
                                        <small class="text-danger"><strong>{{ $errors->first('message') }}</strong></small>
                                    @endif
                                </div>

                                <div class="row">
                                    <div class="col-md-4 col-md-offset-4 text-center">
                                        <button class="btn btn-primary btn-raised">
                                            Enviar Mensaje
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="section landing-section">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <h2 class="text-center title">¡Gracias por apoyarnos!</h2>
                            <div class="row sharing-area text-center">
                                <button id="twitter" class="btn btn-raised btn-twitter">
                                    <i class="fa fa-twitter"></i>
                                    Tweet
                                </button>
                                <button id="facebook" class="btn btn-raised btn-facebook">
                                    <i class="fa fa-facebook-square"></i>
                                    Share
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

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
                                                <a target="_blank" href="{{ config('app.fb') }}" data-toggle="tooltip" data-placement="right" title="{{ config('app.name') }} en Facebook"><i class="fa fa-fw fa-facebook-official"></i> {{ config('app.name') }}</a>
                                            </li>
                                            <li style="display: block;">
                                                <a target="_blank" href="{{ config('app.twitter') }}" data-toggle="tooltip" data-placement="right" title="{{ config('app.name') }} en Twitter"><i class="fa fa-fw fa-twitter"></i> {{ config('app.name') }}</a>
                                            </li>
                                            <li style="display: block;">
                                                <a href="mailto:{{ config('mail.username') }}" data-toggle="tooltip" data-placement="right" title="E-mail {{ config('app.name') }}"><i class="fa fa-fw fa-envelope"></i> {{ config('mail.username') }}</a>
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
                    &copy; <script>document.write(new Date().getFullYear())</script>, hecho por <a href="http://johanquiroga.me" target="_blank">Johan Quiroga</a> y <a href="http://jimyandres.me" target="_blank">Jimy Andrés</a> para <a href="{{url('/')}}">{{ config('app.name') }}</a>
                </div>
            </div>
        </footer>

    </div>
@endsection

@section('scripts')
    @parent
    <script src="{{ asset('js/material-dashboard.js') }}" type="text/javascript"></script>

    <!-- Control Center for Material Kit: activating the ripples, parallax effects, scripts from the example pages etc -->
    <script src="{{ asset('js/material-kit.js') }}" type="text/javascript"></script>

    <script src="{{asset('js/bootstrap-notify.min.js')}}" type="text/javascript"></script>

    <script src="{{ asset('js/jquery.sharrre.js') }}" type="text/javascript"></script>

    @if(session('message-success'))
        <script type="text/javascript">
            $(document).ready(function () {
                $.notify('{{session('message-success')}}', {
                    type: 'success'
                });
            });
        </script>
    @elseif(count($errors) > 0)
        <script type="text/javascript">
            $(document).ready(function () {
                $.notify('Algo ha salido mal!', {
                    type: 'danger'
                });
            });
        </script>
    @endif

    <script type="text/javascript">
        $().ready(function() {
            $('#twitter').sharrre({
                share: {
                    twitter: true
                },
                enableHover: false,
                enableTracking: true,
                buttons: { twitter: {
                    via: 'TerraQuimbaya',
                    hashtags: 'SpecialtyCoffee Coffee',
                }},
                click: function(api, options){
                    api.simulateClick();
                    api.openPopup('twitter');
                },
                template: '<i class="fa fa-twitter"></i> Tweet',
                url: '{{ url('/') }}',
                text: 'Check this awesome specialty coffee project'
            });

            $('#facebook').sharrre({
                share: {
                    facebook: true
                },
                enableHover: false,
                enableTracking: true,
                click: function(api, options){
                    api.simulateClick();
                    api.openPopup('facebook');
                },
                template: '<i class="fa fa-facebook-square"></i> Share',
                url: '{{ url('/') }}',
                text: 'Check this awesome specialty coffee project',
                title: "{{ config('app.name') }}, biotrade store"
            });
        });
    </script>
@endsection