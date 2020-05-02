@extends('layouts.front.app')

@section('content')
    <!-- Main content -->
    <section class="container content">
        <div class="row">
            <div class="box-body">
                @include('layouts.errors-and-messages')
            </div>
            <div class="col-md-12">
                <h2> <i class="fa fa-home"></i> Minha Conta</h2>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" @if(request()->input('tab') == 'profile') class="active" @endif><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Perfil</a></li>
                        <li role="presentation" @if(request()->input('tab') == 'orders') class="active" @endif><a href="#orders" aria-controls="orders" role="tab" data-toggle="tab">Pedidos</a></li>
                        <li role="presentation" @if(request()->input('tab') == 'address') class="active" @endif><a href="#address" aria-controls="address" role="tab" data-toggle="tab">Endereços</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content customer-order-list">
                        <div role="tabpanel" class="tab-pane @if(request()->input('tab') == 'profile')active @endif" id="profile">
                            {{$customer->name}} <br /><small>{{$customer->email}}</small>
                        </div>
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
                        <div role="tabpanel" class="tab-pane @if(request()->input('tab') == 'address')active @endif" id="address">
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="{{ route('customer.address.create', auth()->user()->id) }}" class="btn btn-primary">Cadastrar Endereço</a>
                                </div>
                            </div>
                            @if(!$addresses->isEmpty())
                                <table class="table">
                                <thead>
                                    <th>Apelido</th>
                                    <th>Endereço</th>
                                    <th>Complemento</th>
                                    <th>Cidade</th>
                                    @if(isset($address->province))
                                    <th>Province</th>
                                    @endif
                                    <th>Estado</th>
                                    <th>País</th>
                                    <th>CEP</th>
                                    <th>Telefone</th>
                                    <th>Actions</th>
                                </thead>
                                <tbody>
                                    @foreach($addresses as $address)
                                        <tr>
                                            <td>{{$address->alias}}</td>
                                            <td>{{$address->address_1}}</td>
                                            <td>{{$address->address_2}}</td>
                                            <td>{{$address->city}}</td>
                                            @if(isset($address->province))
                                            <td>{{$address->province->name}}</td>
                                            @endif
                                            <td>{{$address->state_code}}</td>
                                            <td>{{$address->country->name}}</td>
                                            <td>{{$address->zip}}</td>
                                            <td>{{$address->phone}}</td>
                                            <td>
                                                <form method="post" action="{{ route('customer.address.destroy', [auth()->user()->id, $address->id]) }}" class="form-horizontal">
                                                    <div class="btn-group">
                                                        <input type="hidden" name="_method" value="delete">
                                                        {{ csrf_field() }}
                                                        <a href="{{ route('customer.address.edit', [auth()->user()->id, $address->id]) }}" class="btn btn-primary"> <i class="fa fa-pencil"></i> Edit</a>
                                                        <button onclick="return confirm('Tem Certeza?')" type="submit" class="btn btn-danger"> <i class="fa fa-trash"></i> Delete</button>
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                                <br /> <p class="alert alert-warning">Nenhum Endereço cadastrado</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
