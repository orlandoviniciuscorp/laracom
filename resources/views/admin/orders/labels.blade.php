@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">

    @include('layouts.errors-and-messages')
    <!-- Default box -->
        @if($orders)

                        <div class="container">
                            <aaa value="{{$count = 0}}"></aaa>
                            @foreach ($orders as $order)

                                @if($count != 0 && ($count % 2 == 0))
                                    </div>
                                @endif

                                @if($count % 2 == 0)
                                    <div class="row">
                                @endif
                                <div class="col-md-6">
                                    <div class="d-inline-block">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item"><strong>{{$order->customer->name}}</strong></li>
                                            <li class="list-group-item">{{$order->customer->email}}</li>
                                            <li class="list-group-item">{{$order->address->phone}}</li>
                                            <li class="list-group-item">{{currency_format($order->total)}}</li>
                                            @foreach($order->products as $product)
                                                <li class="list-group-item">{{$product->name }} - {{$product->pivot->quantity }}</li>
                                            @endforeach
                                            <li class="list-group-item">{{$order->obs}}</li>
                                        </ul>
                                    </div>

                                </div>

                            @endforeach
                        </div>
                    <!-- /.box-body -->


                <!-- /.box -->

        @endif

    </section>
    <!-- /.content -->
@endsection