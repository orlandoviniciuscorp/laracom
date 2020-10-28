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


                    <form name="form_{{$product->slug}}" id="form_{{$product->slug}}"
                          action="{{ route('cart.store') }}" class="form-inline" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="product" value="{{ $product->id }}">





                    <div class="product__details__quantity">
                        <div class="quantity">
                            <div class="pro-qty">
                                <input type="text" name="quantity"value="1">
                            </div>
                        </div>
                    </div>
                    <button id="add-to-cart-btn" name="add-to-cart-btn" type="submit" class="btn btn-success"
                            @if($product->quantity < 1)
                            disabled
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

                    <ul>
                        <li><b>Quantidade Disponível:</b> <span>{{$product->quantity}}</span></li>
                        <li><b>Entrega:</b> <span>Entrega todos os sábados</li>
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
            <div class="col-lg-12">
                <div class="product__details__tab">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab" aria-selected="true">Descrição</a>
                        </li>

                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tabs-1" role="tabpanel">
                            <div class="product__details__tab__desc">
                                <h6>Descrição</h6>
                                <p>{!! $product->description !!}</p>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabs-2" role="tabpanel">
                            <div class="product__details__tab__desc">
                                <h6>Products Infomation</h6>
                                <p>Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui.
                                    Pellentesque in ipsum id orci porta dapibus. Proin eget tortor risus.
                                    Vivamus suscipit tortor eget felis porttitor volutpat. Vestibulum ac diam
                                    sit amet quam vehicula elementum sed sit amet dui. Donec rutrum congue leo
                                    eget malesuada. Vivamus suscipit tortor eget felis porttitor volutpat.
                                    Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Praesent
                                    sapien massa, convallis a pellentesque nec, egestas non nisi. Vestibulum ac
                                    diam sit amet quam vehicula elementum sed sit amet dui. Vestibulum ante
                                    ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;
                                    Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula.
                                    Proin eget tortor risus.</p>
                                <p>Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Lorem
                                    ipsum dolor sit amet, consectetur adipiscing elit. Mauris blandit aliquet
                                    elit, eget tincidunt nibh pulvinar a. Cras ultricies ligula sed magna dictum
                                    porta. Cras ultricies ligula sed magna dictum porta. Sed porttitor lectus
                                    nibh. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a.</p>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabs-3" role="tabpanel">
                            <div class="product__details__tab__desc">
                                <h6>Products Infomation</h6>
                                <p>Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui.
                                    Pellentesque in ipsum id orci porta dapibus. Proin eget tortor risus.
                                    Vivamus suscipit tortor eget felis porttitor volutpat. Vestibulum ac diam
                                    sit amet quam vehicula elementum sed sit amet dui. Donec rutrum congue leo
                                    eget malesuada. Vivamus suscipit tortor eget felis porttitor volutpat.
                                    Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Praesent
                                    sapien massa, convallis a pellentesque nec, egestas non nisi. Vestibulum ac
                                    diam sit amet quam vehicula elementum sed sit amet dui. Vestibulum ante
                                    ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;
                                    Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula.
                                    Proin eget tortor risus.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    @else
        @include('front.closed')
    @endif
@endsection