
@extends('layouts.front.app')

@section('og')
    <meta property="og:type" content="home"/>
    <meta property="og:title" content="{{ config('app.name') }}"/>
    <meta property="og:description" content="{{ config('app.name') }}"/>
    <meta property="og:image" itemprop="image" content="https://organicosaat.com.br/img/logo_feira.jpg">

@endsection

@section('content')
    Muito Prazer...
    Quem Somos
    Uma plataforma de vendas de alimentos online de produtores iniciantes, do interior, com selo orgânico e ou agroecológicos.
    Nossa Missão
    Oferecer produtos diversificados, muitos deles sem presença no mercado tradicional, a preço justo com entrega a domicílio. Valorizando o pequeno e médio produtor.
    O Que Nos Inspira
    Ter uma despensa repleta de produtos que deem água na boca.
    O Que Nos Move
    Fazer a diferença na despensa do nosso cliente, trazendo facilidade, economia e sabor.
    Nossas Raízes
    Ética e produtos diferenciados.
@endsection