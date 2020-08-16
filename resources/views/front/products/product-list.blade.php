{{--@if(!empty($products) && !collect($products)->isEmpty())--}}
{{--    @if(session()->has('message'))--}}
{{--        <div class="box no-border">--}}
{{--            <div class="box-tools">--}}
{{--                <p class="alert alert-success alert-dismissible">--}}
{{--                    {{ session()->get('message') }}--}}
{{--                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>--}}
{{--                </p>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    @endif--}}
{{--    <ul class="row text-center list-unstyled">--}}
{{--        @foreach($products as $product)--}}
{{--            <div class="col-md-3 col-sm-6 col-xs-12 product-list" id="{{$product->slug}}">--}}
{{--                <div class="single-product">--}}
{{--                    <div class="product">--}}
{{--                        @if(isset($product->cover))--}}
{{--                            <img src="{{ asset("storage/$product->cover") }}" alt="{{ $product->name }}"--}}
{{--                                 class="img-thumbnail">--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{----}}
{{--                    <div class="product-text">--}}
{{--                        <h4>{{ $product->name }}</h4>--}}
{{--                        <p>--}}
{{--                            {{ config('cart.currency') }}--}}
{{--                            @if(!is_null($product->attributes->where('default', 1)->first()))--}}
{{--                                @if(!is_null($product->attributes->where('default', 1)->first()->sale_price))--}}
{{--                                    {{ number_format($product->attributes->where('default', 1)->first()->sale_price, 2) }}--}}
{{--                                    <p class="text text-danger">Sale!</p>--}}
{{--                                @else--}}
{{--                                    {{ number_format($product->attributes->where('default', 1)->first()->price, 2) }}--}}
{{--                                @endif--}}
{{--                            @else--}}
{{--                                {{ number_format($product->price, 2) }}--}}
{{--                            @endif--}}
{{--                        </p>--}}
    {{--                                <form action="{{ route('cart.store') }}" class="form-inline" method="post">--}}
    {{--                                    {{ csrf_field() }}--}}
    {{--                                    <input type="hidden" name="quantity" value="1" />--}}
    {{--                                    <input type="hidden" name="product" value="{{ $product->id }}">--}}
{{--                                    @isset($category_slug)--}}
{{--                                        <input type="hidden" name="category_slug" value="{{ $category_slug }}">--}}
{{--                                    @endif--}}
{{--                                    <button id="add-to-cart-btn" type="submit" class="btn btn-warning"--}}
{{--                                            @if($product->quantity < 1)--}}
{{--                                            disabled--}}
{{--                                            @endif--}}
{{--                                            data-toggle="modal" data-target="#cart-modal"> <i class="fa fa-cart-plus"></i>--}}
{{--                                        @if($product->quantity < 1)--}}
{{--                                            ESGOTADO--}}
{{--                                        @else--}}
{{--                                            Comprar--}}
{{--                                        @endif--}}
{{--                                    </button>--}}
{{--                                    <a class="btn btn-primary product-info" href="{{ route('front.get.product', str_slug($product->slug)) }}"> <i class="fa fa-link"></i> Detalhes</a> </li>--}}
{{--                                </form>--}}
{{----}}
{{----}}
{{--                    </div>--}}
{{--                    <!-- Modal -->--}}
{{--                    <div class="modal fade" id="myModal_{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">--}}
{{--                        <div class="modal-dialog" role="document">--}}
{{--                            <div class="modal-content">--}}
{{--                                @include('layouts.front.product')--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        @endforeach--}}
{{--        @if($products instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)--}}
{{--            <div class="row">--}}
{{--                <div class="col-md-12">--}}
{{--                    <div class="pull-left">{{ $products->links() }}</div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        @endif--}}
{{--    </ul>--}}
{{--@else--}}
{{--    <p class="alert alert-warning">No products yet.</p>--}}
{{--@endif--}}
@extends('layouts.front.app')
@include('layouts.front.header-cart')

@section('content')

    <!-- Start All Title Box -->
    <div class="all-title-box">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Shop</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Produtos</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End All Title Box -->
<!-- Start Shop Page  -->
<div class="shop-box-inner">
    <div class="container">
        @include('layouts.errors-and-messages')
        <div class="row">
            <div class="col-xl-9 col-lg-9 col-sm-12 col-xs-12 shop-content-right">
                <div class="right-product-box">
                    <div class="product-item-filter row">
                        <div class="col-12 col-sm-8 text-center text-sm-left">
                            <div class="toolbar-sorter-right">
                                <span>Ordenação</span>
                                <select id="basic" class="selectpicker show-tick form-control" data-placeholder="$ USD">
                                    <option data-display="Select">Nothing</option>
                                    <option value="1">Popularity</option>
                                    <option value="2">High Price → High Price</option>
                                    <option value="3">Low Price → High Price</option>
                                    <option value="4">Best Selling</option>
                                </select>
                            </div>
                            <p>{{$products->count()}} Produto(s) Encontrado(s)</p>
                        </div>
                        <div class="col-12 col-sm-4 text-center text-sm-right">
                            <ul class="nav nav-tabs ml-auto">
                                <li>
                                    <a class="nav-link active" href="#grid-view" data-toggle="tab"> <i class="fa fa-th"></i> </a>
                                </li>
                                <li>
                                    <a class="nav-link" href="#list-view" data-toggle="tab"> <i class="fa fa-list-ul"></i> </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="product-categorie-box">
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade show active" id="grid-view">
                                <div class="row">
                                    @foreach($products as $product)
                                        <div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
                                            <div class="products-single fix">
                                                <div class="box-img-hover">
                                                    <div class="type-lb">
                                                        <p class="sale">Aproveite</p>
                                                    </div>
                                                    <img src="{{asset("storage/$product->cover")}}" class="img-fluid" alt="Image">
                                                    <div class="mask-icon">
                                                        <ul>
                                                            <li><a href="#" data-toggle="tooltip" data-placement="right" title="View"><i class="fas fa-eye"></i></a></li>
                                                            <li><a href="#" data-toggle="tooltip" data-placement="right" title="Compare"><i class="fas fa-sync-alt"></i></a></li>
                                                            <li><a href="#" data-toggle="tooltip" data-placement="right" title="Add to Wishlist"><i class="far fa-heart"></i></a></li>
                                                        </ul>
                                                        <form action="{{ route('cart.store') }}" method="post">
                                                            {{ csrf_field() }}
                                                            <input type="number" name="quantity" min="1" value="1" />
                                                            <input type="hidden" name="product" value="{{ $product->id }}">
                                                            <input type="submit" class="btn hvr-hover" id="btn_comprar"
                                                                   value="Adicionar ao Carrinho">
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="why-text">
                                                    <h4>{{$product->name}}</h4>
                                                    <h5> R$ {{$product->price}}</h5>
                                                </div>
                                            </div>
                                        </div>

                                    @endforeach
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="list-view">
                                @foreach($products as $product)
                                <div class="list-view-box">
                                    <div class="row">
                                        <div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
                                            <div class="products-single fix">
                                                <div class="box-img-hover">
                                                    <div class="type-lb">
                                                        <p class="new">Aproveite</p>
                                                    </div>
                                                    <img src="{{asset("storage/$product->cover")}}" class="img-fluid" alt="Image">
                                                    <div class="mask-icon">
                                                        <ul>
                                                            <li><a href="#" data-toggle="tooltip" data-placement="right" title="View"><i class="fas fa-eye"></i></a></li>
                                                            <li><a href="#" data-toggle="tooltip" data-placement="right" title="Compare"><i class="fas fa-sync-alt"></i></a></li>
                                                            <li><a href="#" data-toggle="tooltip" data-placement="right" title="Add to Wishlist"><i class="far fa-heart"></i></a></li>
                                                        </ul>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6 col-lg-8 col-xl-8">
                                            <div class="why-text full-width">
                                                <h4>{{$product->name}}</h4>
                                                <h5>R${{$product->price}}</h5>
                                                <p>{{$product->description}}</p>
                                                <input type="submit" class="btn hvr-hover" value="Comprar" />
{{--                                                <a class="btn hvr-hover" href="#">Add to Cart</a>--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-sm-12 col-xs-12 sidebar-shop-left">
                <div class="product-categori">
                    <div class="search-product">
                        <form action="#">
                            <input class="form-control" placeholder="Search here..." type="text">
                            <button type="submit"> <i class="fa fa-search"></i> </button>
                        </form>
                    </div>
                    <div class="filter-sidebar-left">
                        <div class="title-left">
                            <h3>Categorias</h3>
                        </div>

                            <div class="list-group list-group-collapse list-group-sm list-group-tree" id="list-group-men" data-children=".sub-men">
                                @foreach($cats as $cat)

                                <a href="#" class="list-group-item list-group-item-action"> {{$cat->name}}  <small class="text-muted">( {{$cat->products->count()}} ) </small></a>
                                @endforeach
                            </div>

                    </div>
{{--                    <div class="filter-price-left">--}}
{{--                        <div class="title-left">--}}
{{--                            <h3>Price</h3>--}}
{{--                        </div>--}}
{{--                        <div class="price-box-slider">--}}
{{--                            <div id="slider-range"></div>--}}
{{--                            <p>--}}
{{--                                <input type="text" id="amount" readonly style="border:0; color:#fbb714; font-weight:bold;">--}}
{{--                                <button class="btn hvr-hover" type="submit">Filter</button>--}}
{{--                            </p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Shop Page -->