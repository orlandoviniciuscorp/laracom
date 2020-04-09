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
                            Número do Pedido
                        </th>
                        <th>
                            Cliente
                        </th>
                        <th>
                            Telefone
                        </th>

                        <th>
                            Valor a Pagar
                        </th>

                        <th>
                            Produtos
                        </th>
                        <th>
                            Observação
                        </th>
                    </tr>
                    <tr>
                        <td>
                            #{{$order->id}}
                        </td>
                        <td>
                            <strong>{{$order->customer->name}}</strong>
                        </td>
                        <td>
                            {{$order->address->phone}}</li>
                        </td>

                        <td>
                            R$ {{$order->total}}</li>
                        </td>
                        <td>
                            @foreach($order->products as $product)
                                {{$product->name }} - {{$product->pivot->quantity }} <br />
                            @endforeach
                        </td>
                        <td>
                            {{$order->obs}}</li>
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