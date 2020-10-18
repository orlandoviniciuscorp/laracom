@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        @include('layouts.errors-and-messages')
        <div class="box">
            <form action="{{ route('admin.products.update', $product->id) }}" method="post" class="form" enctype="multipart/form-data">
                <div class="box-body">
                    <div class="row">
                        {{ csrf_field() }}

                        <input type="hidden" name="origin" value="{{URL::previous()}}" />
                        <input type="hidden" name="_method" value="put">
                        <div class="col-md-12">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist" id="tablist">
                                <li role="presentation" @if(!request()->has('combination')) class="active" @endif><a href="#info" aria-controls="home" role="tab" data-toggle="tab">Info</a></li>
                                <li role="presentation" @if(request()->has('combination')) class="active" @endif><a href="#combinations" aria-controls="profile" role="tab" data-toggle="tab">Combinations</a></li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content" id="tabcontent">
                                <div role="tabpanel" class="tab-pane @if(!request()->has('combination')) active @endif" id="info">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <h2>{{ ucfirst($product->name) }}</h2>
                                            <div class="form-group">
                                                <label for="sku">Código <span class="text-danger">*</span></label>
                                                <input type="text" name="sku" id="sku" placeholder="xxxxx" class="form-control" value="{!! $product->sku !!}">
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Nome <span class="text-danger">*</span></label>
                                                <input type="text" name="name" id="name" placeholder="Name" class="form-control" value="{!! $product->name !!}">
                                            </div>
                                            <div class="form-group">
                                                <label for="description">Descrição </label>
                                                <textarea class="form-control ckeditor" name="description" id="description" rows="5" placeholder="Description">{!! $product->description  !!}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-3">
                                                    <div class="row">
                                                        <img src="{{ $product->cover }}" alt="" class="img-responsive img-thumbnail">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row"></div>
                                            <div class="form-group">
                                                <label for="cover">Foto de Capa </label>
                                                <input type="file" name="cover" id="cover" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                @foreach($images as $image)
                                                    <div class="col-md-3">
                                                        <div class="row">
                                                            <img src="{{ asset("storage/$image->src") }}" alt="" class="img-responsive img-thumbnail"> <br /> <br>
                                                            <a onclick="return confirm('Tem Certeza?')" href="{{ route('admin.product.remove.thumb', ['src' => $image->src]) }}" class="btn btn-danger btn-sm btn-block">Remove?</a><br />
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="row"></div>
                                            <div class="form-group">
                                                <label for="image">Imagens Adicionais</label>
                                                <input type="file" name="image[]" id="image" class="form-control" multiple>
                                                <span class="text-warning">You can use ctr (cmd) to select multiple images</span>
                                            </div>
                                            <div class="form-group">
                                                <label for="quantity">Quantidade disponível<span class="text-danger">*</span></label>
                                                @if($productAttributes->isEmpty())
                                                    <input
                                                            type="text"
                                                            name="quantity"
                                                            id="quantity"
                                                            placeholder="Quantity"
                                                            class="form-control"
                                                            value="{!! $product->quantity  !!}"
                                                    >
                                                @else
                                                    <input type="hidden" name="quantity" value="{{ $qty }}">
                                                    <input type="text" value="{{ $qty }}" class="form-control" disabled>
                                                @endif
                                                @if(!$productAttributes->isEmpty())<span class="text-danger">Note: Quantity is disabled. Total quantity is calculated by the sum of all the combinations.</span> @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="price">Preço</label>
                                                @if($productAttributes->isEmpty())
                                                    <div class="input-group">
                                                        <span class="input-group-addon">{{ config('cart.currency') }}</span>
                                                        <input type="text" pattern="[\d.]*" name="price" id="price" placeholder="Price" class="form-control" value="{!! $product->price !!}">
                                                    </div>
                                                    <small class="text-danger">Para valores com centavos utilize ponto</small>
                                                @else
                                                    <input type="hidden" name="price" value="{!! $product->price !!}">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">{{ config('cart.currency') }}</span>
                                                        <input type="text" id="price" pattern="[\d.]*" placeholder="Preço" class="form-control" value="{!! $product->price !!}" disabled>
                                                    </div>
                                                    <small class="text-danger">Para valores com centavos utilize ponto</small>
                                                @endif
                                                @if(!$productAttributes->isEmpty())<span class="text-danger">Note: Price is disabled. Price is derived based on the combination.</span> @endif
                                            </div>

