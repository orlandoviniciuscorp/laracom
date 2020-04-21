<ul class="nav sidebar-menu">
    @isset($cats)
        @foreach($cats as $category)
            @if($category->children()->count() > 0)
                <li>@include('layouts.front.category-sidebar-sub', ['subs' => $category->children])</li>
            @else
                <li @if(request()->segment(2) == $category->slug) class="active" @endif><a href="{{ route('front.category.slug', $category->slug) }}">{{ $category->name }}</a></li>
            @endif
        @endforeach
    @endif
</ul>