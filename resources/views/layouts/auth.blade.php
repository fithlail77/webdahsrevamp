<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Dashboard') }}</title>

    <!-- Fonts -->
    <link href="{{ asset('loginpage/asset/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('loginpage/asset/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- Favicon -->
    <link href="{{ asset('loginpage/asset/img/gum.png') }}" rel="icon" type="image/png">
</head>
<body class="bg-gradient-primary min-vh-100 d-flex justify-content-center align-items-center">

    @yield('main-content')

    <!-- Scripts -->
    <script src="{{ asset('loginpage/asset/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('loginpage/asset/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('loginpage/asset/js/sb-admin-2.min.js') }}"></script>
</body>
</html>