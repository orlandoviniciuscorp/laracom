@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
    @include('layouts.errors-and-messages')
    <!-- Default box -->
        @if(!$coupons->isEmpty())
            <div class="box">
                <div class="box-body">
                    <h2>Cupons Cadastrados</h2>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <td>ID</td>
                                <td>Nome</td>
                                <td>Tipo</td>
                                <td>Percentual</td>
                                <td>Descrição</td>
                                <td>Início</td>
                                <td>Valido até</td>
                                <td>Status</td>
                                <td>Ações</td>
                            </tr>
                            </thead>
                            <tbody>
                        @foreach($coupons as $coupon)

                        <tr >
                            <td>{{ $coupon->id}}</td>
                            <td>{{$coupon->name}}</td>
                            <td>{{$coupon->couponType->name}}</td>
                            @if($coupon->couponType->name =='Percentual')
                                <td>{{$coupon->percentage}}%</td>
                            @else
                                <td>R$ {{$coupon->percentage}}</td>
                            @endif

                            <td>{{$coupon->description}}</td>
                            <td>{{$coupon->start_at}}</td>
                            <td>{{$coupon->expires_at}}</td>
                            <td>@include('layouts.status', ['status' => $coupon->status])</td>
                            <td>
                                <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="post" class="form-horizontal">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="_method" value="delete">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.coupons.edit', $coupon->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Editar</a>
                                        <button onclick="return confirm('Tem Certeza?')" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Apagar</button>
                                    </div>
                                </form>
                            </td>

                        </tr>
                        @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        @endif

    </section>
    <!-- /.content -->
@endsection
