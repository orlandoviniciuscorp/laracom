<div class="modal fade" id="include_products_order_{{$order['id']}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="">
            <div class="modal-header">
                <h3 class="modal-title">Adicionar Produto</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-inline" method="post" action="{{route('admin.orders.update-products',$order['id'])}}">
                {{ csrf_field() }}
            <div class="modal-body" >

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

