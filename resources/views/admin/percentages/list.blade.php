@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
    @include('layouts.errors-and-messages')
    <!-- Default box -->
        @if(!$percentages->isEmpty())
            <div class="box">
                <div class="box-body">
                    <h2>Percentuais cadastrados</h2>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <td>ID</td>
                                <td>Nome</td>
                                <td>Produtor</td>
                                <td>Plataforma</td>
                                <td>Separação</td>
                                <td>Contato com Cliente</td>
                                <td>Caixinha</td>
                                <td>Repasse de Pagamentos</td>
                                <td>Contas</td>
                                <td>Conferência de Pagamentos</td>
                            </tr>
                            </thead>
                            <tbody>
                        @foreach($percentages as $percentage)

                        <tr >
                            <td>
                                <a href="{{route('admin.percentages.edit',$percentage->id)}}">
                                    {{ $percentage->id}}
                                </a>
                            </td>
                            <td>{{$percentage->name}}</td>
                            <td>{{is_null($percentage->farmer) ? 0 : $percentage->farmer}}% </td>
                            <td>{{is_null($percentage->plataform) ? 0 : $percentage->plataform}}% </td>
                            <td>{{is_null($percentage->separation) ? 0 : $percentage->separation}}% </td>
                            <td>{{is_null($percentage->client_contact) ? 0 : $percentage->client_contact}}% </td>
                            <td>{{is_null($percentage->fund) ? 0 : $percentage->fund}}% </td>
                            <td>{{is_null($percentage->payments_transfer) ? 0 : $percentage->payments_transfer}}% </td>
                            <td>{{is_null($percentage->accounting_close) ? 0 : $percentage->accounting_close}}% </td>
                            <td>{{is_null($percentage->payment_conference) ? 0 : $percentage->payment_conference}}% </td>
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
