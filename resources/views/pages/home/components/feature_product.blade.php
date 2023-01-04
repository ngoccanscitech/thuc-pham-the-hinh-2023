<div class="features_items"><!--features_items-->
    <h2 class="title text-center">Features Items</h2>
    @foreach($products as $product)
        <div class="col-sm-4">
            <div class="product-image-wrapper">
                <div class="single-products">
                    <div class="productinfo text-center">
                        <form>
                            @csrf
                            <img src="{{config('app.base_url').$product->feature_image_path}}" alt="" />
                            <h2>{{number_format($product->price)}}</h2>
                            <p>{{$product->name}}</p>
                            <input type="hidden" class="cart_product_name_{{$product->id}}" name="product_name" value="{{$product->name}}">
                            <input type="hidden" class="cart_product_quantity_{{$product->id}}" name="product_quantity" value="{{$product->quantity}}">
                            <input type="hidden" class="cart_product_qty_{{$product->id}}" name="product_qty" value="1">
                            <input type="hidden" class="cart_product_price_{{$product->id}}" name="product_price" value="{{$product->price}}">
                            <input type="hidden" class="cart_product_image_path_{{$product->id}}" name="product_image_path" value="{{$product->feature_image_path}}">
                            <button type="button" data-product_id = {{$product->id}} class="btn_add_product btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng</button>
                        </form>
                    </div>
                </div>
                <div class="choose">
                    <ul class="nav nav-pills nav-justified">
                        <li><a href="#"><i class="fa fa-plus-square"></i>Add to wishlist</a></li>
                        <li><a href="#"><i class="fa fa-plus-square"></i>Add to compare</a></li>
                    </ul>
                </div>
            </div>
        </div>
    @endforeach
</div>
