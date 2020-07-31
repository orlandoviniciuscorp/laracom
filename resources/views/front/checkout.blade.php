@extends('layouts.front.app')

@section('content')
    <div class="container product-in-cart-list">
        @if(!$products->isEmpty())
            <div class="row">
                <div class="col-md-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ route('home') }}"> <i class="fa fa-home"></i> Home</a></li>
                        <li class="active">Carrinho de Compras</li>
                    </ol>
                </div>
                <div class="col-md-12 content">
                    <div class="box-body">
                        @include('layouts.errors-and-messages')
                    </div>
                    @if(count($addresses) > 0)

                        <div class="row">
                            <div class="col-md-12">
                                @include('front.products.product-list-table', compact('products'))
                            </div>
                        </div>
                        @if(isset($addresses))
                            <div class="row">
                                <div class="col-md-12">
                                    <legend><i class="fa fa-home"></i> Endereços</legend>
                                    <table class="table table-striped">
                                        <thead>
                                            <th>Apelido</th>
                                            <th>Endereço</th>
                                            <th>Endereço de Cobrança</th>
                                            <th>Endereço de Entrega</th>
                                        </thead>
                                        <tbody>
                                            @foreach($addresses as $key => $address)
                                                <tr>
                                                    <td>{{ $address->alias }}</td>
                                                    <td>
                                                        {{ $address->address_1 }} {{ $address->address_2 }} <br />
                                                        @if(!is_null($address->province))
                                                            {{ $address->city }} {{ $address->province->name }} <br />
                                                        @endif
                                                        {{ $address->city }} {{ $address->state_code }} <br>
                                                        {{ $address->country->name }} {{ $address->zip }}
                                                    </td>
                                                    <td>
                                                        <label class="col-md-6 col-md-offset-3">
                                                        <input
                                                                    type="radio"
                                                                    value="{{ $address->id }}"
                                                                    name="billing_address"
                                                                    @if($billingAddress->id == $address->id) checked="checked"  @endif>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        @if($billingAddress->id == $address->id)
                                                            <label for="sameDeliveryAddress">
                                                                <input type="checkbox" id="sameDeliveryAddress" checked="checked"> Igual ao Endereço de Cobrança
                                                            </label>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tbody style="display: none" id="sameDeliveryAddressRow">
                                            @foreach($addresses as $key => $address)
                                                <tr>
                                                    <td>{{ $address->alias }}</td>
                                                    <td>
                                                        {{ $address->address_1 }} {{ $address->address_2 }} <br />
                                                        @if(!is_null($address->province))
                                                            {{ $address->city }} {{ $address->province->name }} <br />
                                                        @endif
                                                        {{ $address->city }} {{ $address->state_code }} <br>
                                                        {{ $address->country->name }} {{ $address->zip }}
                                                    </td>
                                                    <td></td>
                                                    <td>
                                                        <label class="col-md-6 col-md-offset-3">
                                                            <input
                                                                    type="radio"
                                                                    value="{{ $address->id }}"
                                                                    name="delivery_address"
                                                                    @if(old('') == $address->id) checked="checked"  @endif>
                                                        </label>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        @endif
                            <div class="row">
                                <div class="col-md-12">
                                    <legend><i class="fa fa-truck"></i> Entrega</legend>
                                    <table class="table table-striped">
                                        <thead>
                                            <th>Nome</th>
                                            <th>Descrição</th>
                                            <th>Custo</th>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{$courier->name}}</td>
                                                <td>{!! $courier->description !!}</td>
                                                <td>{{currency_format($courier->cost)}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div> <br>

                        <div>
                            <table class="table table-striped">
                                <tbody>
                                <tr>
                                    <td>Subtotal</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>{{config('cart.currency')}} {{ number_format($subtotal, 2, '.', ',') }}</td>
                                </tr>
                                @if(isset($courier))
                                    <tr>
                                        <td>Frete</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>{{config('cart.currency')}} {{ $courier->cost }}</td>
                                    </tr>
                                @endif
                                {{--<tr>--}}
                                {{--<td>Tax</td>--}}
                                {{--<td></td>--}}
                                {{--<td></td>--}}
                                {{--<td></td>--}}
                                {{--<td>{{config('cart.currency')}} {{ number_format($tax, 2) }}</td>--}}
                                {{--</tr>--}}
                                <tr>
                                    <td>Total</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>{{config('cart.currency')}} {{ number_format($total, 2, '.', ',') }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <form action="{{ route('checkout.store') }}" method="post">
                        <div class="row">
                            <div class="col-md-12">
                                <legend><i class="fa fa-commenting" aria-hidden="true"></i> Observação</legend>
                                <textarea name="obs" class="form-control"
                                          placeholder="Gostaria de Acrescentar alguma observação?">{{old('obs')}}</textarea>
                                <br />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <legend><i class="fa fa-credit-card"></i> Pagamento</legend>
                                <p><strong><small class="text">Em virtude do surto do Corona virus - Covid-19, dêem preferência para o pagamento por Transferência Bancária.</small></strong></p>
                                <p><strong><small class="text-danger text">ATENÇÃO! Sua compra ainda não foi confirmada. Após escolher o método de pagamento, clicar no botão Confirmar Compra.</small></strong></p>
                                <p><strong class="text-danger">ATENÇÃO! Verifique a nova conta de pagamento</strong></p>

                                    {{ csrf_field() }}
                                    <input type="hidden" name="courier_id" value="{{$courier->id}}" />
                                    <input type="hidden" name="billingAddress_id" value="{{$billingAddress->id}}" />

                                @if(isset($payments) && !empty($payments))
                                    <table class="table table-striped">
                                        <thead>
                                            <th >Método de Pagamento</th>
                                            <th >Observação</th>
                                            <th class=" text-left">Detalhes</th>
                                        </thead>
                                        <tbody>
                                        @foreach($payments as $payment)
                                           <tr>
                                               <td>
                                                   <label class="radio">
                                                    <input type="radio" name="payment_method" value="{{$payment['name']}}"/>
                                                   {{$payment['name']}}
                                                   </label>
                                               </td>
                                               <td>
                                                    {{$payment['note']}}
                                               </td>
                                               <td>
                                                   @if($payment['name'] =='Transferência Bancária')
                                                       <button type="button" class="btn btn-success"
                                                               data-toggle="modal"
                                                               data-target="#banco_do_brasil">
                                                           <i class="fa fa-university" aria-hidden="true"></i>
                                                           Banco do Brasil</button>

                                                       <button type="button" class="btn btn-success"
                                                               data-toggle="modal"
                                                               data-target="#nubank">
                                                           <i class="fa fa-university" aria-hidden="true">
                                                           </i> Nubank</button>
                                                   @endif
                                               </td>

                                           </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <p class="alert alert-danger">No payment method set</p>
                                @endif
                                    <a href="{{ route('cart.index') }}" class="btn btn-dark">Voltar</a>
                                    <button type="submit" onclick="return confirm('Tem Certeza?')" class="btn btn-danger">Confirmar Compra</button>
                                    <br />
                                    <br />
                            </div>
                        </div>
                        </form>
                        @include('front.debit-modal')

                    @else
                        <p class="alert alert-danger"><a href="{{ route('customer.address.create', [$customer->id]) }}">Nenhum endereço de entrega cadastrado. Cadastre aqui o seu endereço de entrega.</a></p>
                    @endif
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-md-12">
                    <p class="alert alert-warning">No products in cart yet. <a href="{{ route('home') }}">Show now!</a></p>
                </div>
            </div>
        @endif
    </div>
@endsection
@section('js')
    <script type="text/javascript">

        function setTotal(total, shippingCost) {
            let computed = +shippingCost + parseFloat(total);
            $('#total').html(computed.toFixed(2));
        }

        function setShippingFee(cost) {
            el = '#shippingFee';
            $(el).html(cost);
            $('#shippingFeeC').val(cost);
        }

        function setCourierDetails(courierId) {
            $('.courier_id').val(courierId);
        }

        $(document).ready(function () {

            let clicked = false;

            $('#sameDeliveryAddress').on('change', function () {
                clicked = !clicked;
                if (clicked) {
                    $('#sameDeliveryAddressRow').show();
                } else {
                    $('#sameDeliveryAddressRow').hide();
                }
            });

            let billingAddress = 'input[name="billing_address"]';
            $(billingAddress).on('change', function () {
                let chosenAddressId = $(this).val();
                $('.address_id').val(chosenAddressId);
                $('.delivery_address_id').val(chosenAddressId);
            });

            let deliveryAddress = 'input[name="delivery_address"]';
            $(deliveryAddress).on('change', function () {
                let chosenDeliveryAddressId = $(this).val();
                $('.delivery_address_id').val(chosenDeliveryAddressId);
            });

            let courier = 'input[name="courier"]';
            $(courier).on('change', function () {
                let shippingCost = $(this).data('cost');
                let total = $('#total').data('total');

                setCourierDetails($(this).val());
                setShippingFee(shippingCost);
                setTotal(total, shippingCost);
            });

            if ($(courier).is(':checked')) {
                let shippingCost = $(courier + ':checked').data('cost');
                let courierId = $(courier + ':checked').val();
                let total = $('#total').data('total');

                setShippingFee(shippingCost);
                setCourierDetails(courierId);
                setTotal(total, shippingCost);
            }
        });
    </script>
@endsection