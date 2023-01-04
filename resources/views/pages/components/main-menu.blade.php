<div class="mainmenu pull-left">
    <ul class="nav navbar-nav collapse navbar-collapse">
        <li><a href="{{route('home')}}" class="active">Home</a></li>

        @foreach($categoryMenuParents as $categoryMenuItem)
        <li class="dropdown"><a href="#">{{$categoryMenuItem->name}}
                <i class="fa fa-angle-down"></i></a>

                @include('pages.components.child-menu',['categoryMenuItem' => $categoryMenuItem])

        </li>
        @endforeach


        <li><a href="404.html">404</a></li>
        <li><a href="contact-us.html">Contact</a></li>
    </ul>
</div>
