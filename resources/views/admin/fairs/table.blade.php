
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
        @if(!is_null($fairFinancial->product))
        <tr>

            <td>{{$fairFinancial->producer->name}}</td>
            <td>{{$fairFinancial->product->name ?? ''}}</td>
            <td>
                @if(isset($is_export))
                    {{($fairFinancial->product->price)}}
                @else
                    {{currency_format($fairFinancial->product->price)}}
                @endif
            </td>
            <td>
            @if(is_null($fairFinancial->unity_price_by_farmer))
                @if($is_export)

                        {{$fairFinancial->product->price*
                            $fairFinancial->product->percentage->farmer/100}}
                    @else
                        {{currency_format($fairFinancial->product->price*
                        $fairFinancial->product->percentage->farmer/100)}}

                    @endif
            @else

                @if(isset($is_export))
                    {{($fairFinancial->unity_price_by_farmer)}}
                    @else
                        {{currency_format($fairFinancial->unity_price_by_farmer)}}
                    @endif
            @endif
            </td>
            <td>{{$fairFinancial->quantity}}</td>
{{--            <td>{{currency_format($fairFinancial->product->price * $fairFinancial->quantity)}}</td>--}}
            <td>@if(isset($is_export))
                    {{($fairFinancial->farmer)}}</td>
                @else
                {{currency_format($fairFinancial->farmer)}}</td>
            @endif
            <td>@if(isset($is_export))
                    {{($fairFinancial->plataform +
                    $fairFinancial->separation +
                    $fairFinancial->fund +
                    $fairFinancial->payments_transfer +
                    $fairFinancial->accounting_close +
                    $fairFinancial->client_contact +
                    $fairFinancial->payment_conference)}}
                @else
                    {{currency_format($fairFinancial->plataform +
                    $fairFinancial->separation +
                    $fairFinancial->fund +
                    $fairFinancial->payments_transfer +
                    $fairFinancial->accounting_close +
                    $fairFinancial->client_contact +
                    $fairFinancial->payment_conference)}}
            @endif
             </td>
            <td>@if(isset($is_export))
                    {{($fairFinancial->sumProducer())}}</td>
                @else
                {{currency_format($fairFinancial->sumProducer())}}</td>
            @endif
        </tr>
        @endif
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
            @if(isset($is_export))
                {{($fair->fairFinancials[0]->sumPlataform())}}
            @else
            {{currency_format($fair->fairFinancials[0]->sumPlataform())}}
                @endif
        </td>
    </tr>
    <tr>
        <td>
            Separação
        </td>
        <td>
            @if(isset($is_export))
                {{($fair->fairFinancials[0]->sumSeparation())}}
            @else
            {{currency_format($fair->fairFinancials[0]->sumSeparation())}}
                @endif
        </td>
    </tr>
    <tr>
        <td>
            Caixinha
        </td>
        <td>
            @if(isset($is_export))
                {{($fair->fairFinancials[0]->sumFund())}}
            @else
            {{currency_format($fair->fairFinancials[0]->sumFund())}}
                @endif
        </td>
    </tr>
    <tr>
        <td>
            Relização dos Pagamenos
        </td>
        <td>
            @if(isset($is_export))
                {{($fair->fairFinancials[0]->sumPaymentsTransfer())}}
            @else
            {{currency_format($fair->fairFinancials[0]->sumPaymentsTransfer())}}
                @endif
        </td>
    </tr>
    <tr>
        <td>
            Fechamento das Contas
        </td>
        <td>
            @if(isset($is_export))
                {{($fair->fairFinancials[0]->sumAccountingClose())}}
            @else
            {{currency_format($fair->fairFinancials[0]->sumAccountingClose())}}
                @endif
        </td>
    </tr>
    <tr>
        <td>
            Contato com os Clientes
        </td>
        <td>
            @if(isset($is_export))
                {{($fair->fairFinancials[0]->sumClientContact())}}
            @else
            {{currency_format($fair->fairFinancials[0]->sumClientContact())}}
                @endif
        </td>
    </tr>
    <tr>
        <td>
            Conferência de Pagamentos
        </td>
        <td>
            @if(isset($is_export))
                {{($fair->fairFinancials[0]->sumPaymentConference())}}
            @else
            {{currency_format($fair->fairFinancials[0]->sumPaymentConference())}}
                @endif
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
                @if(isset($is_export))
                    {{($order->total_products)}}
                @else
                {{currency_format($order->total_products)}}
                    @endif
            </td>
            <td>
                @if(isset($is_export))
                    {{($order->total_shipping)}}
                @else
                {{currency_format($order->total_shipping)}}
                    @endif
            </td>
            <td>
                @if(isset($is_export))
                    {{($order->total)}}
                @else
                {{currency_format($order->total)}}
                    @endif
            </td>
            <td>
                {{$order->orderStatus->name}}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endif