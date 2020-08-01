@extends('layouts.front.app')
@section('content')
@include('front.products.product-list', ['products' => $products])
@endsection
