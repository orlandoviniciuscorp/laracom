{{--@extends('layouts.front.app')--}}

{{--@section('content')--}}
    <!-- Shoping Cart Section Begin -->
    @if($config->is_open == 1)
    <section class="shoping-cart spad">
        <div class="container">
            @include('layouts.errors-and-messages')
            @if($cartItems->count() > 0)
            <div class="row">
                <div class="col-lg-4">
                    Produto
                </div>
                <div class="col-lg-3">
                    Quantidade
                </div>
                <div class="col-lg-1">
                    Preço
                </div>
                <div class="col-lg-1">
                    Total
                </div>



            </div>
            @foreach($cartItems as $cartItem)
                <div class="row border-bottom">
                    <div class="col-lg-1">
                        <td class="shoping__cart__item">
                        <img src="{{asset("storage/$cartItem->cover")}}" class="mh-100" style="width: 50px; height: 50px; alt="">

{{--                        </td>--}}
                    </div>
                    <div class="col-lg-3">
                        <h5>{{ $cartItem->name }}</h5>
                    </div>
                    <form action="{{ route('cart.update', $cartItem->rowId) }}" class="" method="post">
                    <div class="col-lg-5 border">

                            {{ csrf_field() }}
                            <input type="hidden" name="_method" value="put">
                            <div class="quantity">
                                <div class="pro-qty">
                                    <input type="text" value="{{ $cartItem->qty }}" name="quantity" >
                                </div>
                            </div>
                    </div>
                    <div class="col-lg-1 border">
                      <button type="submit">Atualizar</button>
                    </div>
                    </form>
                    <div class="col-md-1 border">
                        <form action="{{ route('cart.destroy', $cartItem->rowId) }}" method="post" class="form-inline">
                            {{ csrf_field() }}
                            <input type="hidden" name="_method" value="delete">
                            <button onclick="return confirm('Tem certeza que deseja remover o Item?')" class="btn btn-danger btn-sm"><span class="icon_close"></span></button>
                        </form>
                    </div>
                    <div class="col-lg-1">
                       <span class="col-sm-1">Valor unitário</span> {{config('cart.currency')}} {{ number_format($cartItem->price, 2) }}
                    </div>
                    <div class="col-lg-1">
                        {{config('cart.currency')}} {{ number_format(($cartItem->qty*$cartItem->price), 2) }}
                    </div>
                </div>
            @endforeach


{{--                        <div class="col-lg-6">--}}
{{--                            <div class="shoping__checkout">--}}
{{--                                <h5>Total Carrinho</h5>--}}
{{--                                <ul>--}}
{{--                                    <li>Compras <span>R$ {{$total}}</span></li>--}}
{{--                                    <li>Frete <span id="frete">R$ 0.00</span></li>--}}
{{--                                    <li>Total <span id ="total">R$ {{$total}}</span></li>--}}
{{--                                </ul>--}}
{{--                                <button type="submit" class="btn btn-success">FORMA DE PAGAMENTO</button>--}}
{{--                                --}}{{--<a href="{{route('cart.checkout'}}" class="primary-btn">FORMA DE PAGAMENTO</a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>
                </form>
            </div>
        </div>
        @else
            Seu Carrinho está vazio, Comece a comprar clicando <a href="{{route('product.list')}}">aqui</a>.
        @endif
    </section>
    @else
        @include('front.closed')
    @endif

{{--@endsection--}}

@section('css')
    <style type="text/css">
        .product-description {
            padding: 10px 0;
        }
        .product-description p {
            line-height: 18px;
            font-size: 14px;
        }
    </style>
@endsection