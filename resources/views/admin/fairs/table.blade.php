
<table class="table">
    <thead>
        <tr>
            <td>Sitio/Produtor</td>
            <td>Produto</td>
            <td>Preço Comsumidor</td>
            <td>Preço Produtor</td>
            <td>Quantidade</td>
{{--            <td>Total Consumidor</td>--}}
            <td>Total Produtor</td>
            <td>Gestão</td>
            <td>Soma Produtor</td>
        </tr>
    </thead>
    <tbody>
    @foreach ($fair->fairFinancials as $fairFinancial)
        <tr>
            <td>{{$fairFinancial->producer->name}}</td>
            <td>{{$fairFinancial->product->name}}</td>
            <td>{{currency_format($fairFinancial->product->price)}}</td>
            <td>{{currency_format($fairFinancial->product->price*
                $fairFinancial->product->percentage->farmer/100)}}</td>
            <td>{{$fairFinancial->quantity}}</td>
{{--            <td>{{currency_format($fairFinancial->product->price * $fairFinancial->quantity)}}</td>--}}
            <td>{{currency_format($fairFinancial->farmer)}}</td>
            <td>{{currency_format($fairFinancial->plataform +
            $fairFinancial->separation +
            $fairFinancial->fund +
            $fairFinancial->payments_transfer +
            $fairFinancial->accounting_close +
            $fairFinancial->client_contact +
            $fairFinancial->payment_conference) }}</td>
            <td>{{currency_format($fairFinancial->sumProducer())}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
@if($fair->fairFinancials->count() > 0)
<table class="table">
    <tr>
        <th colspan="2">
            Pagamento Pelos trabalhos
        </th>
    </tr>
    <tr>
        <td>
            Plataforma
        </td>
        <td>
            {{currency_format($fair->fairFinancials[0]->sumPlataform())}}
        </td>
    </tr>
    <tr>
        <td>
            Separação
        </td>
        <td>
            {{currency_format($fair->fairFinancials[0]->sumSeparation())}}
        </td>
    </tr>
    <tr>
        <td>
            Caixinha
        </td>
        <td>
            {{currency_format($fair->fairFinancials[0]->sumFund())}}
        </td>
    </tr>
    <tr>
        <td>
            Relização dos Pagamenos
        </td>
        <td>
            {{currency_format($fair->fairFinancials[0]->sumPaymentsTransfer())}}
        </td>
    </tr>
    <tr>
        <td>
            Fechamento das Contas
        </td>
        <td>
            {{currency_format($fair->fairFinancials[0]->sumAccountingClose())}}
        </td>
    </tr>
    <tr>
        <td>
            Contato com os Clientes
        </td>
        <td>
            {{currency_format($fair->fairFinancials[0]->sumClientContact())}}
        </td>
    </tr>
    <tr>
        <td>
            Conferência de Pagamentos
        </td>
        <td>
            {{currency_format($fair->fairFinancials[0]->sumPaymentConference())}}
        </td>
    </tr>

</table>

<table class="table">
    <thead>
    <tr>
        <th colspan="9">
            Detalhes dos pagamentos
        </th>
    </tr>
    <tr>
        <td>Pedido</td>
        <td>Cliente</td>
        <td>Telefone</td>
        <td>e-mail</td>
        <td>Tipo de Pagamento</td>
        <td>Produtos</td>
        <td>Entrega</td>
        <td>Total</td>
        <td>Status</td>
    </tr>
    </thead>
    <tbody>
    @foreach ($fair->orders as $order)
        <tr @if($order->orderStatus->name == 'Cancelado')class="danger"@endif >
            <td>
                #{{$order->id}}
            </td>
            <td>
                {{$order->customer->name}}
            </td>
            <td>
                {{$order->address->phone}}
            </td>
            <td>
                {{$order->customer->email}}
            </td>
            <td>
                {{$order->payment}}
            </td>
            <td>
                {{currency_format($order->total_products)}}
            </td>
            <td>
                {{currency_format($order->total_shipping)}}
            </td>
            <td>
                {{currency_format($order->total)}}
            </td>
            <td>
                {{$order->orderStatus->name}}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endif