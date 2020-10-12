@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        @include('layouts.errors-and-messages')
        <div class="box">
            <form action="{{ route('admin.percentages.update') }}" method="post" class="form">
                <div class="box-body">
                    {{ csrf_field() }}
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="name">Nome <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" placeholder="Nome" class="form-control"
                                   value="{{ $percentage->name }}">
                            <input type="hidden" name="id" value="{{$percentage->id}}" />
                        </div>
                        <div class="input-group">
                            <table class="table table-bordered">
                                <tr>
                                    <th>
                                        Produtor
                                    </th>
                                    <th>
                                        Plataforma
                                    </th>
                                    <th>
                                        Separação
                                    </th>
                                    <th>
                                        Contato Cliente
                                    </th>
                                    <th>
                                        Caixinha
                                    </th>
                                    <th>
                                        Repasse de Pagamentos
                                    </th>
                                    <th>
                                        Contas
                                    </th>
                                    <th>
                                        Conferência Pagamento
                                    </th>

                                </tr>
                                <tr>
                                    <td>
                                        <input type="number" value="{{$percentage->farmer}}"
                                               name="farmer" id="farmer"
                                               class="form-control"/>
                                    </td>
                                    <td>

                                        <input type="number" value="{{$percentage->plataform}}"
                                               name="plataform" id="plataform"
                                               class="form-control"/>

                                    </td>
                                    <td>
                                        <input type="number" value="{{$percentage->separation}}"
                                               name="separation" id="separation"
                                               class="form-control"/>
                                    </td>
                                    <td>
                                        <input type="number" value="{{$percentage->client_contact}}"
                                               name="client_contact" id="client_contact"
                                               class="form-control"/>
                                    </td>
                                    <td>
                                        <input type="number" value="{{$percentage->fund}}"
                                               name="fund" id="fund"
                                               class="form-control"/>

                                    </td>
                                    <td>
                                        <input type="number" value="{{$percentage->payments_transfer}}"
                                               name="payments_transfer" id="payments_transfer"
                                               class="form-control"/>

                                    </td>
                                    <td>
                                        <input type="number" value="{{$percentage->accounting_close}}"
                                               name="accounting_close" id="accounting_close"
                                               class="form-control"/>
                                    </td>
                                    <td>
                                        <input type="number" value="{{$percentage->payment_conference}}"
                                               name="payment_conference" id="payment_conference"
                                               class="form-control"/>
                                    </td>
                                </tr>
                            </table>

                        </div>

                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="btn-group">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-default">Voltar</a>
                        <button type="submit" class="btn btn-primary">Editar</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection
