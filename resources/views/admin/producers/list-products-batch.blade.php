@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
    @include('layouts.errors-and-messages')
    <!-- Default box -->
        @if($products)
            <form action="{{route('admin.products.update-quantity-batch')}}" method="post">
                {{ csrf_field() }}
                <div class="box">
                    <div class="box-body">
                        <h2>Produtos de {{$producer}}</h2>
                        <table class="table">
                            <thead>
                            <tr>
                                <td class="col-md-3">Produto</td>
                                <td class="col-md-1">Status</td>
                                <td class="col-md-2">Quantidade</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>
                                        <input type="hidden" name="id_{{$product->id}}" value="{{$product->id}}" >
                                        <input type="text" class="col-md-8" name="name_{{$product->id}}" value="{{$product->name}}" />
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
                                        <input type="number" name="quantity_{{$product->id}}" value="{{$product->quantity}}" />
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <br />
                        <button type="submit" class="btn btn-success">Salvar</button>
                        {{--                    {{ $categories->links() }}--}}
                    </div>
                    <!-- /.box-body -->
                </div>
            </form>
            <!-- /.box -->
        @endif

    </section>
    <!-- /.content -->
@endsection
