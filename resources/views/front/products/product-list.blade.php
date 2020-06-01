@extends('layouts.front.app')
@section('content')
    <!-- Breadcrumb Section Begin -->
    {{--<section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb.jpg">--}}
        {{--<div class="container">--}}
            {{--<div class="row">--}}
                {{--<div class="col-lg-12 text-center">--}}
                    {{--<div class="breadcrumb__text">--}}
                        {{--<h2>Organi Shop</h2>--}}
                        {{--<div class="breadcrumb__option">--}}
                            {{--<a href="./index.html">Home</a>--}}
                            {{--<span>Shop</span>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</section>--}}
<!-- Product Section Begin -->
<section class="product spad">
    <div class="container">
        <div class="row">
            {{--<div class="col-lg-3 col-md-5">--}}
                {{--<div class="sidebar">--}}
                    {{--<div class="sidebar__item">--}}
                        {{--<h4>Department</h4>--}}
                        {{--<ul>--}}
                            {{--<li><a href="#">Fresh Meat</a></li>--}}
                            {{--<li><a href="#">Vegetables</a></li>--}}
                            {{--<li><a href="#">Fruit & Nut Gifts</a></li>--}}
                            {{--<li><a href="#">Fresh Berries</a></li>--}}
                            {{--<li><a href="#">Ocean Foods</a></li>--}}
                            {{--<li><a href="#">Butter & Eggs</a></li>--}}
                            {{--<li><a href="#">Fastfood</a></li>--}}
                            {{--<li><a href="#">Fresh Onion</a></li>--}}
                            {{--<li><a href="#">Papayaya & Crisps</a></li>--}}
                            {{--<li><a href="#">Oatmeal</a></li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                    {{--<div class="sidebar__item">--}}
                        {{--<h4>Price</h4>--}}
                        {{--<div class="price-range-wrap">--}}
                            {{--<div class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"--}}
                                 {{--data-min="10" data-max="540">--}}
                                {{--<div class="ui-slider-range ui-corner-all ui-widget-header"></div>--}}
                                {{--<span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>--}}
                                {{--<span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>--}}
                            {{--</div>--}}
                            {{--<div class="range-slider">--}}
                                {{--<div class="price-input">--}}
                                    {{--<input type="text" id="minamount">--}}
                                    {{--<input type="text" id="maxamount">--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="sidebar__item sidebar__item__color--option">--}}
                        {{--<h4>Colors</h4>--}}
                        {{--<div class="sidebar__item__color sidebar__item__color--white">--}}
                            {{--<label for="white">--}}
                                {{--White--}}
                                {{--<input type="radio" id="white">--}}
                            {{--</label>--}}
                        {{--</div>--}}
                        {{--<div class="sidebar__item__color sidebar__item__color--gray">--}}
                            {{--<label for="gray">--}}
                                {{--Gray--}}
                                {{--<input type="radio" id="gray">--}}
                            {{--</label>--}}
                        {{--</div>--}}
                        {{--<div class="sidebar__item__color sidebar__item__color--red">--}}
                            {{--<label for="red">--}}
                                {{--Red--}}
                                {{--<input type="radio" id="red">--}}
                            {{--</label>--}}
                        {{--</div>--}}
                        {{--<div class="sidebar__item__color sidebar__item__color--black">--}}
                            {{--<label for="black">--}}
                                {{--Black--}}
                                {{--<input type="radio" id="black">--}}
                            {{--</label>--}}
                        {{--</div>--}}
                        {{--<div class="sidebar__item__color sidebar__item__color--blue">--}}
                            {{--<label for="blue">--}}
                                {{--Blue--}}
                                {{--<input type="radio" id="blue">--}}
                            {{--</label>--}}
                        {{--</div>--}}
                        {{--<div class="sidebar__item__color sidebar__item__color--green">--}}
                            {{--<label for="green">--}}
                                {{--Green--}}
                                {{--<input type="radio" id="green">--}}
                            {{--</label>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="sidebar__item">--}}
                        {{--<h4>Popular Size</h4>--}}
                        {{--<div class="sidebar__item__size">--}}
                            {{--<label for="large">--}}
                                {{--Large--}}
                                {{--<input type="radio" id="large">--}}
                            {{--</label>--}}
                        {{--</div>--}}
                        {{--<div class="sidebar__item__size">--}}
                            {{--<label for="medium">--}}
                                {{--Medium--}}
                                {{--<input type="radio" id="medium">--}}
                            {{--</label>--}}
                        {{--</div>--}}
                        {{--<div class="sidebar__item__size">--}}
                            {{--<label for="small">--}}
                                {{--Small--}}
                                {{--<input type="radio" id="small">--}}
                            {{--</label>--}}
                        {{--</div>--}}
                        {{--<div class="sidebar__item__size">--}}
                            {{--<label for="tiny">--}}
                                {{--Tiny--}}
                                {{--<input type="radio" id="tiny">--}}
                            {{--</label>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            <div class="col-lg-12 col-md-12 ">
                <div class="filter__item">
                    <div class="row">
                        <div class="col-lg-4 col-md-5">
                            <div class="filter__sort">
                                <span>Sort By</span>
                                <select>
                                    <option value="0">Default</option>
                                    <option value="0">Default</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="filter__found">
                                <h6><span>{{$products->total()}}</span> Produtos Encontrados</h6>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-3">
                            <div class="filter__option">
                                <span class="icon_grid-2x2"></span>
                                <span class="icon_ul"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach($products as $product)
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="product__item">
                            <div class="product__item__pic set-bg" data-setbg="{{asset("storage/$product->cover")}}">
                                <ul class="product__item__pic__hover">
                                    <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                    <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                    <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                </ul>
                            </div>
                            <div class="product__item__text">
                                <h6><a href="#">{{$product->name}}</a></h6>
                                <h5>R${{$product->price}}</h5>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="product__pagination">
                    {{$products->links()}}
                </div>
            </div>
        </div>

    </div>
</section>
<!-- Product Section End -->
@endsection

{{--@if(!empty($products) && !collect($products)->isEmpty())--}}
{{--@if(session()->has('message'))--}}
{{--<div class="box no-border">--}}
{{--<div class="box-tools">--}}
{{--<p class="alert alert-success alert-dismissible">--}}
{{--{{ session()->get('message') }}--}}
{{--<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>--}}
{{--</p>--}}
{{--</div>--}}
{{--</div>--}}
{{--@endif--}}
{{--<ul class="row text-center list-unstyled">--}}
{{--@foreach($products as $product)--}}
{{--<div class="col-md-3 col-sm-6 col-xs-12 product-list" id="{{$product->slug}}">--}}
{{--<div class="single-product">--}}
{{--<div class="product">--}}
{{--@if(isset($product->cover))--}}
{{--<img src="{{ asset("storage/$product->cover") }}" alt="{{ $product->name }}"--}}
{{--class="img-thumbnail">--}}
{{--@endif--}}
{{--</div>--}}

{{--<div class="product-text">--}}
{{--<h4>{{ $product->name }}</h4>--}}
{{--<p>--}}
{{--{{ config('cart.currency') }}--}}
{{--@if(!is_null($product->attributes->where('default', 1)->first()))--}}
{{--@if(!is_null($product->attributes->where('default', 1)->first()->sale_price))--}}
{{--{{ number_format($product->attributes->where('default', 1)->first()->sale_price, 2) }}--}}
{{--<p class="text text-danger">Sale!</p>--}}
{{--@else--}}
{{--{{ number_format($product->attributes->where('default', 1)->first()->price, 2) }}--}}
{{--@endif--}}
{{--@else--}}
{{--{{ number_format($product->price, 2) }}--}}
{{--@endif--}}
{{--</p>--}}
{{--<form action="{{ route('cart.store') }}" class="form-inline" method="post">--}}
{{--{{ csrf_field() }}--}}
{{--<input type="hidden" name="quantity" value="1" />--}}
{{--<input type="hidden" name="product" value="{{ $product->id }}">--}}
{{--@isset($category_slug)--}}
{{--<input type="hidden" name="category_slug" value="{{ $category_slug }}">--}}
{{--@endif--}}
{{--<button id="add-to-cart-btn" type="submit" class="btn btn-warning"--}}
{{--@if($product->quantity < 1)--}}
{{--disabled--}}
{{--@endif--}}
{{--data-toggle="modal" data-target="#cart-modal"> <i class="fa fa-cart-plus"></i>--}}
{{--@if($product->quantity < 1)--}}
{{--ESGOTADO--}}
{{--@else--}}
{{--Comprar--}}
{{--@endif--}}
{{--</button>--}}
{{--<a class="btn btn-primary product-info" href="{{ route('front.get.product', str_slug($product->slug)) }}"> <i class="fa fa-link"></i> Detalhes</a> </li>--}}
{{--</form>--}}


{{--</div>--}}
{{--<!-- Modal -->--}}
{{--<div class="modal fade" id="myModal_{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">--}}
{{--<div class="modal-dialog" role="document">--}}
{{--<div class="modal-content">--}}
{{--@include('layouts.front.product')--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--@endforeach--}}
{{--@if($products instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)--}}
{{--<div class="row">--}}
{{--<div class="col-md-12">--}}
{{--<div class="pull-left">{{ $products->links() }}</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--@endif--}}
{{--</ul>--}}
{{--@else--}}
{{--<p class="alert alert-warning">No products yet.</p>--}}
{{--@endif--}}
