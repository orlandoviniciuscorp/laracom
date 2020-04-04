@extends('layouts.front.app')

@section('og')
    <meta property="og:type" content="home"/>
    <meta property="og:title" content="{{ config('app.name') }}"/>
    <meta property="og:description" content="{{ config('app.name') }}"/>
@endsection

@section('content')
    @include('layouts.front.home-slider')

    @foreach($cats as $cat)
        @if($cat->products->isNotEmpty() && $cat->status == 1)
            <section class="new-product t100 home">
                <div class="container">
                    <div class="section-title b50" id="{{$cat->slug}}">

                        <h2>{{ $cat->name }}</h2>

                    </div>
                    @include('front.products.product-list', ['products' => $cat->products->where('status', 1),
                                                             'category_slug'=>$cat->slug])
                    <div id="browse-all-btn"> <a class="btn btn-default browse-all-btn" href="{{ route('front.category.slug', $cat->slug) }}" role="button">Ver todos os ítens do produtor</a></div>
                </div>
            </section>
        @endif
        <hr>
    @endforeach
    @include('mailchimp::mailchimp')
@endsection