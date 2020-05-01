<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detalhes da Compra</title>
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <style type="text/css">
        table { border-collapse: collapse;}
    </style>
</head>
<body>
    <section class="row">
        <div class="pull-left">
            Cliente: {{$customer->name}} <br />
            Entregue em: <strong>{{ $address->alias }} <br /></strong>
            {{ $address->address_1 }} {{ $address->address_2 }} <br />
            {{ $address->city }} {{ $address->province }} <br />
            {{ $address->country }} {{ $address->zip }}
        </div>
        <div class="pull-right">
            De: {{config('app.name')}}
        </div>
    </section>
    <hr>
    <section class="row">
        <div class="pull-left">
            <p><strong>Banco: Banco do Brasil</strong></p>

            <p>Código do Banco: <strong>001</strong></p>
            <p>Tipo de Conta: <strong>Conta Corrente</strong></p>
            <p>Beneficiário: <strong>Jenifer Soares Medeiros</strong></p>
            <p>Agência: <strong>0315-8</strong></p>
            <p>Número da Conta: <strong> 51095-5</strong></p>
            <p>CPF: <strong>150.557.347-52</strong></p>
        </div>
    </section>
    <section class="row">
        <div class="pull-left">
            <p><strong>Banco: Nubank</strong></p>
            <p>Código do Banco: <strong>260</strong></p>
            <p>Tipo de Conta: <strong>Conta Corrente</strong></p>
            <p>Beneficiário: <strong>Sarita de Cássia Coelho Marques</strong></p>
            <p>Agência: <strong>0001</strong></p>
            <p>Número da Conta: <strong> 35644330-6</strong></p>
            <p>CPF: <strong>126.853.717-96</strong></p>
        </div>
    </section>
    <hr>
    <section class="row">
        <div class="col-md-12">
            <h2>Detalhes</h2>
            <table class="table table-striped" width="100%" border="1" cellspacing="0" cellpadding="0">
                <thead>
                    <tr>
                        <th>Código Produto</th>
                        <th>Produto</th>
                        <th>Descrição</th>
                        <th>Quantidade</th>
                        <th>Preço</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{$product->sku}}</td>
                        <td>{{$product->name}}</td>
                        <td>{!! $product->description !!}</td>
                        <td>{{$product->pivot->quantity}}</td>
                        <td> {{currency_format($product->price)}}</td>
                        <td> {{currency_format(number_format($product->price * $product->pivot->quantity, 2))}}</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td>Entrega</td>
                    <td>{{$order->courier->name}}</td>
                    <td>{{$order->courier->description}}</td>
                    <td>1</td>
                    <td> {{currency_format($order->courier->cost)}}</td>
                    <td> {{currency_format($order->courier->cost)}}</td>
                </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Subtotal:</td>
                        <td>{{$order->total_products}}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Discounts:</td>
                        <td>{{$order->discounts}}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Tax:</td>
                        <td>{{$order->tax}}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><strong>Total:</strong></td>
                        <td><strong>{{$order->total}}</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </section>
</body>
</html>