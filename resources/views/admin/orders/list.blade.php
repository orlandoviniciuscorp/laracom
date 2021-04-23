@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">

    @include('layouts.errors-and-messages')
    <!-- Default box -->
        @if($orders)
            <div class="box">
                <div class="box-body">
                    <h2>Pedidos</h2>
                    @include('layouts.search', ['route' => route('admin.orders.index')])
                    <table class="table">
                        <thead>
                            <tr>
                                <td>Pedido</td>
                                <td>Data</td>
                                <td>Cliente</td>
                                <td>Entrega</td>
                                <td>Total</td>
                                <td>Status</td>
                                <td>Ações</td>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td><a title="Show order" href="{{ route('admin.orders.show', $order->id) }}">#{{$order->id}}</a></td>
                                <td>{{ date('M d, Y h:i a', strtotime($order->created_at)) }}</td>
                                <td>{{$order->customer->name}}</td>
                                <td>{{ $order->courier->name }}</td>
                                <td>
                                    <span class="label @if($order->total != $order->total_paid) label-danger @else label-success @endif">{{ currency_format($order->total) }}</span>
                                </td>
                                <td><p class="text-center" style="color: #ffffff; background-color: {{ $order->status->color }}">{{ $order->status->name }}</p></td>
                                <td>
                                    @if($order->status->id != env('ORDER_CANCELED'))
                                    <form method="post" action="{{route('admin.orders.mark-as-payed',$order->id)}}" >
                                        {{ csrf_field() }}
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="fa fa-check" aria-hidden="true"></i>
                                            Marcar como Pago
                                        </button>
                                    </form>

                                    <form action="{{route('admin.orders.cancel-order')}}" method="post">
                                        {{csrf_field()}}
                                        <input type="hidden" name="order_id" value="{{$order['id']}}" />
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Tem Certeza?')" >
                                            <i class="fa fa-ban" aria-hidden="true"></i> Cancelar
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    {{ $orders->links() }}
                </div>
            </div>
            <!-- /.box -->
        @endif

    </section>
    <!-- /.content -->
@endsection