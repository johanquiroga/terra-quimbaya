@extends('home')

@section('page', 'landing-page')

@section('header')
    @include('partials.headers.home')
@endsection

@section('styles')
    @parent
    <link href="{{asset('css/custom/custom_material-kit.css')}}" rel="stylesheet"/>
@endsection

@section('main_content')
<div class="main main-raised">
<!--Main layout-->
    <div class="section" id="inner-main">
        <div class="container">
            <h2 class="title">Productos Disponibles</h2>

        <!--Second row-->

            <div class="row">
                <div class="col-md-3">
                    <form id="filters-form" role="form" action="" method="GET">
                        <div class="card card-plain">
                            <div class="card-content">
                                <h4 class="card-title">
                                    Refine
                                    <button type="reset" class="btn btn-default btn-fab btn-fab-mini btn-simple pull-right" rel="tooltip" title="" data-original-title="Reset Filter">
                                        <i class="material-icons">cached</i>
                                    </button>
                                </h4>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingOne">
                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                            <h4 class="panel-title">Rango de Precio
                                                <i class="material-icons" style="float:right">keyboard_arrow_down</i>
                                            </h4>
                                        </a>
                                    </div>
                                    <div id="collapseOne" class="panel-collapse collapse out" role="tabpanel" aria-labelledby="headingOne">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-xs-5 pull-left">
                                                    {{--<div class="input-group">--}}
                                                        {{--<span class="input-group-addon"><i class="material-icons">attach_money</i></span>--}}
                                                        <input class="form-control" value="{{ \Request::has('price-left') ? \Request::input('price-left') : (isset($min_price) ? $min_price : '0') }}" id="input-price-left" name="price-left" type="text">
                                                    {{--</div>--}}
                                                </div>
                                                <div class="col-xs-5 pull-right">
                                                    {{--<div class="input-group">--}}
                                                        {{--<span class="input-group-addon"><i class="material-icons">attach_money</i></span>--}}
                                                        <input class="form-control" value="{{ \Request::has('price-right') ? \Request::input('price-right') : (isset($max_price) ? $max_price : '0') }}" id="input-price-right" name="price-right" type="text">
                                                    {{--</div>--}}
                                                </div>
                                            </div>
                                            {{--<span id="price-left" class="price-left pull-left" data-currency="&dollar;">100</span>

                                            <span id="price-right" class="price-right pull-right" data-currency="&dollar;">850</span>--}}
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div id="sliderRefine" class="slider slider-success"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingTwo">
                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            <h4 class="panel-title">Variedad de Café
                                                <i class="material-icons" style="float:right">keyboard_arrow_down</i>
                                            </h4>
                                        </a>
                                    </div>
                                    <div id="collapseTwo" class="panel-collapse collapse out" role="tabpanel" aria-labelledby="headingTwo">
                                        <div class="panel-body">
                                            @forelse($variedad_cafe as $variedad)
                                                <div class="checkbox">
                                                    <label>
                                                        <input value="{{ $variedad->id }}" name="variedadCafe[]" data-toggle="checkbox" type="checkbox" {{ \Request::has('variedadCafe') ? in_array($variedad->id, \Request::input('variedadCafe')) ? 'checked' : '' : ''}}>
                                                        {{ $variedad->tipo }}
                                                    </label>
                                                </div>
                                            @empty
                                            @endforelse
                                        </div>
                                    </div>
                                </div>

                                @forelse($attributes as $index => $attribute)
                                    @if(!is_null($attribute->opciones))
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="heading{{$index + 2}}">
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$index + 2}}" aria-expanded="false" aria-controls="collapse{{$index + 2}}">
                                                <h4 class="panel-title">{{  ucwords(preg_replace('/(?!^)[A-Z]{2,}(?=[A-Z][a-z])|[A-Z][a-z]|[0-9]{1,}/', ' $0', $attribute->nombreAtributo)) }}
                                                    <i class="material-icons" style="float:right">keyboard_arrow_down</i>
                                                </h4>
                                            </a>
                                        </div>
                                        <div id="collapse{{$index + 2}}" class="panel-collapse collapse out" role="tabpanel" aria-labelledby="heading{{$index + 2}}">
                                            <div class="panel-body">
                                                @foreach($attribute->opciones as $opcion)
                                                    <div class="checkbox">
                                                        <label>
                                                            <input name="{{ $attribute->nombreAtributo }}[]" value="{{ $opcion }}" data-toggle="checkbox" type="checkbox" {{ \Request::has($attribute->nombreAtributo) ? in_array($opcion, \Request::input($attribute->nombreAtributo)) ? 'checked' : '' : ''}}>
                                                            {!! $opcion !!}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                @empty
                                @endforelse

                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingFour">
                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                            <h4 class="panel-title">Ubicación
                                                <i class="material-icons" style="float:right">keyboard_arrow_down</i>
                                            </h4>
                                        </a>
                                    </div>
                                    <div id="collapseFour" class="panel-collapse collapse out" role="tabpanel" aria-labelledby="headingFour">
                                        <div class="panel-body">
                                            @forelse($ubicaciones as $ubicacion)
                                                <div class="checkbox">
                                                    <label>
                                                        <input name="ubicacionFinca" value="{{ $ubicacion->departamento }}" data-toggle="checkbox" type="checkbox" {{ \Request::has('ubicacionFinca') ? (\Request::input('ubicacionFinca') == $ubicacion->departamento ? 'checked' : '') : '' }}>
                                                        {{ $ubicacion->departamento }}
                                                    </label>
                                                </div>
                                            @empty
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer" align="center">
                                <div class="form-group">
                                    <button class="btn btn-primary btn-round">Filtrar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-md-9">
                    <div class="row">
                    @forelse($products as $product)
                        <div class="col-md-4">
                            @include('partials.show_product', ['producto' => $product])
                        </div>
                    @empty
                        <div class="col-md-12">
                            <h2 class="title">No hay productos!!</h2>
                        </div>
                    @endforelse
                    </div>
                    {{--{!! $products->render() !!}--}}
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
        <!--Second row-->
