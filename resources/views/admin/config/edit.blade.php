@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        @include('layouts.errors-and-messages')
        <div class="box">
            <form action="{{ route('admin.config.store') }}" method="post" class="form">
                <input type="hidden" name="id" value="{{$config->id}}" >
                <div class="box-body">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <h2>Configurações do Sistema</h2>
                    </div>
                    <br />
                    <div class="form-group">
                        <label for="name">Status do Site: <span class="text-danger">*</span></label>
                        <br />
                        <div class="btn-group" id="status" data-toggle="buttons">
                            <label class="btn btn-default btn-on btn-xs
                            @if($config->is_open == 1)
                                active
                            @endif
                            ">
                            <input type="radio" value="1" name="is_open"
                                   @if($config->is_open == 1)
                                    checked="checked"
                                   @endif
                            >Aberto</label>
                            <label class="btn btn-default btn-off btn-xs @if($config->is_open == 0) active @endif">
                                <input type="radio" value="0" name="is_open"
                                       @if($config->is_open == 0)
                                            checked="checked"
                                        @endif
                                >Fechado</label>
                        </div>
                    </div>
                    <br />
                    <div class="form-group">
                        <label for="name">Criação de feira automática: <span class="text-danger">*</span></label>
                        <br />
                        <div class="btn-group" id="status" data-toggle="buttons">
                            <label class="btn btn-default btn-on btn-xs
                                @if($config->is_fair_automatic == 1)
                                    active
@endif
                                    ">
                                <input type="radio" value="1" name="is_fair_automatic"
                                       @if($config->is_fair_automatic == 1)
                                       checked="checked"
                                        @endif
                                >Ligado
                            </label>
                            <label class="btn btn-default btn-off btn-xs @if($config->is_fair_automatic == 0) active @endif">
                                <input type="radio" value="0" name="is_fair_automatic"
                                       @if($config->is_fair_automatic == 0)
                                       checked="checked"
                                        @endif
                                >Desligado</label>
                        </div>
                    </div>
                    <br />
                    <div class="form-group">
                        <label for="name">Abertura automática: <span class="text-danger">*</span></label>
                        <br />
                        <div class="btn-group" id="status" data-toggle="buttons">
                            <label class="btn btn-default btn-on btn-xs
                                @if($config->is_automatic_open == 1)
                                            active
                                @endif
                                    ">
                                    <input type="radio" value="1" name="is_automatic_open"
                                           @if($config->is_automatic_open == 1)
                                           checked="checked"
                                            @endif
                                    >Ligado
                            </label>
                            <label class="btn btn-default btn-off btn-xs @if($config->is_automatic_open == 0) active @endif">
                                <input type="radio" value="0" name="is_automatic_open"
                                       @if($config->is_automatic_open == 0)
                                       checked="checked"
                                        @endif
                                >Desligado</label>
                        </div>
                    </div>
                    <br />
                    <div class="form-group">
                        <label for="name">Fechamento automático: <span class="text-danger">*</span></label>
                        <br />
                        <div class="btn-group" id="status" data-toggle="buttons">
                            <label class="btn btn-default btn-on btn-xs
                            @if($config->is_automatic_close == 1)
                                        active
                            @endif
                            ">
                                <input type="radio" value="1" name="is_automatic_close"
                                       @if($config->is_automatic_close == 1)
                                       checked="checked"
                                        @endif
                                >Ligado
                            </label>
                            <label class="btn btn-default btn-off btn-xs @if($config->is_automatic_close == 0) active @endif">
                                <input type="radio" value="0" name="is_automatic_close"
                                       @if($config->is_automatic_close == 0)
                                       checked="checked"
                                        @endif
                                >Desligado</label>
                        </div>
                    </div>
                    <br />
                    <div class="form-group">
                        <label for="name">Avisar de Estoque baixo: <span class="text-danger">*</span></label>
                        <br />
                        <div class="btn-group" id="status" data-toggle="buttons">
                            <label class="btn btn-default btn-on btn-xs
                            @if($config->is_warning_stock_low == 1)
                                    active
@endif
                                    ">
                                <input type="radio" value="1" name="is_warning_stock_low"
                                       @if($config->is_warning_stock_low == 1)
                                       checked="checked"
                                        @endif
                                >Ligado
                            </label>
                            <label class="btn btn-default btn-off btn-xs @if($config->is_warning_stock_low == 0) active @endif">
                                <input type="radio" value="0" name="is_warning_stock_low"
                                       @if($config->is_warning_stock_low == 0)
                                       checked="checked"
                                        @endif
                                >Desligado</label>
                        </div>
                    </div>
                    <br />
                    <div class="form-group">
                        <label for="quantity_stock_low">Aviso de Estoque Baixo: <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" name="quantity_stock_low" id="quantity_stock_low" placeholder="Estoque Baixo" class="form-control" value="{{ $config->quantity_stock_low }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="quantity_stock_low">Quantidade de Produtos nos mais vendidos: <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" name="quantity_top_sellers" id="quantity_top_sellers" placeholder="Quantos produtos" class="form-control" value="{{ $config->quantity_top_sellers }}">
                        </div>
                    </div>
                </div>

                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="btn-group">
                        <div class="btn-group">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-default">Voltar</a>
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection
