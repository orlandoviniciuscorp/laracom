@extends('layouts.front.app')

@section('content')
    <!-- Shoping Cart Section Begin -->
    @if($config->is_open == 1)
    <section class="shoping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__table">
                        <table>
                            <thead>
                            <tr>
                                <th class="shoping__product">Produtos</th>
                                <th>Preço</th>
                                <th>Quantidade</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($cartItems as $cartItem)
                                <tr>
                                    <td class="shoping__cart__item">
                                        <img src="{{asset("storage/$cartItem->cover")}}" class="mh-100" style="width: 50px; height: 50px; alt="">
                                        <h5>{{ $cartItem->name }}</h5>
                                    </td>
                                    <td class="shoping__cart__price">
                                        {{config('cart.currency')}} {{ number_format($cartItem->price, 2) }}
                                    </td>
                                    <td class="shoping__cart__quantity">
                                        <form action="{{ route('cart.update', $cartItem->rowId) }}" class="form-inline" method="post">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_method" value="put">
                                        <div class="quantity">
                                            <div class="pro-qty">
                                                <input type="text" value="{{ $cartItem->qty }}" name="quantity" >
                                            </div>
                                        </div>

                                            &nbsp;<button type="submit">
                                                Atualizar</button>

                                        </form>
                                    </td>
                                    <td class="shoping__cart__total">
                                        {{config('cart.currency')}} {{ number_format(($cartItem->qty*$cartItem->price), 2) }}
                                    </td>
                                    <td class="shoping__cart__item__close">
                                        <form action="{{ route('cart.destroy', $cartItem->rowId) }}" method="post">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="_method" value="delete">
                                            <button onclick="return confirm('Tem certeza que deseja remover o Item?')" class="btn btn-danger btn-sm"><span class="icon_close"></span></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__btns">
                        <a href="{{route('product.list')}}" class="primary-btn cart-btn">Continuar Comprando</a>
                    </div>
                </div>
                <form action="{{route('cart.checkout')}}" method="get"
                      class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="shoping__checkout">
                                    <h5><i class="fa fa-truck"></i> Entrega</h5>
                                    <ul>
                                        @foreach($couriers as $courier)
                                            <li><input type="radio" name="courier_id" data-fee="{{ $courier->name }}" value="{{ $courier->id }}" data-name="{{$courier->cost}}"> {{currency_format($courier->cost)}} - {{$courier->name}}
                                            <br />
                                            {{$courier->description}}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                {{--<div class="shoping__discount">--}}
                                    {{--<h5>Discount Codes</h5>--}}
                                    {{--<form action="#">--}}
                                        {{--<input type="text" placeholder="Enter your coupon code">--}}
                                        {{--<button type="submit" class="site-btn">APPLY COUPON</button>--}}
                                    {{--</form>--}}
                                {{--</div>--}}

                        </div>
                        <div class="col-lg-6">
                            <div class="shoping__checkout">
                                <h5>Total Carrinho</h5>
                                <ul>
                                    <li>Compras <span>R$ {{$total}}</span></li>
                                    <li>Frete <span id="frete">R$ 0.00</span></li>
                                    <li>Total <span id ="total">R$ {{$total}}</span></li>
                                </ul>
                                <button type="submit" class="btn btn-success">FORMA DE PAGAMENTO</button>
                                {{--<a href="{{route('cart.checkout'}}" class="primary-btn">FORMA DE PAGAMENTO</a>--}}
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    @else
        @include('front.closed')
    @endif

@endsection
@section('post-script')
<script>
    // $(document).ready(function(){
    //
    //     var quantitiy=0;
    //     $('.quantity-right-plus').click(function(e){
    //
    //         // Stop acting like a button
    //         e.preventDefault();
    //         // Get the field name
    //         var quantity = parseInt($('#quantity').val());
    //
    //         // If is not undefined
    //
    //         $('#quantity').val(quantity + 1);
    //
    //
    //         // Increment
    //
    //     });
    //
    //     $('.quantity-left-minus').click(function(e){
    //         // Stop acting like a button
    //         e.preventDefault();
    //         // Get the field name
    //         var quantity = parseInt($('#quantity').val());
    //
    //         // If is not undefined
    //
    //         // Increment
    //         if(quantity>0){
    //             $('#quantity').val(quantity - 1);
    //         }
    //     });
    //
    // });

    $('input[name=courier_id]').change(function (e) {
        $('#frete').text('R$ ' + $('input[name=courier_id]:checked').data('name'));
        vlrTotal = parseFloat({{$total}}) + parseFloat($('input[name=courier_id]:checked').data('name'));
        $('#total').text('R$ ' + vlrTotal.toFixed(2));
    });
</script>
@endsection
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