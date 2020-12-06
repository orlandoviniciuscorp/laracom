@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        @include('layouts.errors-and-messages')
        <div class="box">
            <form action="{{ route('admin.coupons.store') }}" method="post" class="form">
                <div class="box-body">
                    {{ csrf_field() }}
                    <div class="col-md-6">
                        <h2>Cupons</h2>
                        <div class="form-group">
                            <label for="name">Nome <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" pattern="[a-zA-Z0-9-]+" required placeholder="Nome" class="form-control" value="{{ old('name') }}">
                            <small class="text-danger">Somente Letras e Numeros</small>
                        </div>
                        <div class="form-group">
                            <label for="description">Descrição </label>
                            <textarea class="form-control" name="description" id="description" rows="5" placeholder="Descrição">{{ old('description') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="customer">Tipo de Cupom</label>
                                <select name="coupon_type_id" id="coupon_type_id" class="form-control select2">
                                    @foreach($couponTypes as $couponType)
                                        <option value="{{ $couponType->id }}">{{ $couponType->name }}</option>
                                    @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="name">Valor <span class="text-danger">*</span></label>
                            <input type="text" name="percentage" id="percentage" placeholder="Valor"  pattern="[\d.]*" class="form-control" value="{{ old('percentage') }}">
                        </div>

                        <div class="form-group">
                            <label for="name">Início da Validade <span class="text-danger">*</span></label>
                            <input type="date" name="start_at" id="start_at" placeholder="dd/mm/yyy" class="form-control" value="{{ old('start_at') }}">
                        </div>

                        <div class="form-group">
                            <label for="name">Expira em: <span class="text-danger">*</span></label>
                            <input type="date" name="expires_at" id="expires_at" placeholder="dd/mm/yyyy" class="form-control" value="{{ old('expires_at') }}">
                        </div>
                        <input type="hidden" name="need_basket" value="0" />

                        <div class="form-group">
                            <label for="need_basket">Inclui Frete:</label>
                            <ul class="checkbox-list">
                                <li>
                                    <div class="radio">
                                        <label>
                                            <input
                                                    type="radio"
                                                    checked="checked"
                                                    name="include_delivery"
                                                    value="1" />
                                            Sim</label>

                                    </div>
                                </li>

                                <li>
                                    <div class="radio">
                                        <label>
                                            <input
                                                    type="radio"
                                                    name="include_delivery"
                                                    value="0" />
                                            Não</label>

                                    </div>
                                </li>
                            </ul>
                        </div>

                        @include('admin.shared.status-select', ['status' => 1])
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="btn-group">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-default">Voltar</a>
                        <button type="submit" class="btn btn-primary">Criar</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection
