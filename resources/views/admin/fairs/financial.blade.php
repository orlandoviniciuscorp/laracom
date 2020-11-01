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
                                <td>Tipo de Entrega</td>
                                <td>Tipo de Pagamento</td>
                                <td>Total de Produtos</td>
                                <td>Total de Entregas</td>
                                <td>Total</td>
                                <td>Quantidade de Cestas</td>
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
                                    {{currency_format($f->total_produtos)}}
                                </td>
                                <td>
                                    {{currency_format($f->total_entrega)}}
                                </td>
                                <td>
                                    @if($f->tipo_pagamento == 'Cartão - Pagamento na Entrega')
                                        {{currency_format($f->total*1.025)}}
                                        {{--{{currency_format($f->total)}}--}}
                                    @else
                                        {{currency_format($f->total)}}
                                    @endif
                                </td>
                                <td>
                                    {{$f->total_cestas}}
                                </td>

                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="6">
                                Cestas : {{$totalOrders}}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Arrecadado: {{currency_format($totalAmount)}}
                            </td>
                            <td  colspan="5">
                                <a href="{{ route('admin.fair.detail-export-fair', $fair->id) }}">
                                    <button name="excel_fair" class="btn btn-success">Exportar para o Excel</button>
                                </a>
                            </td>
                        </tr>
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
                        <br />
                        <a href="{{ route('admin.fair.detail-export-harverst-payment', $fair->id) }}">
                            <button name="report" class="btn btn-success">Exportar Produtos Vendidos</button>
                        </a>
                        <br />

                    <table class="table">
                        <thead>
                        <tr>
                            <td>Categoria</td>
                            <td>Produto</td>
                            <td>Qtd</td>
                            <td>Valor Vendido</td>
                            <td>Valor Produtor</td>
                            <td>Plataforma</td>
                            <td>Separação</td>
                            <td>Caixinha</td>
                            <td>Pagamentos</td>
                            <td>Contato Clientes</td>
                            <td>Contas</td>
                            <td>Conferencia</td>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($productors as $productor)
                                <tr>
                                    <td>{{$productor->produtor}}</td>
                                    <td>{{$productor->produto}}</td>
                                    <td>{{$productor->quantidade}}</td>
                                    <td>{{currency_format($productor->valor_vendido)}}</td>
                                    <td>{{currency_format($productor->valor_produtor)}}</td>
                                    <td>{{currency_format($productor->plataforma)}}</td>
                                    <td>{{currency_format($productor->separacao)}}</td>
                                    <td>{{currency_format($productor->caixinha)}}</td>
                                    <td>{{currency_format($productor->pagamentos)}}</td>
                                    <td>{{currency_format($productor->contato_cliente)}}</td>
                                    <td>{{currency_format($productor->contas)}}</td>
                                    <td>{{currency_format($productor->conferencia_pagamento)}}</td>
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