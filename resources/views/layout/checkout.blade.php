<html ng-app="app" ng-cloak>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta content="" name="keywords">
        <meta content="" name="description">

        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/site.webmanifest">
        <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#444444">
        <meta name="msapplication-TileColor" content="#444444">
        <meta name="theme-color" content="#444">

        <title>@yield('title')</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,400i,600,700|Raleway:300,400,400i,500,500i,700,800,900" rel="stylesheet">

        <!-- Bootstrap CSS File -->
        <link href="{{ asset('lib/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

        <!-- Libraries CSS Files -->
        <link href="{{ asset('lib/nivo-slider/css/nivo-slider.css') }}" rel="stylesheet">
        <link href="{{ asset('lib/owlcarousel/owl.carousel.css') }}" rel="stylesheet">
        <link href="{{ asset('lib/owlcarousel/owl.transitions.css') }}" rel="stylesheet">
        <link href="{{ asset('lib/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
        <link href="{{ asset('lib/animate/animate.min.css') }}" rel="stylesheet">
        <link href="{{ asset('lib/venobox/venobox.css') }}" rel="stylesheet">

        <!-- Nivo Slider Theme -->
        <link href="{{ asset('css/nivo-slider-theme.css') }}" rel="stylesheet">

        <!-- Main Stylesheet File -->
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">

        <!-- Responsive Stylesheet File -->
        <link href="{{ asset('css/responsive.css') }}" rel="stylesheet">

        <!-- AngularJS -->
        <script src="{{ asset('lib/angular-1.7.9/angular.min.js') }}"></script>
        <script src="{{ asset('app/app.js') }}"></script>
        
        <script>
            angular.module('app').constant('CSRF_TOKEN', '{{ csrf_token() }}');
        </script>

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body data-spy="scroll" data-target="#navbar-example">
        
        @yield('header')
        
        @yield('content')

        @include('shared.footer')

        <!-- JavaScript Libraries -->
        <script src="{{ asset('lib/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('lib/bootstrap/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('lib/knob/jquery.knob.js') }}"></script>
        <script src="{{ asset('lib/wow/wow.min.js') }}"></script>
        <script src="{{ asset('lib/easing/easing.min.js') }}"></script>
        <script src="{{ asset('lib/appear/jquery.appear.js') }}"></script>
        <script src="{{ asset('lib/isotope/isotope.pkgd.min.js') }}"></script>
        
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
        
        <!-- dynamically added scripts -->
        @stack('scripts')
    </body>
</html>