<table class="table">
    <thead>
    <tr>
        <td>Pedido</td>
        <td>Cliente</td>
        <td>Total</td>
        <td>Pagamento</td>
        <td>Status</td>


    </tr>
    </thead>
    <tbody>
    @foreach ($orders as $order)
        <tr @if($order->orderStatus->name == 'Cancelado')class="danger" style="color: #FF0000;"@endif >
            <td @if($order->orderStatus->name == 'Cancelado') style="color: #FF0000;"  @endif >
                #{{$order->id}}
            </td>
            <td @if($order->orderStatus->name == 'Cancelado') style="color: #FF0000;"  @endif >
                {{$order->customer->name}}
            </td>
            <td @if($order->orderStatus->name == 'Cancelado') style="color: #FF0000;"  @endif >
                @if(isset($is_export))
                    {{($order->total)}}
                @else
                    {{currency_format($order->total)}}
                @endif
            </td>
            <td @if($order->orderStatus->name == 'Cancelado') style="color: #FF0000;"  @endif >
                {{$order->courier->slug}} - {{explode(" ",$order->payment)[0]}}
            </td>
            <td @if($order->orderStatus->name == 'Cancelado') style="color: #FF0000;"  @endif >
                {{$order->orderStatus->name}}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>