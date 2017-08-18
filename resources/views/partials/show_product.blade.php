<!--Card-->
<div class="card card-raised" id="{{$producto->nombre}}">
    <!--Card image-->
    <div class="card-image">
        <a href="{{ route('product::show',$producto->idPublicacion) }}">
            <?php $foto = $producto->fotos->first(); ?>
            <img src="{{route('storage::get', $foto->path . $foto->nombreArchivo)}}" class="img-fluid img-responsive" alt="">
        </a>
    </div>
    <!--/.Card image-->

    <!--Card content-->
    <div class="card-body">
        <!--Category & Title-->
        <h5 class="small text-primary text-center"><i class="fa fa-fw fa-coffee"></i> Variedad de Café: {{$producto->variedadCafe->tipo}}</h5>
        <hr>
        <a href="{{ route('product::show',$producto->idPublicacion) }}">
            <h4 class="card-title text-center"><strong>{{$producto->nombre}}</strong></h4>
        </a>
        <!--Rating-->
        <div class="row text-center">
            <input id="calificacion-{{ $producto->idPublicacion }}" name="calificacion" value="{{ $producto->calificacion }}" class="kv-ltr-theme-fa-star rating-loading" data-size="xs">
        </div>

        <!--Description-->
        <p class="description">
            {{ $producto->descripcion }}
        </p>

        <!--Card footer-->
        <?php setlocale(LC_MONETARY, 'es_CO.UTF-8'); ?>
        <div class="footer">
            <span class="" style="float: left">{{money_format('%n', $producto->precioEmpaque) }}</span>
            <a href="{{ route('product::show',$producto->idPublicacion) }}" class="btn btn-simple btn-just-icon btn-round pull-right" rel="tooltip" title="Ver producto"
                    data-placement="left"><i class="material-icons">visibility</i></a>
        </div>
    </div>
</div>
<!--/.Card-->

@section('scripts')
    @parent
    <script>
        $(document).ready(function() {
            $('#calificacion-{{ $producto->idPublicacion }}').rating({displayOnly: true, step: 0.5, theme: 'krajee-fa'});
        });
    </script>
@endsection