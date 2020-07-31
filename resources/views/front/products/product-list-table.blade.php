@if(!$products->isEmpty())

    {{--<table class="table table-striped">--}}
        {{--<thead>--}}
        {{--<tr>--}}
           {{--<td><b>Nome</b></td>--}}
           {{--<td><b>Descrição</b></td>--}}
           {{--<td><b>Quantidade</b></td>--}}
            {{--<div class="col-lg-1 col-md-1"><b>Remover</b></div>--}}
           {{--<td><b>Preço</b></td>--}}
           {{--<td><b>Total</b></td>--}}
        {{--</tr>--}}
        {{--</thead>--}}
        {{--<tbody>--}}

        {{--@foreach($cartItems as $cartItem)--}}

            {{--<tr>--}}
                {{--<td>{{ $cartItem->name }}</td>--}}
                {{--<td>{!! $cartItem->product->description !!}</td>--}}
                {{--<td>--}}
                    {{--{{ $cartItem->qty }}--}}
                {{--</td>--}}
                {{--<td>{{config('cart.currency')}} {{ number_format($cartItem->price, 2) }}</td>--}}
                {{--<td>{{config('cart.currency')}} {{ number_format(($cartItem->qty*$cartItem->price), 2) }}</td>--}}
            {{--</tr>--}}


        {{--@endforeach--}}
        {{--</tbody>--}}
    {{--</table>--}}

@endif
<script type="text/javascript">
    $(document).ready(function () {
        let courierRadioBtn = $('input[name="rate"]');
        courierRadioBtn.click(function () {
            $('#shippingFee').text($(this).data('fee'));
            let totalElement = $('span#grandTotal');
            let shippingFee = $(this).data('fee');
            let total = totalElement.data('total');
            let grandTotal = parseFloat(shippingFee) + parseFloat(total);
            totalElement.html(grandTotal.toFixed(2));
        });
    });
</script>
