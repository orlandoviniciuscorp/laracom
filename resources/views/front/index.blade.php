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
                            <span>Categorias</span>
                        </div>
                        <ul>
                            @foreach($cats as $cat)
                                <li><a href="{{route('front.category.slug',$cat->slug)}}">
                                        {{$cat->name}}</a></li>
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
                                <a href='{{env('WHATSAPP_GROUP')}}'>
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
        <section class="categories">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title">
                            <h2>Novidades</h2>
                        </div>
                    </div>
                    <div class="row categories__slider owl-carousel">
                        @foreach($newestProducts as $product)
                        <div class="col-lg-3">
                            <div class="categories__item set-bg" data-setbg="{{asset("storage/$product->cover")}}">
                                <h5><a href="{{route('front.get.product',$product->slug)}}">
                                        {{$product->name}}</a></h5>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <section class="featured spad" style="margin-top: 100px">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title">
                            <h2>Promoções</h2>
                        </div>
                    </div>
                </div>
                <div class="row featured__filter">
                    @foreach($producsInPromotion as $product)
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <div class="product__item">
                                <div class="product__item__pic set-bg" data-setbg="{{asset("storage/$product->cover")}}">
                                    <ul class="product__item__pic__hover">
                                        <li>
                                            <form name="form_{{$product->slug}}" id="form_{{$product->slug}}"
                                                  action="{{ route('cart.store') }}" class="form-inline" method="post" ">
                                            {{ csrf_field() }}
                                            <div class="pro-qty">
                                                <input type="text" value="1" name="quantity" >
                                            </div>
                                            <input type="hidden" name="product" value="{{ $product->id }}">
                                            <button id="add-to-cart-btn" name="add-to-cart-btn" type="submit" class="btn btn-success"
                                                    @if($product->quantity < 1)
                                                    disabled
                                                    @else
                                                    onclick="sendAjax('form_{{$product->slug}}')"
                                                    @endif
                                                    data-toggle="modal" data-target="#cart-modal">
                                                <i class="fa fa-cart-plus">
                                                    @if($product->quantity < 1)
                                                        Esgotado
                                                    @else
                                                        Comprar
                                                    @endif
                                                </i>
                                            </button>
                                            </form>
                                        </li>

                                    </ul>
                                </div>
                                <div class="product__item__text">
                                    <h6><a href="{{route('front.get.product',$product->slug)}}">{{$product->name}}</a></h6>
                                    <h5>R${{$product->price}}</h5>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div>

                    </div>
                </div>
                <div class="row justify-content-center">
                    <h4>Quer ver mais produtos?</h4>
                </div>
                <div class="row justify-content-center" style="margin-top: 20px">
                    <a href="{{route('product.list')}}" class="primary-btn">Clique aqui.</a>
                </div>


            </div>
        </section>
    @else
    @include('front.closed')
    @endif

@endsection
@section('post-script')
{{--    {{dd(env('SHOW_INITIAL_MESSAGE'))}}--}}
    @if($config->show_message)
    <script>
        var content = document.createElement('div');
        content.innerHTML = '{!! preg_replace( "/\r|\n/", "", $config->message ) !!}';

        $(window).on('load',function(){
            swal({
                title: 'Atenção',
                content: content,
                icon: "warning",
            })
        });
    </script>
    @endif
@endsection