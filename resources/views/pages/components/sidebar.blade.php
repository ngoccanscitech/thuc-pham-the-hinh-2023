<div class="col-sm-3">
    <div class="left-sidebar">
        <h2>Category</h2>
        <div class="panel-group category-products" id="accordian"><!--category-productsr-->
            @foreach($categoryParents as $categoryParent)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            @if($categoryParent->childrenCategories()->count())
                            <a data-toggle="collapse" data-parent="#accordian"
                               href="#sportswear_{{$categoryParent->id}}">
                        <span class="badge pull-right">
                                <i class="fa fa-plus"></i>

                        </span>
                                {{$categoryParent->name}}
                            </a>
                            @else
                                <a
                                   href="{{route('categories.product',['slug'=>$categoryParent->slug,'id'=>$categoryParent])}}">
                                    {{$categoryParent->name}}
                                </a>
                            @endif
                        </h4>
                    </div>

                    <div id="sportswear_{{$categoryParent->id}}" class="panel-collapse collapse">
                        <div class="panel-body">
                            <ul>
                                @foreach($categoryParent->childrenCategories as $categoryChildren)
                                    <li>
                                        <a href="{{route('categories.product',['slug'=>$categoryChildren->slug,'id'=>$categoryChildren])}}">
                                            {{$categoryChildren->name}}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div><!--/category-products-->

    </div>
</div>
