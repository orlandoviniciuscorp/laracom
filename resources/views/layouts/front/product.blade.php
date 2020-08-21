{{--<div class="row">--}}
{{--    <div class="col-md-6">--}}
{{--        <ul id="thumbnails" class="col-md-4 list-unstyled">--}}
{{--            <li>--}}
{{--                <a href="javascript: void(0)">--}}
{{--                    @if(isset($product->cover))--}}
{{--                    <img class="img-responsive img-thumbnail"--}}
{{--                         src="{{ asset("storage/$product->cover") }}"--}}
{{--                         alt="{{ $product->name }}" />--}}
{{--                    @else--}}
{{--                    <img class="img-responsive img-thumbnail"--}}
{{--                         src="{{ asset("https://placehold.it/180x180") }}"--}}
{{--                         alt="{{ $product->name }}" />--}}
{{--                    @endif--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            @if(isset($images) && !$images->isEmpty())--}}
{{--                @foreach($images as $image)--}}
{{--                <li>--}}
{{--                    <a href="javascript: void(0)">--}}
{{--                    <img class="img-responsive img-thumbnail"--}}
{{--                         src="{{ asset("storage/$image->src") }}"--}}
{{--                         alt="{{ $product->name }}" />--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--                @endforeach--}}
{{--            @endif--}}
{{--        </ul>--}}
{{--        <figure class="text-center product-cover-wrap col-md-8">--}}
{{--            @if(isset($product->cover))--}}
{{--                <img id="main-image" class="product-cover img-responsive"--}}
{{--                     src="{{ asset("storage/$product->cover") }}?w=400"--}}
{{--                     data-zoom="{{ asset("storage/$product->cover") }}?w=1200">--}}
{{--            @else--}}
{{--                <img id="main-image" class="product-cover" src="https://placehold.it/300x300"--}}
{{--                     data-zoom="{{ asset("storage/$product->cover") }}?w=1200" alt="{{ $product->name }}">--}}
{{--            @endif--}}
{{--        </figure>--}}
{{--    </div>--}}
{{--    <div class="col-md-6">--}}
{{--        <div class="product-description">--}}
{{--            <h1>{{ $product->name }}--}}
{{--                <small>{{ config('cart.currency') }} {{ $product->price }}</small>--}}
{{--            </h1>--}}
{{--            <div class="description">{!! $product->description !!}</div>--}}
{{--            <div class="excerpt">--}}
{{--                <hr>{{ str_limit($product->description, 100, ' ...') }}--}}
{{--            </div>--}}
{{--            <hr>--}}
{{--            <div class="row">--}}
{{--                <div class="col-md-12">--}}
{{--                    @include('layouts.errors-and-messages')--}}
{{--                    <form action="{{ route('cart.store') }}" class="form-inline" method="post">--}}
{{--                        {{ csrf_field() }}--}}
{{--                        @if(isset($productAttributes) && !$productAttributes->isEmpty())--}}
{{--                            <div class="form-group">--}}
{{--                                <label for="productAttribute">Choose Combination</label> <br />--}}
{{--                                <select name="productAttribute" id="productAttribute" class="form-control select2">--}}
{{--                                    @foreach($productAttributes as $productAttribute)--}}
{{--                                        <option value="{{ $productAttribute->id }}">--}}
{{--                                            @foreach($productAttribute->attributesValues as $value)--}}
{{--                                                {{ $value->attribute->name }} : {{ ucwords($value->value) }}--}}
{{--                                            @endforeach--}}
{{--                                            @if(!is_null($productAttribute->price))--}}
{{--                                                ( {{ config('cart.currency_symbol') }} {{ $productAttribute->price }})--}}
{{--                                            @endif--}}
{{--                                        </option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                            </div><hr>--}}
{{--                        @endif--}}
{{--                        <div class="form-group">--}}
{{--                            <input type="text"--}}
{{--                                   class="form-control"--}}
{{--                                   name="quantity"--}}
{{--                                   id="quantity"--}}
{{--                                   placeholder="Quantity"--}}
{{--                                   value="{{ old('quantity') }}" />--}}
{{--                            <input type="hidden" name="product" value="{{ $product->id }}" />--}}
{{--                        </div>--}}
{{--                        <button type="submit" class="btn btn-warning"--}}
{{--                                @if($product->quantity < 1)--}}
{{--                                    disabled--}}
{{--                                @endif--}}
{{--                        ><i class="fa fa-cart-plus"></i>--}}
{{--                            @if($product->quantity < 1)--}}
{{--                                ESGOTADO--}}
{{--                            @else--}}
{{--                                Adicionar ao carrinho--}}
{{--                            @endif--}}
{{--                        </button>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
{{--@section('js')--}}
{{--    <script type="text/javascript">--}}
{{--        $(document).ready(function () {--}}
{{--            var productPane = document.querySelector('.product-cover');--}}
{{--            var paneContainer = document.querySelector('.product-cover-wrap');--}}

{{--            new Drift(productPane, {--}}
{{--                paneContainer: paneContainer,--}}
{{--                inlinePane: false--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}
{{--@endsection--}}



<!-- Start All Title Box -->
<div class="all-title-box">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2>Shop Detail</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Shop</a></li>
                    <li class="breadcrumb-item active">Shop Detail </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End All Title Box -->

<!-- Start Shop Detail  -->
<div class="shop-detail-box-main">
    <div class="container">
        <div class="row">
            <div class="col-xl-5 col-lg-5 col-md-6">
                <div id="carousel-example-1" class="single-product-slider carousel slide" data-ride="carousel">
                    <div class="carousel-inner" role="listbox">
                        <div class="carousel-item active"> <img class="d-block w-100" src="{{asset("storage/$product->cover")}}" alt="First slide"> </div>
{{--                        <div class="carousel-item"> <img class="d-block w-100" src="images/big-img-02.jpg" alt="Second slide"> </div>--}}
{{--                        <div class="carousel-item"> <img class="d-block w-100" src="images/big-img-03.jpg" alt="Third slide"> </div>--}}
                    </div>
                    <a class="carousel-control-prev" href="#carousel-example-1" role="button" data-slide="prev">
                        <i class="fa fa-angle-left" aria-hidden="true"></i>
                        <span class="sr-only">Anterior</span>
                    </a>
                    <a class="carousel-control-next" href="#carousel-example-1" role="button" data-slide="next">
                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                        <span class="sr-only">Próxima</span>
                    </a>
{{--                    <ol class="carousel-indicators">--}}
{{--                        <li data-target="#carousel-example-1" data-slide-to="0" class="active">--}}
{{--                            <img class="d-block w-100 img-fluid" src="{{asset("storage/$product->cover")}}" alt="" />--}}
{{--                        </li>--}}
{{--                        <li data-target="#carousel-example-1" data-slide-to="1">--}}
{{--                            <img class="d-block w-100 img-fluid" src="images/smp-img-02.jpg" alt="" />--}}
{{--                        </li>--}}
{{--                        <li data-target="#carousel-example-1" data-slide-to="2">--}}
{{--                            <img class="d-block w-100 img-fluid" src="images/smp-img-03.jpg" alt="" />--}}
{{--                        </li>--}}
{{--                    </ol>--}}
                </div>
            </div>
            <div class="col-xl-7 col-lg-7 col-md-6">
                <form action="{{ route('cart.store') }}" method="post">
                    {{ csrf_field() }}
                <div class="single-product-details">
                    <h2>{{$product->name}}</h2>
                    <h5>{{$product->price}}</h5>
{{--                    <p class="available-stock"><span> More than 20 available / <a href="#">8 sold </a></span><p>--}}
                    <h4>Descrição:</h4>
                    <p>{{$product->description}}</p>
                    <ul>
                        <li>
                            <div class="form-group quantity-box">
                                <label class="control-label">Quantidade</label>
                                <input type="hidden" name="product" value="{{ $product->id }}">
                                <input class="form-control" name="quantity"value="1" min="1" max="20" type="number">
                            </div>
                        </li>
                    </ul>

                    <div class="price-box-bar">
                        <div class="cart-and-bay-btn">
{{--                            <a class="btn hvr-hover" data-fancybox-close="" href="#">Buy New</a>--}}
                            <button type="submit" class="btn hvr-hover btn-brown" data-fancybox-close="" href="#">Add to cart</button>
                        </div>
                    </div>

{{--                    <div class="add-to-btn">--}}
{{--                        <div class="add-comp">--}}
{{--                            <a class="btn hvr-hover" href="#"><i class="fas fa-heart"></i> Add to wishlist</a>--}}
{{--                            <a class="btn hvr-hover" href="#"><i class="fas fa-sync-alt"></i> Add to Compare</a>--}}
{{--                        </div>--}}
{{--                        <div class="share-bar">--}}
{{--                            <a class="btn hvr-hover" href="#"><i class="fab fa-facebook" aria-hidden="true"></i></a>--}}
{{--                            <a class="btn hvr-hover" href="#"><i class="fab fa-google-plus" aria-hidden="true"></i></a>--}}
{{--                            <a class="btn hvr-hover" href="#"><i class="fab fa-twitter" aria-hidden="true"></i></a>--}}
{{--                            <a class="btn hvr-hover" href="#"><i class="fab fa-pinterest-p" aria-hidden="true"></i></a>--}}
{{--                            <a class="btn hvr-hover" href="#"><i class="fab fa-whatsapp" aria-hidden="true"></i></a>--}}
                        </div>
                </form>
                    </div>
                </div>
            </div>
        </div>