<!-- Modal -->
<div class="modal fade" id="order_modal_{{$order['id']}}" tabindex="-1" role="dialog" aria-labelledby="MyOrders">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Reference #{{$order['reference']}}</h4>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                    <th>Endereço</th>
                    <th>Forma de Pagamento</th>
                    <th>Total</th>
                    <th>Status</th>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <address>
                                <strong>{{$order['address']->alias}}</strong><br />
                                {{$order['address']->address_1}} {{$order['address']->address_2}}<br>
                            </address>
                        </td>
                        <td>{{$order['payment']}}</td>
                        <td>{{ config('cart.currency_symbol') }} {{$order['total']}}</td>
                        <td><p class="text-center" style="color: #ffffff; background-color: {{ $order['status']->color }}">{{ $order['status']->name }}</p></td>
                    </tr>
                    </tbody>
                </table>
                <hr>
                <p>Detalhes do Pedido:</p>
                <table class="table">
                    <thead>
                    <th>Produto</th>
                    <th>Quatidade</th>
                    <th>Preço</th>
                    <th>Foto</th>
                    </thead>
                    <tbody>
                    @foreach ($order['products'] as $product)
                        <tr>
                            <td>{{$product['name']}}</td>
                            <td>{{$product['pivot']['quantity']}}</td>
                            <td>{{$product['price']}}</td>
                            <td><img src="{{ asset("storage/".$product['cover']) }}" width=50px height=50px alt="{{ $product['name'] }}" class="img-orderDetail"></td>
                        </tr>
                    @endforeach
{{--                    <tr>--}}
{{--                        <td>--}}
{{--                            <select name="product_id" id="product_id">--}}
{{--                                <option value="">Adicionar Produto</option>--}}
{{--                                    @foreach($products as $product)--}}
{{--                                        <option value="{{$product->id}}">{{$product->name}} - R${{$product->price}}</option>--}}
{{--                                    @endforeach--}}
{{--                            </select>--}}
{{--                        </td>--}}
{{--                        <td>--}}
{{--                            <input type="number" min="1" name="quantity" value="1" class="col-sm-5">--}}
{{--                        </td>--}}
{{--                        <td>--}}

{{--                            <button type="button" class="btn btn-primary" data-toggle="modal"--}}
{{--                            data-target="#include_products_order_{{$order['id']}}" title="Pedido"--}}
{{--                                    href="javascript: void(0)"--}}
{{--                            >Adicionar Produto</button>--}}

{{--                            @include('front.include-products-modal',['order'=>$order])--}}
{{--                        </td>--}}
{{--                    </tr>--}}
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
