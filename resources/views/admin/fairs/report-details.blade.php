@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">

    @include('layouts.errors-and-messages')
    <!-- Default box -->
            <div class="box">
                <div class="box-body">
                    <h3>{{env('APP_NAME')}} - {{$fair->name}}</h3>
                    <br />
                    <div class="box-tools">
                    <table class="table">
                        <thead>
                            <tr>
                                <td class="col-md-2">Pedido</td>
                                <td class="col-md-2">Cliente</td>
                                <td class="col-md-2">Tipo de Pagamento</td>
                                <td class="col-md-2">Total</td>
                                <td class="col-md-2">Total dos produtos</td>
                                <td class="col-md-2">Total das Entregas</td>
                                <td class="col-md-2">Status</td>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>
                                    {{$order->id}}
                                </td>
                                <td>
                                    {{$order->customer->name}}
                                </td>
                                <td>
                                    {{$order->payment}}
                                </td>
                                <td>
                                    {{$order->total}}
                                </td>
                                <td>
                                    {{$order->total_shipping}}
                                </td>
                                <td>
                                    {{$order->total_products}}
                                </td>
                                <td>
                                    {{$order->orderStatus->name}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    </div>
                    <hr>

                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    {{--{{ $orders->links() }}--}}
                </div>
            </div>
            <!-- /.box -->
    </section>
    <!-- /.content -->
@endsection