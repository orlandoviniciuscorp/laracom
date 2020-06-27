<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{env('APP_NAME')}} - Etiquetas</title>
    {{--<link rel="stylesheet" href="{{asset('css/style.min.css')}}">--}}
    <style>

        table, tr, td,th{
            border-collapse: collapse;
            border: 1px solid black;
        }

    </style>
</head>
<body>

<section class="container">
<!-- Default box -->
    <h2>{{env('APP_NAME')}} - Etiquetas</h2>
    @if($orders)

                @foreach ($orders as $order)
                <table>
                    <tr>
                        <td width="40%" style="padding-left: 5px">
                            {{env('APP_NAME')}} - {{$order->fair->name}}<br /><br />
                            <strong>Número do Pedido</strong>: #{{$order->id}}
                            <br />
                            <br />

                            <strong>Cliente - Telefone</strong>
                            <br />
                            {{$order->customer->name}} -
                           <small> {{$order->address->phone}}
                           </small>
                            <br /><br/>
                            <strong>Valor a Pagar</strong>
                            <br />
                            <small><strong>Dinheiro:</strong> {{currency_format($order->total)}}
                            </small>
                            <br/>
                            <small><strong>Cartão:</strong> {{currency_format($order->total * 1.025)}}</small>
                            <br />
                            <br />
                            <strong>Forma de Pagamento:</strong>
                            {{$order->payment}}
                            <br />
                            <strong>Tipo de Entrega:</strong>
                            {{$order->courier->name}}
                            <br />

                            <strong>Endereço:</strong> <br/>
                            {{$order->address->address_1}} - {{$order->address->address_2}} - {{$order->address->neighborhoods}}
                            <br /><br/>
                            Observação: <br />
                            <small> <strong>{{$order->obs}}</strong>
                            </small>
                        </td>
                        <td width="60%">
                            <strong>Produtos:</strong><br />
                               @foreach($order->products as $product)
                                &nbsp;<strong>{{$product->pivot->quantity }}</strong> - {{$product->name }} <br />
                                @endforeach
                        </td>
                    </tr>
                </table>
        <br />
            <br/>
                @endforeach

        <!-- /.box-body -->

        <!-- /.box -->

    @endif
</section>

</body>
</html>