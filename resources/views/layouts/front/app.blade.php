<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Orgânicos da AAT">
    <meta name="keywords" content="Orgânicos, AAT, Teresópolis">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{env('APP_NAME')}}</title>
    {{--<script src="{{ asset('js/front.min.js') }}"></script>--}}
{{--    <script src="{{ asset('js/custom.js') }}"></script>--}}
@yield('js')
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('css/elegant-icons.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('css/nice-select.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('css/owl.carousel.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('css/slicknav.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('css/style.css')}}" type="text/css">
</head>

<body>
{{--<noscript>--}}
    {{--<p class="alert alert-danger">--}}
        {{--You need to turn on your javascript. Some functionality will not work if this is disabled.--}}
        {{--<a href="https://www.enable-javascript.com/" target="_blank">Read more</a>--}}
    {{--</p>--}}
{{--</noscript>--}}
{{--<section>--}}
    {{--<div class="hidden-xs">--}}
        {{--<div class="container">--}}
            {{--<div class="clearfix"></div>--}}
            {{--<div class="pull-right">--}}
                {{--<ul class="nav navbar-nav navbar-right">--}}
                    {{--@if(auth()->check())--}}
                        {{--<li><a href="{{ route('accounts', ['tab' => 'profile']) }}"><i class="fa fa-home"></i> Minha Conta</a></li>--}}
                        {{--<li><a href="{{ route('logout') }}"><i class="fa fa-sign-out"></i> Sair</a></li>--}}
                    {{--@else--}}
                        {{--<li><a href="{{ route('login') }}"> <i class="fa fa-lock"></i> Login</a></li>--}}
                        {{--<li><a href="{{ route('register') }}"> <i class="fa fa-sign-in"></i> Registrar</a></li>--}}
                    {{--@endif--}}
                    {{--<li id="cart" class="menubar-cart">--}}
                        {{--<a href="{{ route('cart.index') }}" title="View Cart" class="awemenu-icon menu-shopping-cart">--}}
                            {{--<i class="fa fa-shopping-cart" aria-hidden="true"></i>--}}
                            {{--<span class="cart-number">{{ $cartCount }}</span>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                {{--</ul>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
    {{--<header id="header-section">--}}
        {{--<nav class="navbar navbar-default">--}}
            {{--<div class="container">--}}
                {{--<!-- Brand and toggle get grouped for better mobile display -->--}}
                {{--<div class="navbar-header col-md-2">--}}
                    {{--<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">--}}
                        {{--<span class="sr-only">Toggle navigation</span>--}}
                        {{--<span class="icon-bar"></span>--}}
                        {{--<span class="icon-bar"></span>--}}
                        {{--<span class="icon-bar"></span>--}}
                    {{--</button>--}}
                    {{--<a class="navbar-brand" href="{{ route('home') }}">--}}
                    {{--{{ config('app.name') }}</a>--}}

                {{--</div>--}}
                {{--<div class="col-md-10">--}}
                    {{--@include('layouts.front.header-cart')--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</nav>--}}
    {{--</header>--}}
{{--</section>--}}
@include('layouts.front.header')

@yield('content')

@include('layouts.front.footer')