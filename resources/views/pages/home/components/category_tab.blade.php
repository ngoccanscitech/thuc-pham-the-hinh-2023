<div class="category-tab"><!--category-tab-->
    <div class="col-sm-12">
        <ul class="nav nav-tabs">
            @foreach($categoryParents as $key => $category)
            <li class="{{$key == 0 ? 'active' : '' }}"><a href="#{{strtolower($category->name)}}" data-toggle="tab">{{$category->name}}</a></li>
            @endforeach
        </ul>
    </div>
    <div class="tab-content">
        @foreach($categoryParents as $key => $category)
        <div class="tab-pane fade {{$key == 0 ? 'active in' : ''}}" id="{{strtolower($category->name)}}" >
            @foreach($category->products as $productItem)
            <div class="col-sm-3">
                <div class="product-image-wrapper">
                    <div class="single-products">
                        <div class="productinfo text-center">
                            <img src="{{config('app.base_url').$productItem->feature_image_path}}" alt="" />
                            <h2>{{number_format($productItem->price)}}</h2>
                            <p>{{$productItem->name}}</p>
                            <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                        </div>

                    </div>
                </div>
            </div>
            @endforeach

        </div>
        @endforeach

    </div>
</div>
