@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        @include('layouts.errors-and-messages')
        <div class="box">
            <form action="{{ route('admin.fair.store') }}" method="post" class="form">
                <div class="box-body">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="name">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" placeholder="Name" class="form-control" value="{{ old('name') }}">
                    </div>
                    <div class="form-group">
                        <label for="start_at">Início da Feira: <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="date" name="start_at" id="start_at" placeholder="start_at" class="form-control" value="{{ old('start_at') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="end_at">Fim da Feira: <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="date" name="end_at" id="end_at" placeholder="end_at" class="form-control" value="{{ old('end_at') }}">
                        </div>
                    </div>
                    @include('admin.shared.status-select', ['status' => 0])
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="btn-group">
                        <div class="btn-group">
                            <a href="{{ route('admin.employees.index') }}" class="btn btn-default">Back</a>
                            <button type="submit" class="btn btn-primary">Criar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection
