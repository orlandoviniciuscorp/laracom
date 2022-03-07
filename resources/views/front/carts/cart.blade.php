{{--@extends('layouts.front.app')--}}

{{--@section('content')--}}
    <!-- Shoping Cart Section Begin -->
    @if($config->is_open == 1)
    <section class="shoping-cart spad">
        <div class="container">
            @include('layouts.errors-and-messages')
            @if($cartItems->count() > 0)
        <div class="d-none d-lg-block">
            <div class="row">
                <div class="col-lg-4">
                    Produto
                </div>
                <div class="col-lg-3">
                    Quantidade
                </div>
                <div class="col-lg-1">
                    Un.
                </div>
                <div class="col-lg-1">
                    Total
                </div>



            </div>
            @foreach($cartItems as $cartItem)
                <div class="row border-bottom" style="margin-bottom: 10px">
                    <div class="col-lg-1">
                        <td class="shoping__cart__item">
                        <img src="{{asset("storage/$cartItem->cover")}}" class="mh-100" style="width: 50px; height: 50px;" >

{{--                        </td>--}}
                    </div>
                    <div class="col-lg-3">
                        <h5>{{ $cartItem->name }}</h5>
                    </div>
                    <form action="{{ route('cart.update', $cartItem->rowId) }}" class="" method="post">
                        <div class="col-lg-4">

                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="put">
                                <div class="quantity">
                                    <div class="pro-qty">
                                        <input type="text" value="{{ $cartItem->qty }}" name="quantity" >
                                        <span> <button type="submit">Atualizar</button></span>
                                    </div>

                                </div>
                        </div>

                    </form>
                    <div class="col-md-1">
                        <form action="{{ route('cart.destroy', $cartItem->rowId) }}" method="post" class="form-inline">
                            {{ csrf_field() }}
                            <input type="hidden" name="_method" value="delete">
                            <button onclick="return confirm('Tem certeza que deseja remover o Item?')" class="btn btn-danger btn-sm"><span class="icon_close"></span></button>
                        </form>
                    </div>
                    <div class="col-lg-1">
                        {{config('cart.currency')}} {{ number_format($cartItem->price, 2) }}
                    </div>
                    <div class="col-lg-1">
                        {{config('cart.currency')}} {{ number_format(($cartItem->qty*$cartItem->price), 2) }}
                    </div>
                </div>
            @endforeach
            </div>

                <div class="d-lg-none">
                    <table class="table">
                        <thead>
                        <th>
                            Imagem
                        </th>
                        <th>
                            Produto
                        </th>
                        <th>
                            Qtd
                        </th>
                        <th>
                            Ações
                        </th>
                        <th>
                            Un.
                        </th>
                        <th>
                            Total
                        </th>
                        </thead>
                        <tbody>
                @foreach($cartItems as $cartItem)

                        <tr>
                            <td>
                                <img class="card-img-top mh-100 img-fluid" src="{{asset("storage/$cartItem->cover")}}"
                                     style="width: 50px"
                                >
                            </td>
                            <td>
                                {{$cartItem->name}}
                            </td>
                            <td>
                                <form action="{{ route('cart.update', $cartItem->rowId) }}" class="form-inline" method="post">
                                {{ csrf_field() }}
                                    <input type="hidden" name="_method" value="put">
                                    <input type="text" class="col-sm-2" value="{{ $cartItem->qty }}" name="quantity" >
                                    <span>&nbsp;&nbsp;<button type="submit">Atualizar</button></span>
                                </form>
                            </td>
                            <td>
                                <form action="{{ route('cart.destroy', $cartItem->rowId) }}" method="post" class="form-inline">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="_method" value="delete">
                                    <button onclick="return confirm('Tem certeza que deseja remover o Item?')" class="btn btn-danger btn-sm"><span class="icon_close"></span></button>
                                </form>
                            </td>
                            <td>
                                {{config('cart.currency')}} {{ number_format($cartItem->price, 2) }}
                            </td>
                            <td>
                                {{config('cart.currency')}} {{ number_format(($cartItem->qty*$cartItem->price), 2) }}
                            </td>
                        </tr>



            @endforeach
                        </tbody>
                    </table>
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