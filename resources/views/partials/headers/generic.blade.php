<div class="header header-filter" style="background-image: url('{{asset("assets-dashboard/img/sidebar-5.jpg")}}');">
    @if(isset($estado))
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 text-center">
                @if($estado != 'rechazada')
                    <h2 class="title">¡Felicitaciones por tu compra!</h2>
                    @if($estado == 'pendiente')
                        {{--<div class="description">--}}
                            <h3>Ahora debes ponerte en contacto con el administrador responsable del producto para completar tu pedido.</h3>
                        {{--</div>--}}
                    @endif
                @else
                    <h2 class="title">Lo sentimos, parece que algo ha salido mal.</h2>
                @endif
            </div>
        </div>
    </div>
    @endif
</div>