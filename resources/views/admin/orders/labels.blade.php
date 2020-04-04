@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">

    @include('layouts.errors-and-messages')
    <!-- Default box -->
        @if($orders)
            <div class="box">
                <div class="box-body">
                    <h2>Etiquetas</h2>
                    @foreach ($orders as $order)

                        {{--<div class="card" style="width: 18rem;">--}}
                            {{--<div class="card-body">--}}
                                {{--<h5 class="card-title">{{$order->customer->name}}</h5>--}}
                                {{--<h6 class="card-subtitle mb-2">{{$order->customer->email}}</h6>--}}
                                {{--<h6 class="card-subtitle mb-2">{{$order->address->phone}}</h6>--}}
                                {{--<h6 class="card-subtitle mb-2">R$ {{$order->total}}</h6>--}}
                                {{--<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>--}}
                                {{--<a href="#" class="card-link">Card link</a>--}}
                                {{--<a href="#" class="card-link">Another link</a>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        <table class="table" style="{background:white;border:1px solid black}">
                                <tr>
                                    <td style="border: none;">{{$order->customer->name}}</td>

                                </tr>
                                <tr>
                                    <td>{{$order->customer->email}}</td>
                                </tr>
                                <tr>
                                    <td>{{$order->address->phone}}</td>
                                </tr>
                                <tr>
                                    <td>R$ {{$order->total}}</td>
                                </tr>
                                <tr>
                                    <td><strong>{{$order->payment}}</strong></td>
                                </tr>
                                <tr>
                                    <td>{{ $order->courier->name }}</td>
                                </tr>
                                    @foreach($order->products as $product)
                                        <tr>
                                            <td>
                                                {{$product->name }} - {{$product->pivot->quantity }}
                                            </td>
                                        </tr>
                            @endforeach
                                </tr>
                                <tr>
                                    <td>
                                    {{$order->obs}}
                                    </td>
                                </tr>
                        </table>
                        <br />
                        @endforeach


                </div>
                <!-- /.box-body -->

            </div>
            <!-- /.box -->
        @endif

    </section>
    <!-- /.content -->
@endsection