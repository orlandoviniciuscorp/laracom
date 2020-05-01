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
                        <td>
                            {{env('APP_NAME')}}<br /><br />
                            <strong>Número do Pedido</strong>
                            <br />
                        #{{$order->id}}
                            <br />
                            <br />

                            <strong>Cliente</strong>
                            <br />
                            {{$order->customer->name}}
                            <br /><br />
                            <strong>Telefone</strong>
                            <br />
                           <small> {{$order->address->phone}}
                           </small>
                            <br /><br/>
                            <strong>Valor a Pagar</strong>
                            <br />
                            <small>{{currency_format($order->total)}}
                            </small>
                            <br >
                            <br/>
                            Forma de Pagamento:
                            {{$order->payment}}
                        </td>

                        <td>
                            <strong>Zona:</strong>
                            {{$order->courier->name}}

                            <br />
                            <br />

                            <strong>Endereço:</strong> <br/>
                            {{$order->address->address_1}} - {{$order->address->address_2}}
                        </td>
                        <td>
                            <strong>Produtos:</strong><br />
                               @foreach($order->products as $product)
                                {{$product->name }} - {{$product->pivot->quantity }} <br />
                                @endforeach
                        </td>
                        <td>
                            Observação: <br />
                           <small> {{$order->obs}}</li>
                           </small>
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