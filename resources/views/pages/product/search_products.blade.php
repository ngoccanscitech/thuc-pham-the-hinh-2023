@extends('pages.layouts.master')

@section('title')
    <title>Tìm kiếm sản phẩm</title>
@endsection

@section('css')
@endsection

@section('js')
@endsection

@section('content')
    <!--slider-->
    @include('pages.home.components.slider')
    <!--slider-->


    <section>
        <div class="container">
            <div class="row">
                @include('pages.components.sidebar')
                <div class="col-sm-9 padding-right">
                    <div class="features_items"><!--features_items-->
                        <h2 class="title text-center">Sản phẩm tìm kiếm</h2>
                        @foreach($products as $product)
                            <div class="col-sm-4">
                                <div class="product-image-wrapper">
                                    <div class="single-products">
                                        <div class="productinfo text-center">
                                            <img src="{{config('app.base_url').$product->feature_image_path}}" alt="" />
                                            <h2>{{number_format($product->price)}}</h2>
                                            <p>{{$product->name}}</p>
                                            <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                        </div>
                                        <div class="product-overlay">
                                            <div class="overlay-content">
                                                <h2>{{$product->price}}</h2>
                                                <p>{{$product->name}}</p>
                                                <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                            </div>
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
                    <div>
                        {{$products->links()}}
                    </div>


                </div>
            </div>
        </div>
    </section>

@endsection
