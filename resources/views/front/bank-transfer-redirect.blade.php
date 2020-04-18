@extends('layouts.front.app')

@section('content')
    <div class="container product-in-cart-list">
        <div class="row">
            <div class="col-md-12">
                <ol class="breadcrumb">
                    <li><a href="{{ route('home') }}"> <i class="fa fa-home"></i> Home</a></li>
                    <li class="active">Carrinho de Compras</li>
                </ol>
            </div>
            <div class="col-md-12">
                <form action="{{ route('bank-transfer.store') }}" class="form-horizontal" method="post">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6">
                            <h3>Revisão</h3>
                            <hr>
                            <ul class="list-unstyled">
                                <li>Itens: {{ config('cart.currency_symbol') }} {{ $subtotal }}</li>
                                <li>Entrega: {{ config('cart.currency_symbol') }} {{ $shipping }}</li>
                                <li>Total: {{ config('cart.currency_symbol') }} {{ $total }}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="box-body">
                                <h3>Banco: Banco do Brasil</h3>
                                <hr>
                                <p>Código do Banco: <strong>001</strong></p>
                                <p>Tipo de Conta: <strong>Conta Corrente</strong></p>
                                <p>Beneficiário: <strong>Sarita De Cassia C. Marques </strong></p>
                                <p>Agência: <strong>1252-1</strong></p>
                                <p>Número da Conta: <strong> 21529-5</strong></p>
                                <p>CPF: <strong>126.853.717-96</strong></p>
                                <p>Valor: <strong> {{ config('cart.currency_symbol') }} {{ $total }}</strong></p>

                            </div>
                        </div>
                        {{--<div class="col-md-3">--}}
                            {{--<div class="box-body">--}}

                                {{--<h3>Banco: Nubank</h3>--}}
                                {{--<hr>--}}
                                {{--<p>Código do Banco: <strong>260</strong></p>--}}
                                {{--<p>Tipo de Conta: <strong>Conta Corrente</strong></p>--}}
                                {{--<p>Beneficiário: <strong>Sarita De Cassia C. Marques </strong></p>--}}
                                {{--<p>Agência: <strong>0001</strong></p>--}}
                                {{--<p>Número da Conta: <strong> 35644330-6 </strong></p>--}}
                                {{--<p>CPF: <strong>126.853.717-96</strong></p>--}}
                                {{--<p>Valor: <strong> {{ config('cart.currency_symbol') }} {{ $total }}</strong></p>--}}

                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="col-md-3">--}}
                            {{--<div class="box-body">--}}

                                {{--<h3>Banco: Banco Itaú </h3>--}}
                                {{--<hr>--}}
                                {{--<p>Código do Banco: <strong>341</strong></p>--}}
                                {{--<p>Tipo de Conta: <strong>Conta Poupança</strong></p>--}}
                                {{--<p>Beneficiário: <strong>Mateus Ghiglione Santos </strong></p>--}}
                                {{--<p>Agência: <strong>9272 </strong></p>--}}
                                {{--<p>Conta Poupança: <strong> :00746-0  </strong></p>--}}
                                {{--<p>CPF: <strong>149.620.467-05 </strong></p>--}}
                                {{--<p>Valor: <strong> {{ config('cart.currency_symbol') }} {{ $total }}</strong></p>--}}

                            {{--</div>--}}
                        {{--</div>--}}
                    </div>
                    <hr />
                    <div class="row">
                            <div class="box-body">
                                <p><strong><small class="text-danger text">* {{ config('bank-transfer.note') }}</small></strong></p>
                                <p>
                                    <strong>
                                        <small class="text-danger text">
                                            *Enviar o comprovante de depósito com o número do pedido para o  número: (21) 99698-2844 - Sarita Coelho
                                            ou  (21) 99907-7750 Mateus Pamaru.
                                        </small>
                                    </strong>
                                </p>

                            <p><strong><small class="text-danger text">*Clique no botão abaixo para confirmar a compra e obter o número do Pedido.</small></strong></p>
                            <hr>
                            <div class="btn-group">
                                <a href="{{ route('cart.index') }}" class="btn btn-default">Back</a>
                                <button onclick="return confirm('Tem Certeza?')" class="btn btn-danger">Confirmar Compra</button>
                                <input type="hidden" id="billing_address" name="billing_address" value="{{ $billingAddress }}">
                                <input type="hidden" name="shipment_obj_id" value="{{ $shipmentObjId }}">
                                <input type="hidden" name="rate" value="{{ $rateObjectId }}">
                                <input type="hidden" name="courier_id" value="{{ $courier_id }}">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection