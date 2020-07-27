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
                        </div>
                    </div>

                </div>
                <br />
            </div>
        </div>

    @include('front.addresses')
    <!-- /.content -->
    </section>
@endsection