</div>
<!--/.Main layout-->
@endsection

@section('scripts')
    @parent
    <script src="{{asset('js/nouislider.min.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function(){

            $('#filters-form').on('keyup keypress', function(e) {
                var keyCode = e.keyCode || e.which;
                if (keyCode === 13) {
                    e.preventDefault();
                    return false;
                }
            });

            var slider2 = document.getElementById('sliderRefine');
//            var slider2 = $("#sliderRefine");

            noUiSlider.create(slider2, {
                start: [{{ \Request::has('price-left') ? \Request::input('price-left') : (isset($min_price) ? $min_price : '0') }}, {{ \Request::has('price-right') ? \Request::input('price-right') : (isset($max_price) ? $max_price : '0') }}],
                step: 1000,
                connect: true,
                //tooltips: true,
                range: {
                    'min': [{{ isset($min_price) ? $min_price : '0' }}],
                    'max': [{{ isset($max_price) ? $max_price : '0' }}]
                }
                /*format: {
                    to: function ( value ) {
                        return value + ',-';
                    },
                    from: function ( value ) {
                        return value.replace(',-', '');
                    }
                }*/
            });
            /*slider2.noUiSlider({
                start: [42, 880] ,
                connect: true,
//                step: 1,
                behaviour: 'tap',
                range: {
                    'min': 30,
                    'max': 900
                }
            });*/

            /*slider2.create(slider, {
                start: [42, 880],
                connect: true,
                range: {
                    'min': 30,
                    'max': 100
                }
            });*/

            /*slider2.noUiSlider({
                start: [42, 880],
                connect: true,
                range: {
                    'min': [30],
                    'max': [900]
                }
            });*/

            /*var limitFieldMin = document.getElementById('price-left');
            var limitFieldMax = document.getElementById('price-right');*/

            /*slider2.noUiSlider.on('update', function(values, handle ){
                /!*console.log(values);
                console.log(handle);*!/
                if (handle){
                    $("#price-right")["0"].innerText = "$ " + Math.round(values[handle]);
                } else {
                    $("#price-left")["0"].innerText = "$ " + values[handle];
//                    $("#price-right").innerHTML= $("#price-right").data('currency') + Math.round(values[handle]);
                }
            });*/
//            var inputFormat = $("#input-price-left");
            var inputFormatLeft = document.getElementById('input-price-left');
            var inputFormatRight = document.getElementById('input-price-right');
            /*var inputFormatLeft = $("#input-price-left");
            var inputFormatRight = $("#input-price-right");*/

            slider2.noUiSlider.on('update', function( values, handle ) {
                if(handle) {
                    inputFormatRight.value = Math.round(values[handle]);
                } else {
                    inputFormatLeft.value = Math.round(values[handle]);
                }
            });

            inputFormatLeft.addEventListener('change', function(){
                slider2.noUiSlider.set([this.value, null]);
            });

            inputFormatRight.addEventListener('change', function(){
                slider2.noUiSlider.set([null, this.value]);
            });
        });

//        var inputFormat = document.getElementById('input-price-left');

    </script>
@endsection