{{--                                            <div class="form-group">--}}
{{--                                                <label for="producer_id">Produtor </label>--}}
{{--                                                <select name="producer_id" id="producer_id" class="form-control select2">--}}
{{--                                                    <option value=""></option>--}}
{{--                                                    @foreach($producers as $producer)--}}
{{--                                                        <option @if($producer->id == $product->producer_id) selected="selected" @endif value="{{ $producer->id }}">{{ $producer->name }}</option>--}}
{{--                                                    @endforeach--}}
{{--                                                </select>--}}
{{--                                            </div>--}}

                                            <div class="form-group">
                                                <label for="is_distinct">Produto diferenciável <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input
                                                            type="radio"
                                                            name="is_distinct"
                                                            id="is_distinct"
                                                            @if(isset($product->is_distinct) && $product->is_distinct == 0)   checked ='checked' @endif
                                                            value="0"> Não
                                                    <br/>
                                                    <input
                                                            type="radio"
                                                            name="is_distinct"
                                                            id="is_distinct"
                                                            @if(isset($product->is_distinct) && $product->is_distinct == 1)   checked ='checked' @endif
                                                            value="1"> Sim
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="status">Percentual </label>
                                                <select name="percentage_id" id="status" class="form-control select2">
                                                    @foreach($percentages as $percentage)
                                                        <option value="{{$percentage->id}}"
                                                                @if(((!is_null($product->percentage->id)
                                                                && $product->percentage->id == $percentage->id)))
                                                                selected="selected"
                                                                @endif>{{$percentage->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>


                                            <div class="form-group">
                                                <label for="table_percent">Tabela de Porcentagem</label>
                                                <div class="input-group">

                                                    @isset($product->percentage)

                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <th>
                                                                Produtor
                                                            </th>
                                                            <th>
                                                                Plataforma
                                                            </th>
                                                            <th>
                                                                Separação
                                                            </th>
                                                            <th>
                                                                Caixinha
                                                            </th>
                                                            <th>
                                                                Contas
                                                            </th>
                                                            <th>
                                                                Repasse de Pagamentos
                                                            </th>
                                                            <th>
                                                                Contato Cliente
                                                            </th>
                                                            <th>
                                                                Conferência Pagamento
                                                            </th>
                                                        </tr>

                                                        <tr>

                                                            <td>
                                                                {{is_null($product->percentage->farmer)
                                                                 ? 0 : $product->percentage->farmer}}%
                                                            </td>
                                                            <td>

                                                                {{is_null($product->percentage->plataform)
                                                                 ? 0 : $product->percentage->plataform}}%

                                                            </td>
                                                            <td>
                                                                {{is_null($product->percentage->separation)
                                                                 ? 0 : $product->percentage->separation}}%
                                                            </td>
                                                            <td>
                                                                {{is_null($product->percentage->fund)
                                                                 ? 0 : $product->percentage->fund}}%
                                                            </td>
                                                            <td>
                                                                {{is_null($product->percentage->payments_transfer)
                                                                 ? 0 : $product->percentage->payments_transfer}}%
                                                            </td>
                                                            <td>
                                                                {{is_null($product->percentage->accounting_close)
                                                                 ? 0 : $product->percentage->accounting_close}}%
                                                            </td>
                                                            <td>
                                                                {{is_null($product->percentage->client_contact)
                                                                 ? 0 : $product->percentage->client_contact}}%
                                                            </td>
                                                            <td>
                                                                {{is_null($product->percentage->payment_conference)
                                                                 ? 0 : $product->percentage->payment_conference}}%
                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                {{currency_format(($product->percentage->farmer)/100 *$product->price)}}
                                                            </td>
                                                            <td>
                                                                {{currency_format(($product->percentage->plataform)/100 *$product->price)}}
                                                            </td>
                                                            <td>
                                                                {{currency_format(($product->percentage->separation)/100 *$product->price)}}
                                                            </td>
                                                            <td>
                                                                {{currency_format(($product->percentage->fund)/100 *$product->price)}}
                                                            </td>
                                                            <td>
                                                                {{currency_format(($product->percentage->payments_transfer)/100 *$product->price)}}
                                                            </td>
                                                            <td>
                                                                {{currency_format(($product->percentage->accounting_close)/100 *$product->price)}}
                                                            </td>
                                                            <td>
                                                                {{currency_format(($product->percentage->client_contact)/100 *$product->price)}}
                                                            </td>
                                                            <td>
                                                                {{currency_format(($product->percentage->payment_conference)/100 *$product->price)}}
                                                            </td>

                                                        </tr>
                                                    </table>
                                                    @endif
                                                    <br />
                                                    {{--<a href="{{route('admin.percents.index',$product->id)}}"--}}
                                                       {{--class="btn btn-primary">Cadastrar Porcentagem</a>--}}
                                                </div>


                                            </div>

                                            @if(!$brands->isEmpty())
                                                <div class="form-group">
                                                    <label for="brand_id">Marca </label>
                                                    <select name="brand_id" id="brand_id" class="form-control select2">
                                                        <option value=""></option>
                                                        @foreach($brands as $brand)
                                                            <option @if($brand->id == $product->brand_id) selected="selected" @endif value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            @endif
                                                <div class="form-group">
                                                @include('admin.shared.status-select', ['status' => $product->status])
                                            </div>
                                            {{--@include('admin.shared.attribute-select', [compact('default_weight')])--}}
                                            <!-- /.box-body -->
                                        </div>
                                        <div class="col-md-4">
                                            <h2>Categorias</h2>
                                            @include('admin.shared.categories', ['categories' => $categories, 'ids' => $product])
                                        </div>
                                        <div class="col-md-4">
                                            <h2>Produtores</h2>
                                            @include('admin.shared.producers', ['producers' => $producers, 'ids' => $product])
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="box-footer">
                                            <div class="btn-group">
                                                <a href="{{ route('admin.products.index') }}" class="btn btn-default btn-sm">Voltar</a>
                                                <button type="submit" class="btn btn-primary btn-sm">Atualizar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane @if(request()->has('combination')) active @endif" id="combinations">
                                    <div class="row">
                                        <div class="col-md-4">
                                            @include('admin.products.create-attributes', compact('attributes'))
                                        </div>
                                        <div class="col-md-8">
                                            @include('admin.products.attributes', compact('productAttributes'))
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
@endsection
@section('css')
    <style type="text/css">
        label.checkbox-inline {
            padding: 10px 5px;
            display: block;
            margin-bottom: 5px;
        }
        label.checkbox-inline > input[type="checkbox"] {
            margin-left: 10px;
        }
        ul.attribute-lists > li > label:hover {
            background: #3c8dbc;
            color: #fff;
        }
        ul.attribute-lists > li {
            background: #eee;
        }
        ul.attribute-lists > li:hover {
            background: #ccc;
        }
        ul.attribute-lists > li {
            margin-bottom: 15px;
            padding: 15px;
        }
    </style>
@endsection
@section('js')
    <script type="text/javascript">
        function backToInfoTab() {
            $('#tablist > li:first-child').addClass('active');
            $('#tablist > li:last-child').removeClass('active');

            $('#tabcontent > div:first-child').addClass('active');
            $('#tabcontent > div:last-child').removeClass('active');
        }
        $(document).ready(function () {
            const checkbox = $('input.attribute');
            $(checkbox).on('change', function () {
                const attributeId = $(this).val();
                if ($(this).is(':checked')) {
                    $('#attributeValue' + attributeId).attr('disabled', false);
                } else {
                    $('#attributeValue' + attributeId).attr('disabled', true);
                }
                const count = checkbox.filter(':checked').length;
                if (count > 0) {
                    $('#productAttributeQuantity').attr('disabled', false);
                    $('#productAttributePrice').attr('disabled', false);
                    $('#salePrice').attr('disabled', false);
                    $('#default').attr('disabled', false);
                    $('#createCombinationBtn').attr('disabled', false);
                    $('#combination').attr('disabled', false);
                } else {
                    $('#productAttributeQuantity').attr('disabled', true);
                    $('#productAttributePrice').attr('disabled', true);
                    $('#salePrice').attr('disabled', true);
                    $('#default').attr('disabled', true);
                    $('#createCombinationBtn').attr('disabled', true);
                    $('#combination').attr('disabled', true);
                }
            });
        });
    </script>
@endsection