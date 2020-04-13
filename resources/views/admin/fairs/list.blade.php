@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">

    @include('layouts.errors-and-messages')
    <!-- Default box -->
        @if($fairs)
            <div class="box">
                <div class="box-body">
                    <h2>Feiras</h2>
                    @include('layouts.search', ['route' => route('admin.orders.index')])
                    <table class="table">
                        <thead>
                            <tr>
                                <td class="col-md-2">Nome</td>
                                <td class="col-md-2">Início</td>
                                <td class="col-md-2">Status</td>
                                <td class="col-md-6">Ações</td>
                                {{--<td class="col-md-2">Total</td>--}}
                                {{--<td class="col-md-2">Status</td>--}}
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($fairs as $fair)
                            <tr>
                                {{--<td><a title="Show order" href="{{ route('admin.orders.show', $order->id) }}">{{ date('M d, Y h:i a', strtotime($order->created_at)) }}</a></td>--}}
                                <td>{{$fair->name}}</td>
                                <td>{{$fair->start_at}}</td>
                                <td>
                                    @if( $fair->status == 0)
                                        <span class="label  label-danger">
                                            Fechada
                                        </span>
                                    @else
                                        <span class="label label-success">
                                            Aberta
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.fair.orders-list', $fair->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fa fa-money"></i> Pedidos
                                    </a>
                                    @if(auth()->guard('employee')->user()->hasRole('admin|superadmin'))
                                        <a href="{{ route('admin.fair.harvest', $fair->id) }}" class="btn btn-success btn-sm">
                                            <i class="fa fa-leaf" aria-hidden="true"></i> Colheita
                                        </a>
                                    @endif

                                    <a href="{{ route('admin.fair.labels', $fair->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fa fa-tag" aria-hidden="true"></i> Etiquetas
                                    </a>

                                    <a href="{{ route('admin.fair.delivery', $fair->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fa fa-tag" aria-hidden="true"></i> Pedidos e Entregas
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