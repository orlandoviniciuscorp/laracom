@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
    @include('layouts.errors-and-messages')
    <!-- Default box -->
        @if($products)


                <div class="box">
                    <div class="box-body">
                        <div class="row">
                            <div class="panel-body">
                                <h3>Filtros:</h3>
                                <br />
                                <form action="{{route('admin.product.list.all-products')}}" method="get">
                                    <div class="col-sm-2">
                                        <input type="checkbox" name="include_disables"
                                                @if(request()->has('include_disables') &&
                                                    request()->get('include_disables') == 1)
                                                        checked="checked"
                                               @endif
                                               value="1"> Incluir Desabilitados
                                    </div>
                                    <div class="col-sm-2">
                                        @foreach($categories as $category)
                                            <input type="checkbox" name="categories[]"
                                            value="{{$category->id}}"
                                            @if(request()->has('categories') &&
                                                    in_array($category->id,request()->get('categories')))
                                                checked="checked"
                                            @endif
                                            > {{$category->name}} <br />
                                        @endforeach
                                    </div>
                                    <div class="col-sm-2">
                                        <button type="submit" class="btn btn-primary">Filtrar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <h2>Atualização em Massa</h2>
                        <form action="{{route('admin.products.update-quantity-batch')}}" method="post">
                            {{ csrf_field() }}
                        <table class="table">
                            <thead>
                            <tr>
                                <td class="col-md-3">Produto</td>
                                <td class="col-md-2">Quantidade</td>
                                <td class="col-md-2">Preço</td>
                                <td class="col-md-2">Em Promoção</td>
                                <td class="col-md-2">Status</td>
                                <td class="col-md-2">Produtor</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>
                                        <input type="hidden" name="id_{{$product->id}}" value="{{$product->id}}" >
                                        <input type="text" class="col-md-8" name="name_{{$product->id}}"
                                               value="{{$product->name}}" />
                                    </td>
                                    <td>
                                        <input type="number" required name="quantity_{{$product->id}}" value="{{$product->quantity}}" class="col-md-6"/>
                                    </td>
                                    <td>
                                        <input type="text" pattern="[\d.]*" required name="price_{{$product->id}}" value="{{$product->price}}" class="col-md-4"
                                        style="padding: 0px 0px 0px 0px"/>
                                    </td>
                                    <td>
                                        <div class="btn-group" id="status" data-toggle="buttons">
                                            <label class="btn btn-default btn-on btn-xs
                            @if($product->is_in_promotion == 1)
                                                    active
@endif
                                                    ">
                                                <input type="radio" value="1" name="promotion_{{$product->id}}"
                                                       @if($product->is_in_promotion == 1)
                                                       checked="checked"
                                                        @endif
                                                >Sim</label>
                                            <label class="btn btn-default btn-off btn-xs @if($product->is_in_promotion == 0) active @endif">
                                                <input type="radio" value="0" name="promotion_{{$product->id}}"
                                                       @if($product->is_in_promotion == 0)
                                                       checked="checked"
                                                        @endif
                                                >Não</label>
                                        </div>

                                    </td>

                                    <td>
                                        <div class="btn-group" id="status" data-toggle="buttons">
                                            <label class="btn btn-default btn-on btn-xs
                            @if($product->status == 1)
                                                    active
@endif
                                                    ">
                                                <input type="radio" value="1" name="status_{{$product->id}}"
                                                       @if($product->status == 1)
                                                       checked="checked"
                                                        @endif
                                                >Habilitado</label>
                                            <label class="btn btn-default btn-off btn-xs @if($product->status == 0) active @endif">
                                                <input type="radio" value="0" name="status_{{$product->id}}"
                                                       @if($product->status == 0)
                                                       checked="checked"
                                                        @endif
                                                >Desabilitado</label>
                                        </div>

                                    </td>

                                    <td>
                                        <select name="producers_{{$product->id}}[]" id="producers_{{$product->id}}"
                                                multiple="multiple" class="js-example-basic-multiple">
                                            @foreach($producers as $producer)
                                                <option value="{{$producer->id}}"
{{--                                                @if(!is_null($product->producers))--}}
                                                    @foreach($product->producers as $producerIn)
                                                        @if($producerIn->id == $producer->id)
                                                            selected
                                                        @endif
                                                    @endforeach
{{--                                                @endif--}}
                                                >{{$producer->name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <br />
                        <button type="submit" class="btn btn-success">Salvar</button>
                        {{--                    {{ $categories->links() }}--}}
                        </form>
                    </div>
                    <!-- /.box-body -->
                </div>

            <!-- /.box -->
        @endif

    </section>
    <!-- /.content -->

@endsection
