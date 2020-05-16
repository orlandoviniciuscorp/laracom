@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        @include('layouts.errors-and-messages')
        <div class="box">
            <form action="{{ route('admin.percents.store',$product->id) }}" method="post" class="form" enctype="multipart/form-data">
                <input type="hidden" name="product_id" value="{{$product->id}}" />
                <div class="box-body">
                    {{ csrf_field() }}
                    <div class="col-md-8">
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
                                        Caixinha
                                    </th>
                                    <th>
                                        Contas e Repasse de Pagamentos
                                    </th>
                                    <th>
                                        Contato Cliente
                                    </th>
                                    <th>
                                        Conferência Pagamento
                                    </th>
                                    <th>
                                        Vendedor
                                    </th>
                                    <th>
                                        Logistica
                                    </th>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" name="farmer" id="farmer" class="form-control"/>
                                    </td>
                                    <td>

                                        <input type="text" name="plataform" id="plataform" class="form-control"/>

                                    </td>
                                    <td>
                                        <input type="text" name="separation" id="separation" class="form-control"/>
                                    </td>
                                    <td>
                                        <input type="text" name="fund" id="fund" class="form-control"/>

                                    </td>
                                    <td>
                                        <input type="text" name="payments_transfer" id="payments_transfer" class="form-control"/>

                                    </td>
                                    <td>
                                        <input type="text" name="client_contact" id="client_contact" class="form-control"/>
                                    </td>
                                    <td>
                                        <input type="text" name="accounting_close" id="accounting_close" class="form-control"/>
                                    </td>
                                    <td>
                                        <input type="text" name="seeller" id="seeller" class="form-control"/>
                                    </td>
                                    <td>
                                        <input type="text" name="logistic" id="logistic" class="form-control"/>
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
                        <button type="submit" class="btn btn-primary">Criar</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection
