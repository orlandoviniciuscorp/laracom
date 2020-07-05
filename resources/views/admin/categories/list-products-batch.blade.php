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
                    <h2>Produtos de {{$category}}</h2>
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
                                    {{ $product->name }}
                                </td>
                                <td>@include('layouts.status', ['status' => $product->status])</td>
                                <td>
                                    <input type="number" name="{{$product->id}}" value="{{$product->quantity}}" />
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
