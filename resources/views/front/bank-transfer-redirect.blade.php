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
                    <div class="col-md-6">
                        <h3>Review</h3>
                        <hr>
                        <ul class="list-unstyled">
                            <li>Items: {{ config('cart.currency_symbol') }} {{ $subtotal }}</li>
                            <li>Entrega: {{ config('cart.currency_symbol') }} {{ $shipping }}</li>
                            <li>Total: {{ config('cart.currency_symbol') }} {{ $total }}</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <div class="box-body">
                            <h3>Banco: Banco do Brasil</h3>
                            <hr>
                            <p>Código do Banco: <strong>001</strong></p>
                            <p>Tipo de Conta: Conta Corrente</p>
                            <p>Beneficiário: Sarita De Cassia C. Marques </p>
                            <p>Agência: 1252-1</p>
                            <p>Número da Conta:21529-5</p>
                            <p>CPF: 126.853.717-96</p>
                            <p><strong><small class="text-danger text">* {{ config('bank-transfer.note') }}</small></strong></p>
                            <p><strong><small class="text-danger text">*Enviar o comprovante de depósito para o  número: (21) 96618-9093 - Jenifer</small></strong></p>
                            <hr>
                            <div class="btn-group">
                                <a href="{{ route('checkout.index') }}" class="btn btn-default">Back</a>
                                <button onclick="return confirm('Tem Certeza?')" class="btn btn-primary">Depositarei na conta informada! Finalizar o pedido.</button>
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