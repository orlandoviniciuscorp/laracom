@extends('layouts.front.app')
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
                    @if(isset($catTopProducts))
                        @foreach($catTopProducts as $catTop)

                            @include('front.products.product-list-row',['products'=>$catTop->products,
                                                                         'catTop'=>$catTop])
                        @endforeach
                    @else
                        @include('front.products.product-list-row',['products',$products])
                    @endif
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-sm-12 col-xs-12 sidebar-shop-left">
                <div class="product-categori">
                    <div class="search-product">
                        <form action="{{route('search.product')}}">
                            <input class="form-control" name="q" placeholder="Do que Você precisa?" type="text">
                            <button type="submit"> <i class="fa fa-search"></i> </button>
                        </form>
                    </div>
                    <div class="filter-sidebar-left">
                        <div class="title-left">
                            <h3>Categorias</h3>
                        </div>

                            <div class="list-group list-group-collapse list-group-sm list-group-tree" id="list-group-men" data-children=".sub-men">
                                @foreach($cats as $cat)

                                <a href="{{route('front.category.slug',$cat->slug)}}" class="list-group-item list-group-item-action"> {{$cat->name}}  <small class="text-muted">( {{$cat->products->count()}} ) </small></a>
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
@endsection