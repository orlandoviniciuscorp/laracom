<div class="modal fade" id="banco_do_brasil" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <hr />
            <h3>Banco: Banco do Brasil</h3>
            <hr>
            <p>Código do Banco: <strong>001</strong></p>
            <p>Tipo de Conta: <strong>Conta Corrente</strong></p>
            <p>Beneficiário: <strong>João Gabriel Pinheiro Borges</strong></p>
            <p>Agência: <strong>3096-1</strong></p>
            <p>Número da Conta: <strong> 17600-1</strong></p>
            <p>CPF: <strong>133.932.617-54</strong></p>
            @isset($total)
                <p>Valor: <strong> {{ config('cart.currency_symbol') }} {{ $total }}</strong></p>
            @endisset
            <p><strong><small class="text-danger text">* {{ config('bank-transfer.note') }}</small></strong></p>
            <p><strong><small class="text-danger text">*Enviar o comprovante de depósito para o  <br />
                        número: (62) 99864-9778 - João Gabriel</small></strong></p>
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
            <p>Beneficiário: <strong>João Gabriel Pinheiro Borges</strong></p>
            <p>Agência: <strong>0001</strong></p>
            <p>Número da Conta: <strong> 70922897-6</strong></p>
            <p>CPF: <strong>133.932.617-54</strong></p>
            @isset($total)
                <p>Valor: <strong> {{ config('cart.currency_symbol') }} {{ $total }}</strong></p>
            @endisset
            <p><strong><small class="text-danger text">* {{ config('bank-transfer.note') }}</small></strong></p>
            <p><strong><small class="text-danger text">*Enviar o comprovante de depósito para o  número: (62) 99864-9778 - João Gabriel</small></strong></p>
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

<div class="modal fade" id="pix" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <hr />
            <h3>PIX</h3>
            <hr>
            <p>Chave Pix: <strong>62998649778</strong></p>
            <p>Beneficiário: <strong>João Gabriel Pinheiro Borges</strong></p>
            @isset($total)
                <p>Valor: <strong> {{ config('cart.currency_symbol') }} {{ $total }}</strong></p>
            @endisset
            <p><strong><small class="text-danger text">* {{ config('bank-transfer.note') }}</small></strong></p>
            <p><strong><small class="text-danger text">*Enviar o comprovante de depósito para o  número: (62) 99864-9778 - João Gabriel</small></strong></p>
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
