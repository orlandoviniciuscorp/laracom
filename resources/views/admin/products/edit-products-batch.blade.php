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
{{--                                        @if(request()->has('page'))--}}
{{--                                            <input type="hidden" name="page" value="{{request()->get('page')}}" />--}}
{{--                                        @endif--}}
                                        <input type="checkbox" name="include_disables"
                                                @if(request()->has('include_disables') &&
                                                    request()->get('include_disables') == 1)
                                                        checked="checked"
                                               @endif
                                               value="1"> Incluir Desabilitados <br /> <br />
                                        <input type="checkbox" name="only_promotions"
                                               @if(request()->has('only_promotions') &&
                                                   request()->get('only_promotions') == 1)
                                               checked="checked"
                                               @endif
                                               value="1"> Somente em Promoção
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
                        {{$products->appends(request()->all())->links()}}
                        <h2>Atualização em Massa</h2>
                        <div>

                        <div class="row">
                            <div class="col-md-3">Produto</div>
                            <div class="col-md-2">Quantidade</div>
                            <div class="col-md-1">Preço</div>
                            <div class="col-md-1">Em Promoção</div>
                            <div class="col-md-2">Status</div>
                            <div class="col-md-2">Produtor</div>
                        </div>
                            @foreach ($products as $product)
                                <div class="row" >
                                    <livewire:admin.products.edit :product="$product" wire:key="$product->id" />
                                    <hr />
                                </div>
                            @endforeach





                    </div>


                    <!-- /.box-body -->


            <!-- /.box -->
        @endif

    </section>
    <!-- /.content -->

@endsection
