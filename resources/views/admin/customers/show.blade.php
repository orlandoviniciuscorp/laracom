@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-body">
                <h2>Cliente</h2>
                <table class="table">
                    <tbody>
                    <tr>
                        <td class="col-md-4">ID</td>
                        <td class="col-md-4">Nome</td>
                        <td class="col-md-4">Email</td>
                    </tr>
                    </tbody>
                    <tbody>
                    <tr>
                        <td>{{ $customer->id }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->email }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="box-body">
                <h2>Endereço</h2>
                <table class="table">
                    <tbody>
                    <tr>
                        <td class="col-md-2">Apelido</td>
                        <td class="col-md-2">Address 1</td>
                        <td class="col-md-2">Country</td>
                        <td class="col-md-2">Status</td>
                        <td class="col-md-4">Actions</td>
                    </tr>
                    </tbody>
                    <tbody>
                    @foreach ($addresses as $address)
                        <tr>
                            <td>{{ $address->alias }}</td>
                            <td>{{ $address->address_1 }}</td>
                            <td>{{ $address->country->name }}</td>
                            <td>@include('layouts.status', ['status' => $address->status])</td>
                            <td>
                                <form action="{{ route('admin.addresses.destroy', $address->id) }}" method="post" class="form-horizontal">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="_method" value="delete">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.customers.addresses.show', [$customer->id, $address->id]) }}" class="btn btn-default btn-sm"><i class="fa fa-eye"></i> Show</a>
                                        <a href="{{ route('admin.customers.addresses.edit', [$customer->id, $address->id]) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>
                                        <button onclick="return confirm('Tem Certeza?')" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Delete</button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="box-body">
                <h2>Pedidos ({{$customer->orders->count()}})</h2>
                <table class="table">
                    <tr>
                        <th>
                            #
                        </th>
                        <th>
                            Feira
                        </th>
                        <th>
                            Total
                        </th>
                        <th>
                            Status
                        </th>
                        <th>
                            Pagamento
                        </th>
                        @foreach($customer->orders as $order)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order->id) }}">#{{$order->id}}</a>
                                </td>
                                <td>
                                    {{$order->fair->name}}
                                </td>
                                <td>
                                    {{currency_format($order->total)}}
                                </td>
                                <td>
                                    {{$order->orderStatus->name}}
                                </td>
                                <td>
                                    {{$order->payment}}
                                </td>
                            </tr>
                        @endforeach
                    </tr>
                </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <div class="btn-group">
                    <a href="{{ route('admin.customers.index') }}" class="btn btn-default btn-sm">Back</a>
                </div>
            </div>
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
@endsection
