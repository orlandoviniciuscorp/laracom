<div class="modal fade" id="banco_do_brasil" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <hr />
                <h3>Banco: Banco do Brasil</h3>
                <hr>
                <p>Código do Banco: <strong>001</strong></p>
                <p>Tipo de Conta: <strong>Conta Corrente</strong></p>
                <p>Beneficiário: <strong>Jenifer Soares Medeiros</strong></p>
                <p>Agência: <strong>0315-8</strong></p>
                <p>Número da Conta: <strong> 51095-5</strong></p>
                <p>CPF: <strong>150.557.347-52</strong></p>
                @isset($total)
                    <p>Valor: <strong> {{ config('cart.currency_symbol') }} {{ $total }}</strong></p>
                @endisset
                <p><strong><small class="text-danger text">* {{ config('bank-transfer.note') }}</small></strong></p>
                <p><strong><small class="text-danger text">*Enviar o comprovante de depósito para o  número: (21) 99698-2844 - Sarita Marques</small></strong></p>
                <div class="modal-footer text-left">
                    @isset($courier)
                        <form action="{{ route('checkout.store') }}" method="post">
                            {{ csrf_field() }}

                            <input type="hidden" name="courier_id" value="{{$courier->id}}" />
                            <input type="hidden" name="billingAddress_id" value="{{$billingAddress->id}}" />
                            <input type="hidden" name="payment_method" value="Transferência Bancária"/>
                            <button type="submit" onclick="return confirm('Tem Certeza?')" class="btn btn-danger pull-left">Confirmar Compra</button>
                        </form>
                    @endisset
                    <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
</div>

<div class="modal fade" id="nubank" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <hr />
                <h3>Banco: Nubank</h3>
                <hr>
                <p>Código do Banco: <strong>260</strong></p>
                <p>Tipo de Conta: <strong>Conta Corrente</strong></p>
                <p>Beneficiário: <strong>Sarita de Cássia Coelho Marques</strong></p>
                <p>Agência: <strong>0001</strong></p>
                <p>Número da Conta: <strong> 35644330-6</strong></p>
                <p>CPF: <strong>126.853.717-96</strong></p>
                @isset($total)
                    <p>Valor: <strong> {{ config('cart.currency_symbol') }} {{ $total }}</strong></p>
                @endisset
                <p><strong><small class="text-danger text">* {{ config('bank-transfer.note') }}</small></strong></p>
                <p><strong><small class="text-danger text">*Enviar o comprovante de depósito para o  número: (21) 99698-2844 - Sarita Marques</small></strong></p>
                    <div class="modal-footer text-left">
                        @isset($courier)
                            <form action="{{ route('checkout.store') }}" method="post">
                                {{ csrf_field() }}

                                <input type="hidden" name="courier_id" value="{{$courier->id}}" />
                                <input type="hidden" name="billingAddress_id" value="{{$billingAddress->id}}" />
                                <input type="hidden" name="payment_method" value="Transferência Bancária"/>
                                <button type="submit" onclick="return confirm('Tem Certeza?')" class="btn btn-danger pull-left">Confirmar Compra</button>
                            </form>
                        @endisset
                        <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal">Fechar</button>
                    </div>
            </div>
        </div>
</div>

