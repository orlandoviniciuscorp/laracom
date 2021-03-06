@extends('layouts.front.app')

@section('content')
    <br />


    <!-- Main content -->
    <section class="container content">
        <div class="row">
            <div class="box-body">
                @include('layouts.errors-and-messages')
            </div>
            <div class="col-md-12">
                <h1> <i class="fa fa-home"></i> Minha Conta</h1>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div role="tabpanel" class="tab-pane @if(request()->input('tab') == 'address')active @endif" id="address">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('customer.address.create', auth()->user()->id) }}" class="btn btn-primary">Cadastrar Endereço</a>
                        </div>
                    </div>
                    @if(!$addresses->isEmpty())
                        <table class="table">
                            <thead>
                            <th>Apelido</th>
                            <th>Endereço</th>
                            <th>Complemento</th>
                            <th>Cidade</th>
                            @if(isset($address->province))
                                <th>Province</th>
                            @endif
                            <th>Estado</th>
                            <th>País</th>
                            <th>CEP</th>
                            <th>Telefone</th>
                            <th>Actions</th>
                            </thead>
                            <tbody>
                            @foreach($addresses as $address)
                                <tr>
                                    <td>{{$address->alias}}</td>
                                    <td>{{$address->address_1}}</td>
                                    <td>{{$address->address_2}}</td>
                                    <td>{{$address->city}}</td>
                                    @if(isset($address->province))
                                        <td>{{$address->province->name}}</td>
                                    @endif
                                    <td>{{$address->state_code}}</td>
                                    <td>{{$address->country->name}}</td>
                                    <td>{{$address->zip}}</td>
                                    <td>{{$address->phone}}</td>
                                    <td>
                                        <form method="post" action="{{ route('customer.address.destroy', [auth()->user()->id, $address->id]) }}" class="form-horizontal">
                                            <div class="btn-group">
                                                <input type="hidden" name="_method" value="delete">
                                                {{ csrf_field() }}
                                                <a href="{{ route('customer.address.edit', [auth()->user()->id, $address->id]) }}" class="btn btn-primary"> <i class="fa fa-pencil"></i> Edit</a>
                                                <button onclick="return confirm('Tem Certeza?')" type="submit" class="btn btn-danger"> <i class="fa fa-trash"></i> Delete</button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <br /> <p class="alert alert-warning">Nenhum Endereço cadastrado</p>
                    @endif
                </div>

            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
