
@extends('home')

@section('page', 'landing-page')

@section('header')
@include('headers.product')
@endsection

@section('styles')
    @parent
    {{--<link href="{{ asset('custom-assets/custom_material-bootstrap-wizard.css')}}" rel="stylesheet" />--}}
    {{--<link href="{{ asset('assets-wizard/css/material-bootstrap-wizard.css')}}" rel="stylesheet" />--}}
    <link href="{{asset('custom-assets/custom_material-kit.css')}}" rel="stylesheet"/>
@endsection

@section('main_content')

{{--<main id="mainContainer">--}}
    <div class="main main-raised">
        <div class="section" id="inner-main">
            <!-- Main Container -->
            <div class="container">
                <section id="productDetails">
                    <div class="row">

                        <div class="col-lg-6">
                            {{--<div class="row">--}}

                            <!-- Carousel Card -->
                            <div class="card card-raised card-carousel">
                                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                                    <div class="carousel slide" data-ride="carousel">

                                        <!-- Indicators -->
                                        <ol class="carousel-indicators">
                                            @for($i=0; $i<count($product->fotos); $i++)
                                            <li data-target="#carousel-example-generic" data-slide-to="{{$i}}" class="{{ $i == 0 ? 'active' : '' }}"></li>
                                            @endfor
                                        </ol>

                                        <!-- Wrapper for slides -->
                                        <div class="carousel-inner">
                                            @foreach($product->fotos as $index => $foto)
                                                <div class="item{{ $index == 0 ? ' active' : '' }}">
                                                    <img src="{{route('storage::get', $foto->path . $foto->nombreArchivo) }}" alt="Imagen_{{$index}}">
                                                </div>
                                            @endforeach
                                        </div>

                                        <!-- Controls -->
                                        <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev"><i class="material-icons">keyboard_arrow_left</i></a>
                                        <a class="right carousel-control" href="#carousel-example-generic" data-slide="next"><i class="material-icons">keyboard_arrow_right</i></a>
                                    </div>
                                </div>
                            </div>
                            <!-- End Carousel Card -->

                            {{--</div>--}}
                            <div class="row">
                                <div class="col-md-8">
                                <h3>
                                    <small>Por,</small>
                                    <a href="{{ route('provider::show',$product->proveedor->id) }}">
                                        <strong>{{ $product->proveedor->nombres }} {{ $product->proveedor->apellidos }}</strong>
                                    </a>
                                </h3>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <h2><strong>{{ $product->nombre }} </strong></h2>
		                    <?php setlocale(LC_MONETARY, 'es_CO.UTF-8'); ?>
                            <h6><input id="calificacion" name="calificacion" value="{{ $product->calificacion }}" class="rating kv-ltr-theme-fa-star rating-loading" data-theme="krajee-fa" data-display-only="true" data-size="xs"></h6>
                            <h4><span><strong>{{money_format('%n', $product->precioEmpaque) }}</strong></span></h4> {{--<span class="grey-text"><small><s>$89</s></small></span></h4>--}}

                            <!--Accordion wrapper-->
                                <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
                                    <div class="card2">
                                        <div class="card-header" role="tab" id="headingOne">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion"
                                               href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                <h5 class="mb-0">
                                                    Descripción <i class="fa fa-angle-down rotate-icon"></i>
                                                </h5>
                                            </a>
                                        </div>
                                        <div id="collapseOne" class="collapse" role="tabpanel"
                                             aria-labelledby="headingOne">
                                            <div class="card-block">
                                                <p>{{ $product->descripcion }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card2">
                                        <div class="card-header" role="tab" id="headingTwo">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion"
                                               href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                <h5 class="mb-0">
                                                    Detalles <i class="fa fa-angle-down rotate-icon"></i>
                                                </h5>
                                            </a>
                                        </div>
                                        <div id="collapseTwo" class="collapse" role="tabpanel"
                                             aria-labelledby="headingTwo">
                                            <div class="card-block">
                                                <ul><strong>Variedad de Café</strong>
                                                    <li class="list-unstyled">{{ $product->variedadCafe->tipo }}</li>
                                                </ul>
                                                @foreach($product->atributos as $atributo)
                                                    <ul>
                                                        <strong>{{ ucwords(preg_replace('/(?!^)[A-Z]{2,}(?=[A-Z][a-z])|[A-Z][a-z]|[0-9]{1,}/', ' $0', $atributo->nombreAtributo)) }}</strong>
                                                        <li class="list-unstyled">{!! $atributo->pivot->valorAtributo !!}</li>
                                                    </ul>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--/.Accordion wrapper-->
                                <br>
                                @can('buy', $product)
                                <!-- Add to Cart -->
                                <div class="card-block">
                                    <div class="row">
                                        <div class="col-md-12 center-on-small-only text-md-right">
                                            @if($product->cantidad > 0 && $product->estado == 1)
                                            <a id="buy-btn" href="#" class="nav-link waves-effect waves-light btn btn-primary"
                                               data-toggle="modal" data-target="#buy-modal" data-cantidad="1"><i
                                                        class="fa fa-shopping-bag" aria-hidden="true"></i> Comprar</a>
                                            @else
                                                <h5>Producto no disponible.</h5>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <!-- /.Add to Cart -->
                                @endcan
                        </div>
                    </div>
                </section>

                <h2 class="heading">Preguntas de Usuarios</h2>

                <!-- Product Questions -->
                <section id="questions">
                    <div class="row">
                        <div class="col-md-12">
                            @forelse($questions as $question)
                                <div class="media">
                                    <a class="pull-left"><i class="fa fa-comment"></i></a>
                                    <div class="media-body">
                                        <h4 class="media-heading">{{ $question->buyer->nombres }} {{ $question->buyer->apellidos }} <small class="text-muted">- {{ $question->created_at->format('d/m/Y H:i') }}</small></h4>
                                        {{--<li class="list-unstyled small text-muted"><i class="fa fa-clock-o"></i> {{ $question->created_at->diffForHumans() }}</li>--}}
                                        <p>{{ $question->consulta }}</p>
                                        @if(isset($question->respuesta))
                                            <div class="media">
                                                <a class="pull-left"><i class="fa fa-comments"></i></a>
                                                <div class="media-body">
                                                    <h4 class="media-heading">Respuesta <small>- {{ $question->updated_at->format('d/m/Y H:i') }}</small></h4>
                                                    <p>{{ $question->respuesta }}</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="media">
                                    <div class="media-body">
                                        <h4 class="media-heading">Este producto aún no tiene preguntas.</h4>
                                    </div>
                                </div>
                            @endforelse
                            {!! $questions->render() !!}
                            @can('postQuestion', $product)
                            @if($product->estado)
                            <!-- The Current User Can Update The Post -->
                            <h3 class="title text-center">Haz tu pregunta</h3>
                            <div class="media media-post">
                                <div class="media-body">
                                    <form role="form" action="{{ route('product::postQuestion', $product->idPublicacion) }}" method="POST">
                                        {!! csrf_field() !!}
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-comment fa-2x text-primary"></i></span>
                                            <div class="form-group label-floating{{ $errors->has('consulta') ? ' has-error' : '' }}">
                                                <label class="control-label" id="consultaLabel" for="consulta" data-error="Incorrecto">Escribe tu pregunta aquí...</label>
                                                <textarea id="consulta" class="form-control validate" name="consulta" rows="6" required aria-describedby="consultaLabel" maxlength="800">{{ old("consulta") }}</textarea>
                                                <strong><small id="charNumconsultaHelp" class="text-muted">Tu pregunta no debe sobrepasar los 800 caracteres. <div id="textarea_feedback"></div></small></strong>
                                            </div>
                                        </div>
                                        <div class="media-footer text-center">
                                            <button class="btn btn-primary btn-round">Publicar Pregunta</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            @endif
                            @endcan
                        </div>
                    </div>
                </section>
                <!-- /.Product Questions -->

                <h2 class="heading">Reseñas del Producto</h2>

                <!-- Product Reviews -->
                <section id="reviews">
                    <div class="row">
                        <div class="col-md-12">
                            @forelse($reviews as $review)
                                <div class="media">
                                    <a class="pull-left">
                                        <i class="fa fa-user fa-3x"></i>
                                    </a>
                                    <div class="media-body">
                                        <h4 class="media-heading">{{ $review->compra->comprador->nombres }} {{ $review->compra->comprador->apellidos }} <small class="text-muted">- {{ $review->created_at->format('d/m/Y H:i') }}</small></h4>
                                        {{--<li class="list-unstyled small text-muted"><i class="fa fa-clock-o"></i> {{ $review->created_at->diffForHumans() }}</li>--}}
                                        <input id="calificacion-{{$review->compra->id}}" name="calificacion-{{$review->compra->id}}" value="{{ $review->calificacion }}" class="rating kv-ltr-theme-fa-star rating-loading" data-theme="krajee-fa" data-display-only="true" data-size="xs" data-step="0.5">
                                        <p>{!! nl2br(e($review->comentario)) !!}</p>
                                    </div>
                                </div>
                            @empty
                                <div class="media">
                                    <div class="media-body">
                                        <h4 class="media-heading">Este producto aún no tiene calificaciones.</h4>
                                    </div>
                                </div>
                        @endforelse
                        {!! $reviews->render() !!}
                        </div>
                    </div>
                </section>
                <!-- /.Product Reviews -->
            </div>
        </div>
    </div>
    <!-- /.Main Container -->
{{--</main>--}}

@endsection

@section('modals')
    @parent
    <!-- Cart Modal -->

    @can('buy', $product)
    @if($product->cantidad > 0)
    <div class="modal fade cart-modal" id="buy-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <!--Content-->
            <div class="modal-content">
                <!--Header-->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Tu compra</h4>
                </div>
                <!--Body-->
                <div class="modal-body">
                    <form method="GET" action="{{ route('purchase::buy', $product->idPublicacion) }}">
                        <div class="row">
                            <div class="table-responsive">
                                <table id="purchase-table" class="table table-hover table-condensed">
                                    <thead>
                                    <tr>
                                        <th class="text-center">ID</th>
                                        <th class="text-center">Producto</th>
                                        <th class="text-center">Precio</th>
                                        <th class="text-center">Cantidad</th>
                                        <th class="text-center">Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th class="text-center" id="id" scope="row">{{ $product->idPublicacion }}</th>
                                        <td class="text-center" id="product">{{ $product->nombre }}</td>
                                        <td class="text-center" id="price">{{money_format('%n', $product->precioEmpaque) }}</td>
                                        <td class="text-center" id="cantidad">
                                            <input type="number" id="cantidad" name="cantidad" value="1" min="1" max="{{ $product->cantidad }}" class="form-control" required>
                                        </td>
                                        <td id="total" class="text-center"></td>
                                    </tr>
                                    <tr id="purchase-info">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-right">
                                            <p>
                                                <strong>Subtotal:</strong>
                                            </p>
                                            <p>
                                                <strong>IVA:</strong>
                                            </p>
                                        </td>
                                        <td id="total" class="text-center">
                                            <p id="subtotal">

                                            </p>
                                            <p id="iva">

                                            </p>
                                        </td>
                                    </tr>
                                    <tr id="total-info">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-right">
                                            <h4>
                                                <p>
                                                    <strong>Total:</strong>
                                                </p>
                                            </h4>
                                        </td>
                                        <td id="total" class="text-center">
                                            <h4>
                                                <p id="total">
                                                    <strong> </strong>
                                                </p>
                                            </h4>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="title">
                                <h3>Selecciona tu método de pago preferido:</h3>
                            </div>
                            <div class="col-sm-10 col-sm-offset-1">
                                @foreach($metodos_pago as $metodo)
                                    <div class="col-sm-4 text-center">
                                        <div class="choice {{ $metodo->metodo == 'Contraentrega' ? 'active' : '' }}" data-toggle="wizard-radio" rel="tooltip" title="" data-original-title="{{ $metodo->metodo == 'Contraentrega' ? 'Selecciona esta opción para realizar pagos contraentrega. Solamente disponible para compradores en Pereira o Dosquebradas, Risaralda.' : 'Selecciona esta opción para realizar pagos con tarjetas o transferencias bancarias.' }}">
                                            <input type="radio" name="metodoPago" value="{{ $metodo->id }}" required {{ ($metodo->metodo == 'Contraentrega') ? (($user->direccion->ciudad == 'PEREIRA' || $user->direccion->ciudad == 'DOSQUEBRADAS') ? '' : 'disabled') : '' }}>
                                            <div class="icon">
                                                @if($metodo->metodo == 'Contraentrega')
                                                    <i class="material-icons">attach_money</i>
                                                @else
                                                    <i class="material-icons">credit_card</i>
                                                    <i class="material-icons">account_balance</i>
                                                @endif
                                            </div>
                                            <h6>{{ $metodo->metodo }}</h6>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md">
                                <h3>Nota:</h3>
                                <p>La dirección asociada a tu cuenta será la que utilizaremos para procesar este pedido, si dicha información no es correcta por favor actualizarla antes de continuar con la compra.</p>
                            </div>
                        </div>
                        <button class="btn btn-primary">Comprar</button>
                    </form>

                </div>
                <!--Footer-->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!--/.Content-->
        </div>
    </div>
    <!-- /.Cart Modal -->
    @endif
    @endcan
@endsection

@section('scripts')
    @parent

    <!--  Notifications Plugin    -->
    <script src="{{ asset('assets-dashboard/js/material-dashboard/bootstrap-notify.js') }}"></script>

    {{--<script src="{{ asset('assets-wizard/js/jquery.bootstrap.js')}}" type="text/javascript"></script>--}}

    {{--<!--  Plugin for the Wizard -->--}}
    {{--<script src="{{ asset('assets-wizard/js/material-bootstrap-wizard.js')}}"></script>--}}

    {{--<script src="{{ asset('assets-wizard/js/jquery.validate.min.js')}}"></script>--}}

    <script>
        $(document).ready(function() {
            Number.prototype.formatMoney = function(c, d, t){
                var n = this,
                    c = isNaN(c = Math.abs(c)) ? 2 : c,
                    d = d == undefined ? "." : d,
                    t = t == undefined ? "," : t,
                    s = n < 0 ? "-" : "",
                    i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
                    j = (j = i.length) > 3 ? j % 3 : 0;
                return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
            };

//            $('#calificacion').rating({displayOnly: true, step: 0.5, theme: 'krajee-fa'});

            var text_max = 800;
            $('#textarea_feedback').html(text_max + ' caracteres restantes');

            $('#consulta').keyup(function() {
                var text_length = $('#consulta').val().length;
                var text_remaining = text_max - text_length;

                $('#textarea_feedback').html(text_remaining + ' caracteres restantes');
            });

            var precio = {{ $product->precioEmpaque }};
            $("#buy-modal").on('show.bs.modal', function () {
                var cant = $(this).find('.modal-body tr input#cantidad').val();
                var total = precio * cant;
                var iva = total * 0.19;
                $(this).find('.modal-body table tbody tr:first td#total').text('$ '+total.formatMoney(2, ',', '.'));// tr:first td#total').text('$ '+total));
                $(this).find('.modal-body tr#purchase-info td#total p#subtotal').text('$ '+total.formatMoney(2, ',', '.'));
                $(this).find('.modal-body tr#purchase-info td#total p#iva').text('$ '+iva.formatMoney(2, ',', '.'));
                $(this).find('.modal-body tr#total-info td#total h4 p#total strong').text('$ '+(total + iva).formatMoney(2, ',', '.'));
            });

            $(".modal-body input#cantidad").on('change', function (event) {
                var tr = $(this).closest('tr');
                var cant = event.target.value;
                var total = precio * cant;
                var iva = total * 0.19;
                tr.find('#total').text('$ '+total.formatMoney(2, ',', '.'));
                $(this).closest('table').find('tbody tr#purchase-info td#total p#subtotal').text('$ '+total.formatMoney(2, ',', '.'));
                $(this).closest('table').find('tbody tr#purchase-info td#total p#iva').text('$ '+iva.formatMoney(2, ',', '.'));
                $(this).closest('table').find('tbody tr#total-info td#total h4 p#total strong').text('$ '+(total + iva).formatMoney(2, ',', '.'));
            });
        });
    </script>
    <script>
    </script>
@endsection