<!-- Modal -->
<div class="modal fade" id="order_send_feed_back" tabindex="-1" role="dialog" aria-labelledby="MyOrders">
    <div class="modal-dialog" role="document">
        <form action="{{route('send-feedback')}}" method="post">
            {{csrf_field()}}
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Feedback</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                </div>
                <div class="modal-body">
                    <label for="comentario">Feedback:</label>
                    <textarea name="comentario" class="col-12" rows="5"></textarea>
                </div>
                <div class="modal-footer">
                    <div class="col-5">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                    <div class="col-6 text-right">
                        <button type="submit" class="btn btn-success">Enviar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
