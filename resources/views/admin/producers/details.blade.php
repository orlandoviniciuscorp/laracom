@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">

    @include('layouts.errors-and-messages')
    <!-- Default box -->
        @if($producer)
            <div class="box">
                <div class="box-body">
                    <h2>Produtor</h2>
                    <table class="table">
                        <thead>
                        <tr>
                            <td class="col-md-4">Nome</td>
                            <td class="col-md-4">Descrição</td>
{{--                            <td class="col-md-4">Logo</td>--}}
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $producer->name }}</td>
                                <td>{!! $producer->description !!} </td>
{{--                                <td>--}}
{{--                                    @if(isset($producer->cover))--}}
{{--                                        <img src="{{asset("storage/$producer->cover")}}" alt="category image" class="img-thumbnail">--}}
{{--                                    @endif--}}
{{--                                </td>--}}
                            </tr>
                        </tbody>
                    </table>
                </div>
                <form action="{{route('admin.producers.price-per-products.show',$producer->id)}}" method="post" >
                    {{ csrf_field() }}
                    <div class="box-body">
                        <h2>Produtos e preços</h2>

                        <div class="table-responsive-sm table-responsive-md">
                            Lista de Produtos
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <td>ID</td>
                                    <td>Nome</td>
                                    <td>Preço</td>
                                    <td>Status</td>
                                </tr>
                                </thead>
                                <tbody>

                        @foreach ($producer->producerDetails()->get() as $pd)
                                        <tr >
                                            <td>{{ $pd->id }}</td>
                                            <td>
                                                {{ $pd->product->name }}
                                            </td>
                                            <td>
                                                <input type="hidden" name="id_{{$pd->id}}" value="{{$pd->id}}" />
                                                <input type="text" pattern="[\d.]*" name="price_{{$pd->id}}" value="{{ $pd->product_price }}" />
                                            </td>

                                            <td>
                                                @include('layouts.status', ['status' => $pd->isAvailable()])
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        <button type="submit" class="btn btn-success"> Salvar</button>
                    </div>
{{--                @endif--}}
                </form>

                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="btn-group">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-default btn-sm">Voltar</a>
                    </div>
                </div>
            </div>
            <!-- /.box -->
        @endif

    </section>
    <!-- /.content -->
@endsection
