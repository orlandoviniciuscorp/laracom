@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Cestas AAT</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">


                <div class="container">
                    <div class="row">

                        <div class="col col-md-5">
                            <div class="card">
                                @isset($fair)
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item bg-info"><strong>{{$fair->name}}</strong></li>
                                    <li class="list-group-item">
                                        @if( $fair->status == 0)
                                            <span class="label  label-danger">
                                            Fechada
                                        </span>
                                        @else
                                            <span class="label label-success">
                                            Aberta
                                        </span>
                                        @endif
                                    </li>
                                    <li class="list-group-item">Inicio: {{$fair->start_at}}</li>
                                    <li class="list-group-item">Fim: {{$fair->end_at}}</li>
                                    <li class="list-group-item">Arrecadado: R$ {{$amount}}</li>
                                    {{--<li class="list-group-item">Conferido: R$ {{$amount}}</li>--}}

                                    <li class="list-group-item">Cestas: {{$totalOrders}}</li>
                                    <li class="list-group-item">
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
                                            <i class="fa fa-truck" aria-hidden="true"></i> Entregas
                                        </a>
                                    </li>

                                </ul>
                                    @else
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item bg-info"><strong>Ainda não há Feiras Criadas</strong></li>
                                    </ul>
                                @endisset
                            </div>

                        </div>

                        <div class="col col-md-5">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item bg-info"><strong>Opções</strong></li>


                                @if(auth()->guard('employee')->user()->hasRole('admin|superadmin'))
                                    <li class="list-group-item bg-info">
                                        <form action="{{route('admin.products.empty-availability')}}" method="post"  class="form-horizontal">
                                            {{ csrf_field() }}
                                            <button onclick="return confirm('Isso irá zerar de todos os produtores. Tem certeza?')" type="submit" class="btn btn-danger btn-sm">
                                                <i class="fa fa-eraser" aria-hidden="true"></i> Zerar Disponibilidade
                                            </button>
                                        </form>
                                    </li>

                                    <li class="list-group-item bg-info">
                                        <form action="{{route('admin.category.rotate-farmers')}}" method="post"  class="form-horizontal">
                                            {{ csrf_field() }}
                                            <button onclick="return confirm('Isso irá zerar de todos os produtores. Tem certeza?')" type="submit" class="btn btn-warning btn-sm">
                                                <i class="fa fa-refresh" aria-hidden="true"></i> Rotacionar Produtores
                                            </button>
                                        </form>
                                    </li>
                                @endif

                            </ul>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                Footer
            </div>
            <!-- /.box-footer-->
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection
