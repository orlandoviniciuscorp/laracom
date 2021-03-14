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
                    <a href="{{ route('admin.fair.detail-export-orders', $fair->id) }}">
                        <button name="report" class="btn btn-success">Exportar para o Excel</button>
                    </a>
                    <br />
                    <div class="box-tools">
                        @include('admin.fairs.partials.table-report-details')
                    </div>
                    <hr>

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