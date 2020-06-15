@if(!$products->isEmpty())
    <table class="table">
        <thead>
        <tr>
            <td>ID</td>
            <td>Nome</td>
            <td>Quantidade</td>
            <td>Preço</td>
            <td>Status</td>
            <td>Ações</td>
        </tr>
        </thead>
        <tbody>
        @foreach ($products as $product)
            <tr class="tab-content">
                <td>{{ $product->id }}</td>
                <td>
                    @if($admin->hasPermission('view-product'))
                        <a href="{{ route('admin.products.show', $product->id) }}">{{ $product->name }}</a>
                    @else
                        {{ $product->name }}
                    @endif
                </td>
                <td>{{ $product->quantity }}</td>
                <td>{{ config('cart.currency') }} {{ $product->price }}</td>
                <td>
                    @if($product->status == 1)
                        <span style="display: none; visibility: hidden">1</span>
                        <form action="{{route('admin.products.disabled',$product->id)}}" method="post">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fa fa-check"></i></button>
                        </form>
                    @else
                        <span style="display: none; visibility: hidden">0</span>
                        <form action="{{route('admin.products.enabled', $product->id)}}" method="post">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>
                        </form>
                    @endif
                </td>
                <td>
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="post" class="form-horizontal">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="delete">
                        <div class="btn-group">
                            @if($admin->hasPermission('update-product'))
                                <a href="{{ route('admin.products.edit', $product->id) }}"
                                   class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Editar</a>@endif
                            @if($admin->hasPermission('delete-product'))
                                <button onclick="return confirm('Tem certeza?')" type="submit"
                                        class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Apagar</button>@endif
                        </div>
                    </form>
                    <br />
                    <form action="{{route('admin.products.update-quantity')}}" method="post"  class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="col-sm-5">
                            <input type="hidden" name="id" id="id" value="{{$product->id}}" />
                            <input type="number" name="quantity" id="quantity" value="{{$product->quantity}}" class="form-control">
                        </div>
                        <button onclick="return confirm('Tem certeza?')" type="submit" class="btn btn-success btn-sm">Atualizar</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif