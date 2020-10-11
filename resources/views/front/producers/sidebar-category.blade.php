{{--<ul class="nav sidebar-menu">--}}
{{--    @foreach($producers as $producer)--}}
{{--        @if($producer->children()->count() > 0)--}}
{{--            <li>@include('layouts.front.category-sidebar-sub', ['subs' => $producer->children])</li>--}}
{{--        @else--}}
{{--            <li @if(request()->segment(2) == $producer->slug) class="active" @endif><a href="{{ route('front.category.slug', $producer->slug) }}">{{ $producer->name }}</a></li>--}}
{{--        @endif--}}
{{--    @endforeach--}}
{{--</ul>--}}