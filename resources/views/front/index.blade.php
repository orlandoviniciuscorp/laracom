@extends('layouts.front.app')

@section('og')
    <meta property="og:type" content="home"/>
    <meta property="og:title" content="{{ config('app.name') }}"/>
    <meta property="og:description" content="{{ config('app.name') }}"/>
    <meta property="og:image" itemprop="image" content="https://organicosaat.com.br/img/logo_feira.png">

@endsection

@section('content')
    <!-- Hero Section Begin -->
    @if($config->is_open == 1)
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="hero__categories">
                        <div class="hero__categories__all">
                            <i class="fa fa-bars"></i>
                            <span>Produtores</span>
                        </div>
                        <ul>
                            @foreach($producers as $producer)
                                <li><a href="{{route('front.producer.slug',$producer->slug)}}">
                                        {{$producer->name}}</a></li>
                            @endforeach

                        </ul>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="hero__search">
                        <div class="hero__search__form">
                            <form action="{{route('search.product')}}">
                                <div class="hero__search__categories">
                                    Buscar
                                    <span class="arrow_carrot-down"></span>
                                </div>
                                <input type="text" name="q" placeholder="Do que você precisa?">
                                <button type="submit" class="site-btn">Buscar</button>
                            </form>
                        </div>

                        <div class="hero__search__phone">
                            <div class="hero__search__phone__icon">
                                <a href='https://chat.whatsapp.com/DPprk8jugf8DxqEs16Qfkv'>
                                    <i class="fa fa-whatsapp"></i>
                                </a>

                            </div>
                            <div class="hero__search__phone__text">
                                <a href='https://chat.whatsapp.com/DPprk8jugf8DxqEs16Qfkv'>
                                    <h5>Whatsapp</h5>
                                </a>
                                <span>Participe do Grupo</span>
                            </div>
                        </div>
                    </div>

                    <div class="hero__item set-bg" data-setbg="img/hero/banner.jpg">
                        <div class="hero__text">
                            <span>Produtos Frescos</span>
                            <h2>Produtos Orgânicos <br /> Diretamente do Produtor</h2>
                            <a href="{{route('product.list')}}" class="primary-btn">Compre agora!</a>
                        </div>
                    </div>
                    <br >
                </div>
            </div>
        </div>

    <!-- Hero Section End -->
    @else
    @include('front.closed')
    @endif
@endsection