@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
    @include('layouts.errors-and-messages')
    <!-- Default box -->

            <div class="box">
                <div class="box-body">
                    <h3>Produtos Sem Categoria</h3>
                    <hr>
                    @foreach($productCategories as $product)
                        <div class="row">
                            <div class="col-sm-2">
                                {{$product->id}}
                            </div>
                            <div class="col-sm-2">
                                {{$product->name}}
                            </div>
                            <div class="col-sm-2">
                                <a href="{{ route('admin.products.edit', $product->id) }}"
                                   class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Editar</a>
                            </div>
                        </div>

                    @endforeach
                </div>
                <!-- /.box-body -->
                <div class="box-body">
                    <h3>Produtos Sem Produtor</h3>
                    <hr>
                    @foreach($productProducers as $product)
                        <div class="row">
                            <div class="col-sm-2">
                                {{$product->id}}
                            </div>
                            <div class="col-sm-2">
                                {{$product->name}}
                            </div>
                            <div class="col-sm-2">
                                <a href="{{ route('admin.products.edit', $product->id) }}"
                                   class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Editar</a>
                            </div>
                        </div>

                    @endforeach
                </div>
            </div>
            <!-- /.box -->


    </section>
    <!-- /.content -->
@endsection
