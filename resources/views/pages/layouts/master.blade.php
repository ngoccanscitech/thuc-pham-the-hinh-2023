<html>
    <head>
        <meta charset="utf-8">
        @yield('title')
        <link href="{{asset('/eshopper/css/bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{asset('/eshopper/css/font-awesome.min.css')}}" rel="stylesheet">
        <link href="{{asset('/eshopper/css/prettyPhoto.css')}}" rel="stylesheet">
        <link href="{{asset('/eshopper/css/price-range.css')}}" rel="stylesheet">
        <link href="{{asset('/eshopper/css/animate.css')}}" rel="stylesheet">
        <link href="{{asset('/eshopper/css/main.css')}}" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('vendors/sweetalert/sweetalert.css')}}"/>
        @yield('css')
    </head>
    <body>
    @include('pages.components.header')

        @yield('content')

    @include('pages.components.footer')

    <script src="{{asset('/eshopper/js/jquery.js')}}"></script>
    <script src="{{asset('/eshopper/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('/eshopper/js/jquery.scrollUp.min.js')}}"></script>
    <script src="{{asset('/eshopper/js/price-range.js')}}"></script>
    <script src="{{asset('/eshopper/js/jquery.prettyPhoto.js')}}"></script>
    <script src="{{asset('/eshopper/js/main.js')}}"></script>
    <script src="{{asset('vendors/sweetalert/sweetalert.js')}}"></script>
    @yield('js')
    </body>
</html>
