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
                        <hr />
                        <h3>Revisão</h3>
                        <hr>
                        <ul class="list-unstyled">
                            <li>Items: {{ config('cart.currency_symbol') }} {{ $subtotal }}</li>
                            <li>Entrega: {{ config('cart.currency_symbol') }} {{ $shipping }}</li>
                            <li>Total: {{ config('cart.currency_symbol') }} {{ $total }}</li>
                        </ul>

                        <div class="btn-group">
                            <p><strong><small class="text-danger text">*Clique no botão abaixo para confirmar e finalizar sua compra.</small></strong></p>
                            <a href="{{ route('checkout.index') }}" class="btn btn-default">Back</a>
                            <button onclick="return confirm('Tem Certeza?')" class="btn btn-danger">Confirmar Compra</button>
                            <input type="hidden" id="billing_address" name="billing_address" value="{{ $billingAddress }}">
                            <input type="hidden" name="shipment_obj_id" value="{{ $shipmentObjId }}">
                            <input type="hidden" name="rate" value="{{ $rateObjectId }}">
                            <input type="hidden" name="courier_id" value="{{ $courier_id }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="box-body">
                            <hr />


                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection