@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">

    @include('layouts.errors-and-messages')
    <!-- Default box -->
            <div class="box">
                <div class="box-body">
                    <h3>{{$fair->name}}</h3>
                    <br />
                    <div class="box-tools">
                    <table class="table">
                        <thead>
                            <tr>
                                <td class="col-md-2">Tipo de Entrega</td>
                                <td class="col-md-2">Tipo de Pagamento</td>
                                <td class="col-md-2">Total de Produtos</td>
                                <td class="col-md-6">Total de Entregas</td>
                                <td class="col-md-6">Total</td>
                                <td class="col-md-6">Quantidade de Cestas</td>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($financial as $f)

                            <tr>
                                {{--<td>{{ date('M d, Y h:i a', strtotime($order->created_at)) }}</a></td>--}}
                                <td>
                                    {{$f->Entrega}}
                                </td>
                                <td>
                                    {{$f->tipo_pagamento}}
                                </td>
                                <td>
                                    {{$f->total_produtos}}
                                </td>
                                <td>
                                    {{$f->total_entrega}}
                                </td>
                                <td>
                                    {{$f->total}}
                                </td>
                                <td>
                                    {{$f->total_cestas}}
                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    </div>
                    <hr>
                    <div class="box-tools">
                        <a href="{{ route('admin.fair.detail-report', $fair->id) }}">
                            <button name="report" class="btn btn-success">Relatório Detalhado</button>
                        </a>

                    </div>

                    <hr/>
                    <div class="box-tools">
                    <h3>Pagamento por Produtor/Catergoria</h3>

                    <table class="table">
                        <thead>
                        <tr>
                            <td class="col-md-2">Produtor/Categoria</td>
                            <td class="col-md-2">Produto</td>
                            <td class="col-md-2">Quantidade</td>
                            <td class="col-md-2">Valor Vendido</td>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($productors as $productor)
                                <tr>
                                    <td>
                                        {{$productor->produtor}}
                                    </td>

                                    <td>
                                        {{$productor->produto}}
                                    </td>

                                    <td>
                                        {{$productor->quantidade}}
                                    </td>
                                    <td>
                                        {{$productor->valor_vendido}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>

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