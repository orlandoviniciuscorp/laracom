@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">

    @include('layouts.errors-and-messages')
    <!-- Default box -->
        @if($producer)
            <div class="box">
                <div class="box-body">
                    <h2>Categorias</h2>
                    <table class="table">
                        <thead>
                        <tr>
                            <td class="col-md-4">Nome</td>
                            <td class="col-md-4">Descrição</td>
                            <td class="col-md-4">Logo</td>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $producer->name }}</td>
                                <td>{!! $producer->description !!} </td>
                                <td>
                                    @if(isset($producer->cover))
                                        <img src="{{asset("storage/$producer->cover")}}" alt="category image" class="img-thumbnail">
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @if(!$products->isEmpty())
                    <div class="box-body">
                        <h2>Produtos</h2>
                        @include('admin.shared.products', ['products' => $products])
                    </div>
                @endif
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="btn-group">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-default btn-sm">Back</a>
                    </div>
                </div>
            </div>
            <!-- /.box -->
        @endif

    </section>
    <!-- /.content -->
@endsection
