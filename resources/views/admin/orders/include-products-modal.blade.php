<div class="modal fade" id="products_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="">
            <div class="modal-header">
                <h3 class="modal-title">Adicionar Produto</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-inline" method="post" action="{{route('admin.orders.update-products',$order->id)}}">
                {{ csrf_field() }}
            <div class="modal-body" >
                <div class="container-fluid">
                    <div class="form-group" id="select_products">
                        <label for="product_id">Produto:&nbsp;</label>
                            <select name="product_id" id="product_id"
                                    class="select2 col-md-8"
                                     >
                            @foreach($products as $product)
                                <option value="{{$product->id}}">{{$product->name}} - R${{$product->price}}</option>
                            @endforeach
                        </select>

                    </div>
                    <p>

                        Quantidade: <input type="number" min="1" name="quantity" value="1">

                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <div class="container-fluid">
                    <div class="col-md-8">
                        <span class="input-group-btn">
                                        <button
                                                class="btn btn-danger"
                                                type="button" data-dismiss="modal"
                                        >
                                            <i class="fa fa-times-circle-o" aria-hidden="true"></i> Cancelar</button>
                                    </span>
                    </div>

                    <div class="col-md-3">
                        <span class="input-group-btn">
                                        <button
                                                class="btn btn-primary"


                                        >
                                            <i class="fa fa-plus-circle" aria-hidden="true"></i> Adicionar Item</button>
                                    </span>
                     </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>

