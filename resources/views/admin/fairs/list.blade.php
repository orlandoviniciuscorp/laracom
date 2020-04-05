@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">

    @include('layouts.errors-and-messages')
    <!-- Default box -->
        @if($fairs)
            <div class="box">
                <div class="box-body">
                    <h2>Orders</h2>
                    @include('layouts.search', ['route' => route('admin.orders.index')])
                    <table class="table">
                        <thead>
                            <tr>
                                <td class="col-md-3">Nome</td>
                                <td class="col-md-3">Status</td>
                                <td class="col-md-2">Pedidos</td>
                                {{--<td class="col-md-2">Total</td>--}}
                                {{--<td class="col-md-2">Status</td>--}}
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($fairs as $fair)
                            <tr>
                                {{--<td><a title="Show order" href="{{ route('admin.orders.show', $order->id) }}">{{ date('M d, Y h:i a', strtotime($order->created_at)) }}</a></td>--}}
                                <td>{{$fair->name}}</td>
                                <td>{{ $fair->status == 1 ? 'Aberta' : 'Fechada'  }}</td>
                                <td>
                                    <a href="{{ route('admin.fair.orders-list', $fair->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fa fa-money"></i> Pedidos
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    {{--{{ $orders->links() }}--}}
                </div>
            </div>
            <!-- /.box -->
        @endif

    </section>
    <!-- /.content -->
@endsection