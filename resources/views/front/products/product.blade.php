@extends('layouts.front.app')

@section('og')
    <meta property="og:type" content="product"/>
    <meta property="og:title" content="{{ $product->name }}"/>
    <meta property="og:description" content="{{ strip_tags($product->description) }}"/>
    @if(!is_null($product->cover))
        <meta property="og:image" content="{{ asset("storage/$product->cover") }}"/>
    @endif
@endsection


@section('content')
    @include('layouts.front.category-nav')
    @if($config->is_open == 1)
{{--        @include('layouts.front.product')--}}

<section class="product-details spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="product__details__pic">
                    <div class="product__details__pic__item">
                        <img class="product__details__pic__item--large" src="{{ asset("storage/$product->cover") }}" alt="">
                    </div>
                    <div class="product__details__pic__slider owl-carousel owl-loaded owl-drag">

                        <div class="owl-stage-outer">
                            <div class="owl-stage" style="transform:
                        translate3d(-437px, 0px, 0px); transition: all 1.2s ease 0s; width: 1050px;">
                                @foreach($product->images as $image)
                                <div class="owl-item cloned" style="width: 67.5px; margin-right: 20px;">
                                    <img data-imgbigurl="{{asset("storage/$image->src")}}"
                                         src="{{asset("storage/$image->src")}}" alt="">
                                </div>
                                @endforeach
                                    <div class="owl-item cloned" style="width: 67.5px; margin-right: 20px;">
                                        <img data-imgbigurl="{{asset("storage/$product->cover")}}"
                                             src="{{asset("storage/$product->cover")}}" alt="">
                                    </div>

                            </div>
                        </div>
                        <div class="owl-nav disabled">
                            <button type="button" role="presentation" class="owl-prev">
                                <span aria-label="Previous">‹</span>
                            </button>
                            <button type="button" role="presentation" class="owl-next">
                                <span aria-label="Next">›</span>
                            </button>
                        </div>
                        <div class="owl-dots disabled">
                            <button role="button" class="owl-dot active">
                                <span></span></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="product__details__text">
                    <h3>{{$product->name}}</h3>
                    <div class="product__details__rating">
{{--                        <i class="fa fa-star"></i>--}}
{{--                        <i class="fa fa-star"></i>--}}
{{--                        <i class="fa fa-star"></i>--}}
{{--                        <i class="fa fa-star"></i>--}}
{{--                        <i class="fa fa-star-half-o"></i>--}}
{{--                        <span>(18 reviews)</span>--}}
                    </div>
                    <div class="product__details__price">R$ {{$product->price}}</div>
                    <p>{!! $product->description !!}</p>

                    <livewire:products.product :product="$product" wire:key="$product->id"/>

                    <ul>
                        <li><b>Quantidade Disponível:</b> <span>{{$product->quantity}}</span></li>
                        <li><b>Entrega:</b> <span>
                                @if(current_shop() == 1)
                                    Entrega todos os sábados
                                @else
                                    Entrega 4a Feira
                                @endif
                        </li>
{{--                        <li><b>Share on</b>--}}
{{--                            <div class="share">--}}
{{--                                <a href="#"><i class="fa fa-facebook"></i></a>--}}
{{--                                <a href="#"><i class="fa fa-twitter"></i></a>--}}
{{--                                <a href="#"><i class="fa fa-instagram"></i></a>--}}
{{--                                <a href="#"><i class="fa fa-pinterest"></i></a>--}}
{{--                            </div>--}}
{{--                        </li>--}}
                    </ul>
                </div>
            </div>

        </div>
    </div>
</section>

    @else
        @include('front.closed')
    @endif
@endsection