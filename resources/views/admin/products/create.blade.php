@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        @include('layouts.errors-and-messages')
        <div class="box">
            <form action="{{ route('admin.products.store') }}" method="post" class="form" enctype="multipart/form-data">
                <div class="box-body">
                    {{ csrf_field() }}
                    <div class="col-md-8">
                        <h2>Produto</h2>
                        <div class="form-group">
                            <label for="sku">Código <span class="text-danger">*</span></label>
                            <input type="text" name="sku" id="sku" placeholder="xxxxx" class="form-control" value="{{ $nextSKU }}">
                        </div>
                        <div class="form-group">
                            <label for="name">Nome <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" placeholder="Nome" class="form-control" value="{{ old('name') }}">
                        </div>
                        <div class="form-group">
                            <label for="description">Descrição </label>
                            <textarea class="form-control" name="description" id="description" rows="5" placeholder="Descrição">{{ old('description') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="cover">Foto de Capa </label>
                            <input type="file" name="cover" id="cover" class="form-control" {{old('cover')}}>
                        </div>
                        {{--<div class="form-group">--}}
                            {{--<label for="image">Imagens</label>--}}
                            {{--<input type="file" name="image[]" id="image" class="form-control" multiple {{old('image[]')}}>--}}
                            {{--<small class="text-warning">Você pode usar o ctr (cmd) para selecionar mais de uma imagem</small>--}}
                        {{--</div>--}}
                        <div class="form-group">
                            <label for="quantity">Quantidade disponível <span class="text-danger">*</span></label>
                            <input type="text" name="quantity" id="quantity" placeholder="Quantidade" class="form-control" value="{{ old('quantity') }}">
                        </div>
                        <div class="form-group">
                            <label for="price">Preço <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-addon">R$</span>
                                <input type="text" name="price" id="price" placeholder="Preço" pattern="[\d.]*" class="form-control" value="{{ old('price') }}">
                            </div>
                            <small class="text-danger">Para valores com centavos utilize ponto</small>
                        </div>

                        <div class="form-group">
                            <label for="is_distinct">Produto diferenciável <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input
                                            type="radio"
                                            name="is_distinct"
                                            id="is_distinct"
                                            @if(is_null(old('is_distinct')) || old('is_distinct') == 0)
                                            checked="checked"
                                            @endif
                                            value="0"> Não
                                    <br/>
                                    <input
                                            type="radio"
                                            name="is_distinct"
                                            id="is_distinct"
                                            @if(old('is_distinct') == 1)
                                            checked="checked"
                                            @endif
                                            value="1"> Sim



                                </div>
                            </label>
                        </div>
                        <div class="form-group">
                        <label for="status">Percentual </label>
                        <select name="percentage_id" id="status" class="form-control select2">
                            @foreach($percentages as $percentage)
                            <option value="{{$percentage->id}}"
                                    @if(((!is_null(old('percentage_id'))
                                    && old('percentage_id') == $percentage->id)))
                                        selected="selected"
                                    @endif>{{$percentage->name}}</option>
                            @endforeach
                        </select>
                        </div>


                        @if(!$brands->isEmpty())
                        <div class="form-group">
                            <label for="brand_id">Brand </label>
                            <select name="brand_id" id="brand_id" class="form-control select2">
                                <option value=""></option>
                                @foreach($brands as $brand)
                                    <option @if(old('brand_id') == $brand->id) selected="selected" @endif value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                        @include('admin.shared.status-select', ['status' => 0])
                        {{--@include('admin.shared.attribute-select', [compact('default_weight')])--}}
                    </div>
                    <div class="col-md-4">
                        <h2>Categorias</h2>
                        @include('admin.shared.categories', ['categories' => $categories, 'selectedIds' => []])
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
