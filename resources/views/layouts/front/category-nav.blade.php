<ul class="list-unstyled list-inline nav navbar-nav">
        {{--@isset($cats)--}}
            {{--@foreach($cats as $category)--}}
                {{--<li>--}}
                    {{--@if($category->children()->count() > 0)--}}
                        {{--@include('layouts.front.category-sub', ['subs' => $category->children])--}}
                    {{--@else--}}
                        {{--<a @if(request()->segment(2) == $category->slug) class="active" @endif href="{{route('front.category.slug', $category->slug)}}">{{$category->name}} </a>--}}
                    {{--@endif--}}
                {{--</li>--}}
            {{--@endforeach--}}
        {{--@endif--}}

</ul>