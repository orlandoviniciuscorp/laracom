@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">



    @include('layouts.errors-and-messages')
    <!-- Default box -->
        @if($customers)
            <div class="box">
                <div class="box-body">
                    <h2>Histórico de Compras</h2>
                    @include('layouts.search', ['route' => route('admin.customers.index')])
                    <table class="table">
                        <thead>
                            <tr>
                                <td class="col-md-2">Cliente</td>
                                <td class="col-md-2">Compras</td>
                                <td class="col-md-2">Email</td>
                                <td class="col-md-4">Telefone</td>
                            </tr>
                        </thead>
                        <tbody>

                        @foreach ($customers as $customer)
                            <tr>
                                <td>{{ $customer->name }}</td>
                                <td>{{$customer->orders->count()}}</td>
                                <td>{{ $customer->email }}</td>
                                <td>
                                    @if($customer->addresses->count()> 0)
                                        {{$customer->addresses[0]->phone}}
                                    @endisset
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        @endif

    </section>
    <!-- /.content -->
@endsection