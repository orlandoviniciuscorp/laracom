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
                                <td> Produtor </td>
                                <td> Plataforma </td>
                                <td> Separação </td>
                                <td> Caixinha </td>
                                <td> Sacolas e Embalagens </td>
                                <td> Pagamento online </td>
                                <td> Fechamento do Caixa </td>
                                <td> Marketing / Divulgação </td>
                                <td> Administração </td>
                                <td> Venda </td>
                                <td> Ponto de Retirada </td>
                                <td> Logística </td>
                                <td> Sac - Contato Cliente </td>
                            </tr>
                            </thead>
                            <tbody>
                        @foreach($percentages as $percentage)

                        <tr >
                            <td>{{ $percentage->id}}</td>
                            <td>{{$percentage->name}}</td>
                            <td> {{is_null($percentage->farmer) ? 0 : $percentage->farmer }}</td>
                            <td> {{is_null($percentage->plataform) ? 0 : $percentage->plataform }}</td>
                            <td> {{is_null($percentage->separation) ? 0 : $percentage->separation }}</td>
                            <td> {{is_null($percentage->fund) ? 0 : $percentage->fund }}</td>
                            <td> {{is_null($percentage->bags) ? 0 : $percentage->bags }}</td>
                            <td> {{is_null($percentage->payment_online) ? 0 : $percentage->payment_online }}</td>
                            <td> {{is_null($percentage->accounting_close) ? 0 : $percentage->accounting_close }}</td>
                            <td> {{is_null($percentage->marketing) ? 0 : $percentage->marketing }}</td>
                            <td> {{is_null($percentage->administration) ? 0 : $percentage->administration }}</td>
                            <td> {{is_null($percentage->seeller) ? 0 : $percentage->seeller }}</td>
                            <td> {{is_null($percentage->pickup_location) ? 0 : $percentage->pickup_location }}</td>
                            <td> {{is_null($percentage->logistic) ? 0 : $percentage->logistic }}</td>
                            <td> {{is_null($percentage->client_contact) ? 0 : $percentage->client_contact }}</td>
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
