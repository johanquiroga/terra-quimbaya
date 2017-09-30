<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Informe #{{ isset($report) ? $report->id : ''}}</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('fonts/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/style-report.css') }}" media="all" />
	<?php setlocale(LC_TIME, 'es_CO.UTF-8'); ?>
	<?php setlocale(LC_MONETARY, 'es_CO.UTF-8'); ?>
    {{--<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>--}}
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    {{--<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>--}}
    <script type="text/javascript">
        function init() {
//            google.charts.load('current', {'packages':['bar']});
//            google.charts.setOnLoadCallback(drawCharts);
            google.load("visualization", "1.1", { packages:["corechart", "bar"], callback: 'drawCharts' });
//            google.charts.load('current', { packages:["corechart", "bar"]});
//            google.charts.setOnLoadCallback(drawCharts);
        }

        function drawCharts() {
            @forelse($usuarios as $usuario)
                var usuario = {!! $usuario->toJson() !!};
                var tipoUsuario = "{{ $usuario instanceof \App\Models\Proveedor ? 'proveedor' : 'comprador' }}";
                drawAccountImpressions('chart-account-impressions-{{ $usuario->id }}', '{{ $usuario->id }}', usuario, tipoUsuario);
            @empty
            @endforelse
        }

        function drawAccountImpressions(containerId, id, usuario, tipoUsuario) {
            var datos = [];
            if(tipoUsuario === 'proveedor') {
                datos.push(['Producto', 'Cantidad', {role: 'annotation'}]);
                if(usuario.productos.length) {
                    usuario.productos.forEach(function (producto) {
                        var cantidad = 0;
                        var suma = 0.0;
                        producto.compras.forEach(function (compra) {
                            cantidad += compra.cantidad;
                            suma += Number(compra.valorTotal);
                        });
                        datos.push([producto.nombre, cantidad, "$ " + suma.formatMoney('2', ',', '.')]);
                    });
                } else {
                    datos.push(["No hay información",0,""]);
                }
                {{--["{{ $producto->nombre }}", {{ $producto->compras->sum('cantidad') }}, "{{ money_format('%n', $producto->compras->sum('valorTotal')) }}"]--}}
            } else {
                datos.push(['Orden', 'Cantidad', {role: 'annotation'}]);
                if(usuario.compras.length) {
                    usuario.compras.forEach(function (compra) {
                        datos.push([compra.nombre, compra.cantidad, "$ " + Number(compra.valorTotal).formatMoney('2', ',', '.')]);
                    });
                } else {
                    datos.push(["No hay información",0,""]);
                }
            }

            var data = google.visualization.arrayToDataTable(datos);

            var options = {
                title: "{{ $usuario instanceof \App\Models\Proveedor ? 'Cantidad de productos vendidos por el vendedor' : 'Compras realizadas por el comprador' }}",
                legend: 'none',
            };

            var chart_div = document.getElementById('chart_div-'+id);
//            var chart = new google.charts.Bar(chart_div);
            var chart = new google.visualization.ColumnChart(chart_div);

            // Wait for the chart to finish drawing before calling the getImageURI() method.
            google.visualization.events.addListener(chart, 'ready', function () {
                chart_div.innerHTML = '<img src="' + chart.getImageURI() + '">';
//                console.log(chart_div.innerHTML);
            });

            chart.draw(data, options);
        }
    </script>
