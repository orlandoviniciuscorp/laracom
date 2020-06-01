@extends('layouts.front.app')

@section('og')
    <meta property="og:type" content="home"/>
    <meta property="og:title" content="{{ config('app.name') }}"/>
    <meta property="og:description" content="{{ config('app.name') }}"/>
    <meta property="og:image" itemprop="image" content="https://organicosaat.com.br/img/logo_feira.jpg">

@endsection

@section('content')
    <!-- Hero Section Begin -->
    @if($config->is_open == 1)

    <div class="hero__item set-bg" data-setbg="img/hero/banner.jpg">
        <div class="hero__text">
            <span>Produtos Frescos</span>
            <h2>Produtos Orgânicos <br /> Diretamente do Produtor</h2>
            <a href="#" class="primary-btn">Compre agora!</a>
        </div>
    </div>
    <!-- Hero Section End -->
    @else
    @include('front.closed')
    @endif

    {{--<!-- Categories Section Begin -->--}}
    {{--<section class="categories">--}}
        {{--<div class="container">--}}
            {{--<div class="row">--}}
                {{--<div class="categories__slider owl-carousel">--}}
                    {{--<div class="col-lg-3">--}}
                        {{--<div class="categories__item set-bg" data-setbg="img/categories/cat-1.jpg">--}}
                            {{--<h5><a href="#">Fresh Fruit</a></h5>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="col-lg-3">--}}
                        {{--<div class="categories__item set-bg" data-setbg="img/categories/cat-2.jpg">--}}
                            {{--<h5><a href="#">Dried Fruit</a></h5>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="col-lg-3">--}}
                        {{--<div class="categories__item set-bg" data-setbg="img/categories/cat-3.jpg">--}}
                            {{--<h5><a href="#">Vegetables</a></h5>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="col-lg-3">--}}
                        {{--<div class="categories__item set-bg" data-setbg="img/categories/cat-4.jpg">--}}
                            {{--<h5><a href="#">drink fruits</a></h5>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="col-lg-3">--}}
                        {{--<div class="categories__item set-bg" data-setbg="img/categories/cat-5.jpg">--}}
                            {{--<h5><a href="#">drink fruits</a></h5>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</section>--}}
    <!-- Categories Section End -->
    {{--@if($config->is_open == 1)--}}
        {{--@foreach($cats as $cat)--}}
            {{--@if($cat->products->isNotEmpty() && $cat->status == 1)--}}
                {{--<section class="new-product t100 home">--}}
                    {{--<div class="container">--}}
                        {{--<div class="section-title b50" id="{{$cat->slug}}">--}}

                            {{--<h2>{{ $cat->name }}</h2>--}}

                        {{--</div>--}}
                        {{--<p class="text-center">--}}
                            {{--<a href="{{ route('cart.index') }}" title="View Cart" class="btn btn-success product-info">--}}
                                {{--Ver carrinho de compras--}}
                            {{--</a>--}}
                        {{--</p>--}}
                        {{--<br/>--}}
                        {{--@include('front.products.product-list', ['products' => $cat->products->where('status', 1),--}}
                                                                 {{--'category_slug'=>$cat->slug])--}}
                        {{--<div id="browse-all-btn"> <a class="btn btn-default browse-all-btn" href="{{ route('front.category.slug', $cat->slug) }}" role="button">Ver todos os ítens do produtor</a></div>--}}
                    {{--</div>--}}
                {{--</section>--}}
            {{--@endif--}}
            {{--<hr>--}}
        {{--@endforeach--}}
        {{--@else--}}
            {{--@include('front.closed')--}}
        {{--@endif--}}
@endsection