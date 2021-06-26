@extends('layouts.front.app')
@section('content')
<div class="container  text-center">

    <div class="row text-center justify-content-center">
        <h3>
            Escolha a sua localização:
        </h3>
    </div>

    <div class="row" style="margin-bottom: 100px;margin-top: 100px;">

        <div class="col-6">
            <form class="" method="post" action="{{route('home.type')}}">
                {{ csrf_field() }}
                <input type="hidden" name="shop_type" value="2" />
                <button type="submit" class="site-btn">Rio de Janeiro</button>
            </form>
        </div>


        <div class="col-6">
            <form class="" method="post" action="{{route('home.type')}}">
                {{ csrf_field() }}
                <input type="hidden" name="shop_type" value="1" />
                <button type="submit" class="site-btn">Teresópolis</button>
            </form>
        </div>

    </div>
</div>
@endsection