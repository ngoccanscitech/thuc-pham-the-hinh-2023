@if($categoryMenuItem->childrenCategories->count())
    <ul role="menu" class="sub-menu">
        @foreach($categoryMenuItem->childrenCategories as $childrenCategoryMenu)
            <li>
                <a href="shop.html">{{$childrenCategoryMenu->name}}</a>
                @if($childrenCategoryMenu->childrenCategories->count())
                    @include('pages.components.child-menu',['categoryMenuItem' => $childrenCategoryMenu] )
                @endif
            </li>
        @endforeach
    </ul>
@endif
