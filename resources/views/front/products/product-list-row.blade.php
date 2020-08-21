<div class="product-categorie-box">
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade show active" id="grid-view">
            @if(isset($catTop))
                <div class="row justify-content-center">
                    <h2>
                        {{$catTop->name}}
                    </h2>
                </div>
            @endif
            <div class="row">
                @foreach($products as $product)
                    <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                        <div class="products-single fix">
                            <div class="box-img-hover">
                                <div class="type-lb">
                                    <p class="sale">Aproveite</p>
                                </div>
                                <img src="{{asset("storage/$product->cover")}}" class="img-fluid img-sells" alt="Image">
                                <div class="mask-icon">
                                    <ul>
                                        <li><a href="{{$product->slug}}" data-toggle="tooltip" data-placement="right" title="View"><i class="fas fa-eye"></i></a></li>
                                    </ul>
                                    <form action="{{ route('cart.store') }}" method="post">
                                        {{ csrf_field() }}

                                        <input type="number" name="quantity" id="input_quantity" class="" min="1" value="1" />
                                        <input type="hidden" name="product" value="{{ $product->id }}">
                                        <input type="submit" class="btn hvr-hover" id="btn_comprar"
                                               @if($product->quantity < 1)
                                               disabled
                                               value="Esgotado"
                                               @else
                                               value="Comprar"
                                                @endif
                                        >
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
                @if(isset($catTop))
            <div class="row justify-content-center">
                <a href="{{route('front.category.slug',$catTop->slug)}}" class="btn hvr-hover"
                style="color: #ffffff;border:none;text-transform:uppercase;padding: 10px 20px;">
                    Ver Todos
                </a>
            </div>
                    @endif
        </div>
        <hr/>
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
                                            <li><a href="{{$product->slug}}" data-toggle="tooltip" data-placement="right" title="View"><i class="fas fa-eye"></i></a></li>
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