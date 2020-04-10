<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Etiquetas</title>
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
    <h2>Etiquetas</h2>
    @if($orders)

                @foreach ($orders as $order)
                <table>
                    <tr>
                        <th>
                            <small> Número do Pedido</small>
                        </th>
                        <th>
                            <small>Cliente</small>
                        </th>
                        <th>
                            <small>Telefone</small>
                        </th>

                        <th>
                           <small> Valor a Pagar</small>
                        </th>

                        <th>
                            <small>Produtos</small>
                        </th>
                        <th>
                            <small>Observação</small>
                        </th>
                    </tr>
                    <tr>
                        <td>
                            <small>#{{$order->id}}</small>
                        </td>
                        <td>
                            <small><strong>{{$order->customer->name}}</strong>
                            </small>
                        </td>
                        <td>
                           <small> {{$order->address->phone}}</li>
                           </small>
                        </td>

                        <td>
                            <small>R$ {{$order->total}}</li>
                            </small>
                        </td>
                        <td>
                           <small>
                               @foreach($order->products as $product)
                                {{$product->name }} - {{$product->pivot->quantity }} <br />
                                @endforeach
                           </small>
                        </td>
                        <td>
                           <small> {{$order->obs}}</li>
                           </small>
                        </td>
                    </tr>
                </table>
        <br />
            <hr>
                @endforeach

        <!-- /.box-body -->

        <!-- /.box -->

    @endif
</section>

</body>
</html>