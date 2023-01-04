@extends('pages.layouts.master')

@section('title')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{$meta_desc}}">
    <meta name="author" content="">
    <meta name="keywords" content="{{$meta_keywords}}"/>
    <meta name="robots" content="INDEX,FOLLOW"/>
    <link  rel="canonical" href="{{$url_canonical}}" />
    <title>{{$meta_title}}</title>
    <link  rel="icon" type="image/x-icon" href="https://www.thol.com.vn/pub/media/favicon/stores/5/favicon.png" />
@endsection

@section('css')
    <link rel="stylesheet" href="{{asset('home/home.css')}}"/>
    <link rel="stylesheet" href="{{asset('vendors/sweetalert/sweetalert.css')}}"/>
@endsection

@section('js')
    <script src="{{asset('vendors/sweetalert/sweetalert.js')}}"></script>
    <script src="{{asset('home/home.js')}}"></script>
    <script>
        $(function(){
            $('.add-to-cart').click(function (){
                var cart_product_id = $(this).data('product_id');
                var _token = $("input[name='_token']").val();
                var cart_product_name = $('.cart_product_name_'+cart_product_id).val();
                var cart_product_quantity = $('.cart_product_quantity_'+cart_product_id).val();
                var cart_product_qty = $('.cart_product_qty_'+cart_product_id).val();
                var cart_product_price = $('.cart_product_price_'+cart_product_id).val();
                var cart_product_image_path = $('.cart_product_image_path_'+cart_product_id).val();
                $.ajax({
                    url: '{{route('cart.add-product-to-cart')}}',
                    method: 'POST',
                    data: {_token:_token,cart_product_id:cart_product_id,cart_product_name:cart_product_name,cart_product_price:cart_product_price,
                        cart_product_image_path:cart_product_image_path, cart_product_quantity:cart_product_quantity, cart_product_qty: cart_product_qty},
                    success: function (data){
                        swal({
                                title: "Đã thêm sản phẩm vào giỏ hàng?",
                                text: "Bạn có thể mua hàng tiếp hoặc tới giỏ hàng để thanh toán!",
                                showCancelButton: true,
                                confirmButtonClass: "btn-success",
                                confirmButtonText: "Đi tới giỏ hàng!",
                                cancelButtonText: "Xem tiếp",
                                closeOnConfirm: false
                            },
                            function(){
                                window.location.href = "{{route('cart.show')}}"
                            });
                    }
                })
            })
        })
    </script>
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
                <!--features_items-->
                @include('pages.home.components.feature_product')
                <!--features_items-->

                <!--/category-tab-->
                @include('pages.home.components.category_tab')

                <!--/recommended_items-->
                @include('pages.home.components.recommend_item')

            </div>
        </div>
    </div>
</section>

@endsection
