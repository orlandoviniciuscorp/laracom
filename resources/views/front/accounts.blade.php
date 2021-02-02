@extends('layouts.front.app')

@section('content')
    <!-- Main content -->
    <section class="container content">
        <div class="row">
            <div class="col-md-12">
                <div>
                    <!-- Tab panes -->
                    <div class="tab-content customer-order-list">
                        <div role="tabpanel" class="tab-pane active" id="profile">
                            <h6><strong>Cliente: </strong>{{$customer->name}}</h6>
                            <br />
                            <h6><strong>Email: </strong>{{$customer->email}}</h6>
                        <div role="tabpanel" class="tab-pane active" id="profile">
                            <hr/>
                            <button type="button" class="btn btn-success"
                                    data-toggle="modal"
                                    data-target="#banco_do_brasil">
                                <i class="fa fa-university" aria-hidden="true"></i>
                                Banco do Brasil</button>

                            <button type="button" class="btn btn-success"
                                    data-toggle="modal"
                                    data-target="#nubank">
                                <i class="fa fa-university" aria-hidden="true"></i> Nubank</button>

                            <button type="button" class="btn btn-success"
                                    data-toggle="modal"
                                    data-target="#pix">
                                <i class="fa fa-plus-circle" aria-hidden="true"></i> PIX</button>

                        </div>
                    </div>

                </div>
                <br />
            </div>
        </div>
        @include('front.debit-modal')
    @include('front.addresses')
    <!-- /.content -->
        </div>
    </section>
@endsection
