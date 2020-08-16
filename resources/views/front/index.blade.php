@include('layouts.front.header-cart')
@extends('layouts.front.app')

@section('og')
    <meta property="og:type" content="home"/>
    <meta property="og:title" content="{{ config('app.name') }}"/>
    <meta property="og:description" content="{{ config('app.name') }}"/>
    <meta property="og:image" itemprop="image" content="https://organicosaat.com.br/img/logo_feira.jpg">

@endsection

@section('content')
    @include('layouts.front.home-slider')
    @if($config->is_open == 1)
    @else
            @include('front.closed')
        @endif
@endsection