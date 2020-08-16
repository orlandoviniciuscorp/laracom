@extends('layouts.front.app')
@include('layouts.front.header-cart')
@section('content')
    <br />


    <!-- Main content -->
    <section class="container content">
        <div class="row">
            <div class="box-body">
                @include('layouts.errors-and-messages')
            </div>
            <div class="col-md-12">
                <h1> <i class="fa fa-home"></i> Minha Conta</h1>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                        <div role="tabpanel" class="tab-pane @if(request()->input('tab') == 'orders')active @endif" id="orders">
                            @if(!$orders->isEmpty())
                                <table class="table">
                                <tbody>
                                <tr>
                                    <td>Número do Pedido</td>
                                    <td>Data</td>
                                    <td>Total</td>
                                    <td>Status</td>
                                    <td>Ações</td>
                                </tr>
                                </tbody>
                                <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>
                                            <a data-toggle="modal" data-target="#order_modal_{{$order['id']}}" title="Pedido" href="javascript: void(0)">#{{$order['id']}}</a>
                                            @include('front.modal-accounts-orders',['order'=>$order])
                                        </td>
                                        <td>
                                            {{ date('d/m/Y, h:i a', strtotime($order['created_at'])) }}
                                        </td>
                                        <td><span class="label @if($order['total'] != $order['total_paid']) label-danger @else label-success @endif">{{ config('cart.currency') }} {{ $order['total'] }}</span></td>
                                        <td><p class="text-center" style="color: #ffffff; background-color: {{ $order['status']->color }}">{{ $order['status']->name }}</p></td>
                                        <td>
                                            @if($order['fair']->status == 1 && ($order['order_status_id'] != 1
                                            && $order['order_status_id'] != 7))
                                                <form action="{{route('accounts.cancel-order')}}" method="post">
                                                    {{csrf_field()}}
                                                    <input type="hidden" name="order_id" value="{{$order['id']}}" />
                                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Essa operação não pode ser desfeita. Tem Certeza?')" >
                                                        <i class="fa fa-ban" aria-hidden="true"></i> Cancelar
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                    <!-- Button trigger modal -->

                                @endforeach
                                </tbody>
                            </table>
                                {{ $orders->links() }}
                            @else
                                <p class="alert alert-warning">Nenhum pedido encontrado <a href="{{ route('home') }}">Comece a comprar agora</a></p>
                            @endif
                        </div>
                    </div>
                </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
