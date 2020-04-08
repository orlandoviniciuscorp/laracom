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

</head>
<body>

<section class="container">
<!-- Default box -->
    <h2>Etiquetas</h2>
    @if($orders)

                @foreach ($orders as $order)
                    <table border="1">
                    <tr>
                        <td>
                            <li><strong>{{$order->customer->name}}</strong></li>
                        </td>
                    </tr>
                    <tr>
                        <td>
                        <li>{{$order->customer->email}}</li>
                        </td>
                    </tr>
                        <tr>
                            <td>
                        <li>{{$order->address->phone}}</li>
                            </td>
                        </tr>
                        <tr>
                            <td>
                        <li>R$ {{$order->total}}</li>
                            </td>
                        </tr>
                        <tr>
                            <td>
                        @foreach($order->products as $product)
                            <li>{{$product->name }} - {{$product->pivot->quantity }}</li>
                        @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td>
                        <li>{{$order->obs}}</li>
                            </td>
                        </tr>
                    </table>
                    </ul>
                    <hr>


                @endforeach
        <!-- /.box-body -->
        </small>

        <!-- /.box -->

    @endif

</section>

</body>
</html>