</head>
<body onload="init()">
<div class="container-fluid">
    <header>
        <div class="row" id="logo">
            <img src="{{ asset('img/Logo_Cafe.svg') }}">
        </div>
        <div class="row">
            <h1>Informe #{{ isset($report) ? $report->id : ''}}</h1>
        </div>
        <div class="row">
            <div id="company" class="clearfix">
                <div>Proyecto Café</div>
                <div><a href="mailto:rootproyectocafe@gmail.com">rootproyectocafe@gmail.com</a></div>
            </div>
            <div id="project" class="clearfix">
                <div><span>ADMIN</span> {{ $user->nombres }} {{ $user->apellidos }}</div>
                <div><span>EMAIL</span> <a href="mailto:{{ $user->correoElectronico }}">{{ $user->correoElectronico }}</a></div>
                <div><span>FECHA</span> {{ isset($report) ? $report->fechaGeneracion->formatLocalized('%A %d de %B de %Y') : \Carbon\Carbon::now()->formatLocalized('%A %d de %B de %Y') }}</div>
            </div>
        </div>
    </header>
    <hr>
    @forelse($usuarios as $usuario)

        <section id="usuario-{{ $usuario->id }}">
            <div class="container-fluid">
                <div class="row">
                    <h3 class="title">{{ $usuario instanceof \App\Models\Proveedor ? 'Proveedor' : 'Comprador'}}</h3>
                    <div class="media">
                        <a class="pull-left">
                            @if($usuario instanceof \App\Models\Proveedor)
                            <div class="avatar">
	                            <?php $foto = $usuario->fotos->first(); ?>
                                {{--<img height="120" width="120" class="media-object img-raised img-rounded img-responsive" src="{{ asset("storage/$foto->path/$foto->nombreArchivo") }}">--}}
                                {{--<img height="120" width="120" class="media-object img-raised img-rounded img-responsive" src="{{ app()->isLocal() ? route('storage::get',"$foto->path/$foto->nombreArchivo") : \Storage::url("$foto->path/$foto->nombreArchivo") }}">--}}
                                <img height="120" width="120" class="media-object img-raised img-rounded img-responsive" src="{{ $foto->url }}">
                            </div>
                            @else
                            <i class="fa fa-user fa-3x"></i>
                            @endif
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading">
                                {{ $usuario->nombres }} {{ $usuario->apellidos }}
                            </h4>
                            <h6 class="text-muted"></h6>
                            <ul class="list-unstyled">
                                <li>
                                    <strong>C.C.: </strong>{{ $usuario->id }}
                                </li>
                                <li>
                                    <strong>Telefono: </strong>{{ $usuario->telefono }}
                                </li>
                                @if($usuario instanceof \App\Models\Proveedor)
                                <li>
                                    <strong>Finca: </strong>{{ $usuario->nombreFinca }}
                                </li>
                                <li>
                                    {{ $usuario->ubicacionFinca->vereda }}, {{ $usuario->ubicacionFinca->corregimiento }}<br>
                                    {{ $usuario->ubicacionFinca->ciudad }}, {{ $usuario->ubicacionFinca->departamento }}, {{ $usuario->ubicacionFinca->pais }}
                                </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div id="chart-account-impressions-{{ $usuario->id }}"></div>
                    <div id='chart_div-{{ $usuario->id }}'></div>
                </div>
                <div class="row">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            @if($usuario instanceof \App\Models\Proveedor)
                                <th class="service">ID Publicación</th>
                                <th class="desc">Nombre producto</th>
                                <th>Cantidad vendido</th>
                                <th>Total</th>
                            @else
                                <th class="service">ID Orden</th>
                                <th class="service">ID Publicación</th>
                                <th class="desc">Nombre producto</th>
                                <th>Cantidad comprada</th>
                                <th>Total</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @if($usuario instanceof \App\Models\Proveedor)
                            @forelse($usuario->productos as $producto)
                            <tr>
                                <td class="service">{{ $producto->idPublicacion }}</td>
                                <td class="desc">{{ $producto->nombre }}</td>
                                <td class="qty">{{ $producto->compras->sum('cantidad') }}</td>
                                <td class="total">{{ money_format('%n', $producto->compras->sum('valorTotal')) }}</td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="4">No hay información</td>
                                </tr>
                            @endforelse
                            @if(!$usuario->productos->isEmpty())
                            <tr>
                                <td colspan="3" class="grand total">TOTAL</td>
                                <td class="grand total">{{ money_format('%n', $total[$usuario->id]) }}</td>
                            </tr>
                            @endif
                        @else
                            @forelse($usuario->compras as $compra)
                                <tr>
                                    <td class="service">{{ $compra->idOrden }}</td>
                                    <td class="service">{{ $compra->product->idPublicacion }}</td>
                                    <td class="desc">{{ $compra->product->nombre }}</td>
                                    <td class="qty">{{ $compra->cantidad }}</td>
                                    <td class="total">{{ money_format('%n', $compra->valorTotal) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">No hay información</td>
                                </tr>
                            @endforelse
                            @if(!$usuario->compras->isEmpty())
                            <tr>
                                <td colspan="4" class="grand total">TOTAL</td>
                                <td class="grand total">{{ money_format('%n', $total[$usuario->id]) }}</td>
                            </tr>
                            @endif
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    @empty
    @endforelse
    <hr>
    {{--<footer class="footer">--}}
        {{--<!--Footer Links-->--}}
        {{--<div class="footer-above">--}}
            {{--<div class="container-fluid">--}}
                {{--<div class="row">--}}
                    {{--<!--First column-->--}}
                    {{--<div class="col-md-4">--}}
                        {{--<h5 class="title">Proyecto Café</h5>--}}
                        {{--<p>Descripción del proyecto.</p>--}}
                    {{--</div>--}}
                    {{--<!--/.First column-->--}}
                    {{--<div class="col-md-4">--}}
                        {{--<ul class="list-unstyled">--}}
                            {{--<li>--}}
                                {{--<a href="//www.utp.edu.co/" title="Universidad Tecnológica de Pereira">--}}
                                    {{--<img src="{{asset('img/logo_utp.png')}}" width="90" alt="Escudo Universidad Tecnologica de Pereira">--}}
                                {{--</a>--}}
                                {{--<strong> Universidad Tecnológica de Pereira</strong>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                    {{--<div class="col-md-4">--}}
                        {{--<a href="//isc.utp.edu.co/" title="Ingeniería de Sistemas y Computación">--}}
                            {{--<img src="{{asset('img/logo_isc.png')}}" height="60" width="60" alt="Ingeniería de Sistemas y Computacion">--}}
                        {{--</a>--}}
                        {{--<strong> Ingeniería de Sistemas y Computación</strong>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="footer-below">--}}
            {{--<div class="container-fluid">--}}
                {{--<div class="row-fluid">--}}
                    {{--<div class="col-12 text-right">--}}
                        {{--<!--Copyright-->--}}
                        {{--<p class="copyright">--}}
                            {{--&copy; <script>document.write(new Date().getFullYear())</script> <a href="{{url('/')}}">Proyecto Café</a>, XXXXX--}}
                        {{--</p>--}}
                        {{--<!--/.Copyright-->--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<!--/.Footer Links-->--}}
    {{--</footer>--}}
</div>
</body>
<script src="{{ asset('js/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
<script>
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
</script>
</html>