<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Colheita</title>
    {{--<link rel="stylesheet" href="{{asset('css/style.min.css')}}">--}}
    <style>
        table {
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
    </style>
</head>
<body>

<section class="container">
<!-- Default box -->
    <h3>{{env('APP_NAME')}} - Pedidos dos Clientes</h3>
    @if($deliveryAddrresses)
        <table border="0" style="border: 1px solid black">
            <tr>
               <th>
                   # Pedido
               </th>
                <th>
                    Cliente
                </th>
                {{--<th>--}}
                    {{--Email--}}
                {{--</th>--}}
                <th>
                    Pagamento
                </th>
                <th>
                    Zonas
                </th>
                <th>
                    Itens
                </th>
                <th>
                    Endereços
                </th>
                <th>
                    Obs
                </th>

            </tr>
                @foreach ($deliveryAddrresses as $deliveryAddrress)

                    <tr>
                        <td>
                            {{$deliveryAddrress->pedido}}
                        </td>
                        <td>
                            {{$deliveryAddrress->cliente}} <br /> <br />

                            <strong>Telefone:</strong>
                            {{$deliveryAddrress->telefone}}
                        </td>
                        <td>
                            {{$deliveryAddrress->pagamento}}
                            <br />
                            <br />
                            {{currency_format($deliveryAddrress->total)}}
                        </td>
                        <td>
                            {{$deliveryAddrress->zona}}
                        </td>
                        <td>
                            {{$deliveryAddrress->itens}}
                        </td>
                        <td>
                            {{$deliveryAddrress->end_1}} -  {{$deliveryAddrress->end_2}} - {{$deliveryAddrress->bairro}}
                        </td>
                        <td>
                            {{$deliveryAddrress->observacao}}
                        </td>
                    </tr>
                @endforeach
        </table>
        <!-- /.box-body -->

        <!-- /.box -->

    @endif

</section>

</body>
</html>