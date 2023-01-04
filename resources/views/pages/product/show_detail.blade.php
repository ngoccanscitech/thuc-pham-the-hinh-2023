@extends('pages.layouts.master')

@section('title')
    <title>Chi tiết sản phẩm</title>
@endsection

@section('css')
    <style>
        .image-product-detail{
            width: 84px;
            height: 84px;
            object-fit: cover;
        }
    </style>
@endsection

@section('content')
<section>
    <div class="container">
        <div class="row">
            @include('pages.components.sidebar')
            <div class="col-sm-9 padding-right">
                <div class="product-details"><!--product-details-->
                    <div class="col-sm-5">
                        <div class="view-product">
                            <img src="{{config('app.base_url').$product->feature_image_path}}" alt="No Image">
                            <h3>ZOOM</h3>
                        </div>
                        <div id="similar-product" class="carousel slide" data-ride="carousel">

                            <!-- Wrapper for slides -->
                            <div class="carousel-inner">
                                @foreach($product->productImages as $key => $imageProduct)
                                @if($key%3==0)
                                        <div class="item {{$key == 0 ? 'active' : ''}}">
                                        @endif
                                    <a href="#"><img class="image-product-detail" src="{{config('app.base_url').$imageProduct->image_path}}" alt="No Image"></a>
                                @if($key%3 == 2)
                                        </div>
                                    @endif
                                @endforeach

                            </div>

                            <!-- Controls -->
                            <a class="left item-control" href="#similar-product" data-slide="prev">
                                <i class="fa fa-angle-left"></i>
                            </a>
                            <a class="right item-control" href="#similar-product" data-slide="next">
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </div>

                    </div>
                    <div class="col-sm-7">
                        <div class="product-information"><!--/product-information-->
                            <img src="images/product-details/new.jpg" class="newarrival" alt="">
                            <h2>{{$product->name}}</h2>
                            <p>Mã ID: {{$product->id}}</p>
                            <img src="images/product-details/rating.png" alt="">
                            <form action="{{route('cart.save')}}" method="post">
                                @csrf
                                 <span>
									<span>{{number_format($product->price)}} VNĐ</span>
									<label>Số lượng:</label>
                                     <input type="number" class="cart_product_qty_{{$product->id}}" name="cart_product_qty" min="1" value="1">
									<input name="cart_product_id" type="hidden" value="{{$product->id}}">
                                     <input type="hidden" class="cart_product_name_{{$product->id}}" name="cart_product_name" value="{{$product->name}}">
                                    <input type="hidden" class="cart_product_quantity_{{$product->id}}" name="cart_product_quantity" value="{{$product->quantity}}">
                                    <input type="hidden" class="cart_product_price_{{$product->id}}" name="cart_product_price" value="{{$product->price}}">
                                    <input type="hidden" class="cart_product_image_path_{{$product->id}}" name="cart_product_image_path" value="{{$product->feature_image_path}}">
									<button type="submit" class="btn btn-fefault cart">
										<i class="fa fa-shopping-cart"></i>
										Thêm vào giỏ hàng
									</button>
                            </span>
                            </form>
                            <p><b>Tình trạng:</b> Còn hàng</p>
                            <p><b>Điều kiện:</b> Mới 100%</p>
                            <p><b>Thương hiệu:</b> {{$product->brand->name}}</p>
                            <p><b>Danh mục:</b> {{$product->category->name}}</p>
                            <a href=""><img src="images/product-details/share.png" class="share img-responsive" alt=""></a>
                        </div><!--/product-information-->
                    </div>
                </div><!--/product-details-->

                <div class="category-tab shop-details-tab"><!--category-tab-->
                    <div class="col-sm-12">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#details" data-toggle="tab">Chi tiết sản phẩm</a></li>
                            <li class=""><a href="#reviews" data-toggle="tab">Reviews (5)</a></li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="details">
                            <div class="col-sm-3">
                                {!! $product->content !!}
                            </div>
                        </div>

                        <div class="tab-pane fade" id="reviews">
                            <div class="col-sm-12">
                                <ul>
                                    <li><a href=""><i class="fa fa-user"></i>EUGEN</a></li>
                                    <li><a href=""><i class="fa fa-clock-o"></i>12:41 PM</a></li>
                                    <li><a href=""><i class="fa fa-calendar-o"></i>31 DEC 2014</a></li>
                                </ul>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                                <p><b>Write Your Review</b></p>

                                <form action="#">
										<span>
											<input type="text" placeholder="Your Name">
											<input type="email" placeholder="Email Address">
										</span>
                                    <textarea name=""></textarea>
                                    <b>Rating: </b> <img src="images/product-details/rating.png" alt="">
                                    <button type="button" class="btn btn-default pull-right">
                                        Submit
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div><!--/category-tab-->

                @include('pages.product.components.danh_sach_goi_y')<!--/recommended_items-->

            </div>
        </div>
    </div>
</section>
@endsection
