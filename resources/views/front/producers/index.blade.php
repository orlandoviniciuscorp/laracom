@extends('layouts.front.app')
@section('content')

    <div class="container">
        <div id="accordion">
    @foreach($producers as $producer)


            <div class="card">
                <div class="card-header" id="heading_{{$producer->id}}">
                    <h5 class="mb-0">
                        <button class="btn btn-link" data-toggle="collapse"
                                data-target="#collapse_{{$producer->id}}" aria-expanded="true"
                                aria-controls="collapse_{{$producer->id}}">
                        {{$producer->name}}
                        </button>
                    </h5>
                </div>

                <div id="collapse_{{$producer->id}}" class="collapse" aria-labelledby="heading_{{$producer->id}}" data-parent="#accordion">
                    <div class="card-body">
                        <div class="container-fluid">
                            <div class="row">
                               <div class="col-3">
                                    <img src="{{asset("storage/$producer->cover")}}" />
                               </div>
                                <div class="col-8">
                                    {!! $producer->description !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    @endforeach
        </div>
    </div>
@endsection
