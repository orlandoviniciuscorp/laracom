<ul class="checkbox-list">
    @foreach($producers as $producer)
        <li>
            <div class="radio">
                <label>
                    <input
                            type="checkbox"
                            @if(isset($producersSelectedIds) && in_array($producer->id, $producersSelectedIds))checked="checked" @endif
                            name="producers[]"
                            value="{{ $producer->id }}">
                    {{ $producer->name }}
                </label>
            </div>
        </li>
{{--        @if($category->children->count() >= 1)--}}
{{--            @include('admin.shared.categories', ['categories' => $category->children, 'selectedIds' => $selectedIds])--}}
{{--        @endif--}}
    @endforeach
</ul>