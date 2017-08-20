<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge,chrome=1">
    @yield('title','<title>Terra Quimbaya</title>')
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <link rel="shortcut icon" href="{{ asset('img/icon.png') }}" >
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css">-->
    <!-- Bootstrap core CSS -->
{{--    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">--}}
{{--    <link href="{{asset('assets-dashboard/css/material-kit/bootstrap.min.css')}}" rel="stylesheet">--}}
    <link href="{{asset('assets-dashboard/css/material-dashboard/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('star-rating/css/star-rating.css') }}" media="all" rel="stylesheet" type="text/css" />
    <link href="{{ asset('star-rating/themes/krajee-fa/theme.css') }}" media="all" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.4/css/selectize.bootstrap3.css" />
    {{--<link href="{{asset('assets-dashboard/css/nouislider.min.css')}}" rel="stylesheet">--}}
    <!-- Material Design Bootstrap -->
{{--    <link href="{{asset('css/mdb.css')}}" rel="stylesheet"/>--}}
    {{--<link href="{{asset('assets-dashboard/css/material-dashboard/material-dashboard.css')}}" rel="stylesheet"/>--}}
    {{--<link href="{{asset('assets-dashboard/css/material-kit/material-kit.css')}}" rel="stylesheet">--}}

    {{--<link href="{{asset('material-dashboard/material-dashboard.css')}}" rel="stylesheet"/>--}}

    {{--<link href="{{asset('material-kit/material-kit.css')}}" rel="stylesheet">--}}
    <!-- Your custom styles (optional) -->
    @yield('styles')

    {{--<link href="{{asset('css/style.css')}}" rel="stylesheet">--}}
    <!-- Pusher CSS -->
    <script src="//js.pusher.com/3.0/pusher.min.js"></script>

</head>

<body class="@yield('page', '')">

@yield('body')

@yield('modals')
</body>

<!-- /Start your project here-->

<!-- SCRIPTS -->
<!-- JQuery -->
<script type="text/javascript" src="{{asset('assets-dashboard/js/jquery-3.1.0.min.js')}}"></script>
{{--<script type="text/javascript" src="{{asset('assets-dashboard/js/material-kit/jquery.min.js')}}"></script>--}}
<!-- Bootstrap tooltips -->
{{--<script type="text/javascript" src="{{asset('js/tether.min.js')}}"></script>--}}
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="{{asset('assets-dashboard/js/bootstrap.min.js')}}"></script>
<!-- MDB core JavaScript -->
<script src="{{asset('assets-dashboard/js/material.min.js')}}" type="text/javascript"></script>

<script src="{{ asset('star-rating/js/star-rating.js') }}" type="text/javascript"></script>

<!-- optionally if you need to use a theme, then include the theme JS file as mentioned below -->
<script src="{{ asset('star-rating/themes/krajee-fa/theme.js') }}"></script>

<!-- optionally if you need translation for your language then include locale file as mentioned below -->
<script src="{{ asset('star-rating/js/locales/es.js') }}"></script>
{{--<script type="text/javascript" src="{{asset('js/mdb.min.js')}}"></script>--}}
<!--Plugin for the Datepicker, full documentation here: http://www.eyecon.ro/bootstrap-datepicker/-->
{{--<script src="{{asset('assets-dashboard/js/material-kit/bootstrap-datepicker.js')}}" type="text/javascript"></script>--}}
<!--Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/-->
{{--<script src="{{asset('assets-dashboard/js/material-kit/nouislider.min.js')}}" type="text/javascript"></script>--}}
<!-- Material Dashboard javascript methods -->
{{--<script src="{{asset('assets-dashboard/js/material-kit/material-kit.js')}}" type="text/javascript"></script>--}}

{{--<script src="{{asset('assets-dashboard/js/material-dashboard/material-dashboard.js')}}"></script>--}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.4/js/standalone/selectize.js"></script>

<script>
    $(document).ready(function(){
        var root = '{{url("/search")}}';

        var isMobile = window.matchMedia("only screen and (max-width: 991px)");

        if(! isMobile.matches) {
            $('#searchbox').selectize({
                valueField: 'url',
                searchField: ['nombre', 'nombres', 'apellidos', 'idPublicacion'],
                maxOptions: 10,
                options: [],
                create: false,
                render: {
                    item: function(item, escape) {
                        console.log(item.class);
                        return '<div>' +
                            (item.class === 'product' ? '<span class="title">' + escape(item.nombre) + '</span>' : '<span class="name">' + escape(item.nombres) + ' ' + item.apellidos + '</span>') +
                            '</div>';
                    },
                    option: function(data, escape) {
                        var item = '<div class="media">' +
                            '<div class="media-left"> ' +
                            '<a class="pull-left"><img height="60" width="60" src="{{ route('storage::get', ":PATH/:FILE") }}" alt=""></a>' +
                            '</div>' +
                            '<div class="media-body">' +
                            '<h4 class="media-heading">' +
                            escape((data.class === 'product' ? data.nombre : data.nombres + ' ' + data.apellidos)) +
                            '</h4>' +
                            (data.class === 'product' ? '<p>Por, ' + escape(data.proveedor.nombres) + ' ' + escape(data.proveedor.apellidos) + '</p>' : '<p>Finca: ' + escape(data.nombreFinca) + '</p>') +
                            '</div>' +
                            '</div>';
                        return item.replace(/:PATH/g, escape(data.fotos[0].path)).replace(/:FILE/g, escape(data.fotos[0].nombreArchivo));
                    }
                },
                optgroups: [
                    {value: 'product', label: 'Productos'},
                    {value: 'provider', label: 'Proveedores'}
                ],
                optgroupField: 'class',
                optgroupOrder: ['product','provider'],
                load: function(query, callback) {
                    if (!query.length) return callback();
                    $.ajax({
                        url: root,
                        type: 'GET',
                        dataType: 'json',
                        data: {
                            keyword: query
                        },
                        error: function() {
                            callback();
                        },
                        success: function(res) {
                            callback(res.data);
                        }
                    });
                },
                onChange: function(){
                    window.location = this.items[0];
                }
            });
        } else {
            $('#searchbox').addClass('form-control').parent().append('<button class="btn btn-white btn-round btn-just-icon" type="submit"><i class="material-icons">search</i></button>');
        }
    });
</script>

@yield('scripts')

</html>
