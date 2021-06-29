@extends('layouts.front.app')
@section('content')
@include('layouts.front.category-nav')
@if($config->is_open == 1)

<section class="product spad" style="padding-top: 0px">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-5">
                <div class="sidebar">
                    <div class="sidebar__item">
                        <h4>Categorias</h4>
                        <ul>
                            @foreach($cats as $cat)
                            <li><a href="{{route('front.category.slug',$cat->slug)}}">{{$cat->name}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    @isset($newestProducts)
                    <div class="sidebar__item">
                        <div class="latest-product__text">
                            <h4>Novidades</h4>
                            <div class="latest-product__slider owl-carousel">
                                @foreach($newestProducts as $product)
                                <div class="latest-prdouct__slider__item">
                                    <a href="{{route('front.get.product',$product->slug)}}" class="latest-product__item">
                                        <div class="latest-product__item__pic">
                                            <img src="{{asset("storage/$product->cover")}}" width="" alt="">
                                        </div>
                                        <div class="latest-product__item__text">
                                            <h6>{{$product->name}}</h6>
                                            <span>R$ {{$product->price}}</span>
                                        </div>
                                    </a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endisset
                </div>
            </div>


            <!--new section -->
            <div class="featured spad" style="width: 75%">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            @isset($category)
                            <div class="section-title">
                                <h2>

                                        {{$category->name}}

                                </h2>
                            </div>
                            @endisset
{{--                            @isset($cats)--}}
{{--                                <div class="featured__controls">--}}
{{--                                    <ul>--}}
{{--                                        @foreach($cats as $cat)--}}
{{--                                            <li class="--}}
{{--                                        @isset($category)--}}
{{--                                        @if($cat->id == $category->id)--}}
{{--                                                active--}}
{{--                                        @endif--}}
{{--                                        @endisset--}}
{{--                                                    "onclick="location.href = '{{route('front.category.slug',$cat->slug)}}'">--}}
{{--                                                <a id="#category_teste" href="{{route('front.category.slug',$cat->slug)}}">--}}
{{--                                                    {{$cat->name}}--}}
    {{--                                            </a>--}}
{{--                                            </li>--}}
{{--                                        @endforeach--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                            @endisset--}}
                        </div>
                    </div>
                    <div class="row justify-content-center"  style="margin-bottom: 15px">
                        @isset($category)
                            {!! $category->description !!}
                        @endif
                    </div>
                    <div class="row featured__filter">

                        @foreach($products as $product)
                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="product__item">
                                    <div class="product__item__pic set-bg" data-setbg="{{asset("storage/$product->cover")}}">
                                        <ul class="product__item__pic__hover">
                                            <li>
                                                <form name="form_{{$product->slug}}" id="form_{{$product->slug}}"
                                                      action="{{ route('cart.store') }}" class="form-inline" method="post" >
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
                    </div>
                </div>
            </div>
            <!-- old section -->

            <div class="col-lg-12 col-md-12 ">



                <div class="row">


                </div>
                <div class="row justify-content-center">
{{--                    {{$products->links()}}--}}
                </div>
                    <br />
            </div>
        </div>

    </div>
</section>
<!-- Product Section End -->
@endsection
@section('post-script')
    {{--<script type="text/javascript">--}}
        {{--$(document).ready(function() {--}}
        {{--});--}}
            {{--function sendAjax(formId) {--}}
                {{--// this is the id of the form--}}

                    {{--idf = "#" + formId;--}}

                    {{--$(idf).ready(function () {--}}
                    {{--});--}}

                    {{--$(idf).submit(function (e) {--}}

                        {{--e.preventDefault(); // avoid to execute the actual submit of the form.--}}


                        {{--var url = '{{route('front.add.cart')}}'--}}

                        {{--$.ajax({--}}
                            {{--type: "POST",--}}
                            {{--url: url,--}}
                            {{--data: $(idf).serialize(),--}}
                            {{--success: function (data) {--}}
                                {{--console.log(data);--}}
                                {{--//alert(data); // show response from the php script.--}}
                            {{--}--}}
                        {{--});--}}


                    {{--});--}}
            {{--}--}}

    {{--</script>--}}

    @else
        @include('front.closed')
    @endif
@endsection
