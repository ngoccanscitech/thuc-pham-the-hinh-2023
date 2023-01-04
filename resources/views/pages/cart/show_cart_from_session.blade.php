@extends('pages.layouts.master')

@section('title')
    <title>Giỏ hàng Session</title>
@endsection

@section('css')

@endsection

@section('content')
    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="{{route('home')}}">Trang chủ</a></li>
                    <li class="active">Giỏ hàng của bạn</li>
                </ol>
            </div>
            <div class="table-responsive cart_info">
                <?php
                $cartProducts = session()->get('cart');
//
                ?>
                    @if($message = session()->get('success'))
                <div class="alert alert-success">
                        {{$message}}
                </div>
                    @endif
                    @if($message = session()->get('error'))
                        <div class="alert alert-danger">
                            {{$message}}
                        </div>
                    @endif
                <table class="table table-condensed">
                    <thead>
                    <tr class="cart_menu">
                        <td class="image">Hình ảnh</td>
                        <td class="description">Mô tả</td>
                        <td class="price">Giá</td>
                        <td class="quantity">Số lượng</td>
                        <td class="total">Tổng</td>
                        <td></td>
                    </tr>
                    </thead>
                    <tbody>
                    <form action="{{route('cart.update-cart')}}" method="post">
                        @csrf
                    @if(session()->get('cart') == true)
                        @php
                            $total = 0
                        @endphp
                    @foreach($cartProducts as $key => $product)
                            @php
                                $sub_total = $product['product_price']*$product['product_qty'];
                                $total += $sub_total;
                            @endphp
                        <tr>
                            <td class="cart_product">
                                <a href=""><img src="{{config('app.base_url').$product['product_image_path']}}" width="100"
                                                alt=""></a>
                            </td>
                            <td class="cart_description">
                                <h4><a href="">{{$product['product_name']}}</a></h4>
                                <p>ID: {{$product['product_id']}}</p>
                            </td>
                            <td class="cart_price">
                                <p>{{number_format($product['product_price'],0, ',','.').' '.'VNĐ'}}</p>
                            </td>
                            <td class="cart_quantity">
                                <div class="cart_quantity_button">

                                        <input class="cart_quantity_input" type="number" min="1" name="cart_qty[{{$product['session_id']}}]" value="{{$product['product_qty']}}"
                                               autocomplete="off" size="2">


                                </div>
                            </td>
                            <td class="cart_total">
                                <p class="cart_total_price">
                                    {{number_format($sub_total,0, ',','.').' '.'VNĐ'}}
                                </p>
                            </td>
                            <td class="cart_delete">
                                <a class="cart_quantity_delete" href="{{route('cart.deleteProductSession',['sessionId'=>$product['session_id']])}}"><i class="fa fa-times"></i></a>
                            </td>
                        </tr>

                    @endforeach

                        <tr>
                            <td>
                                <input type="submit" value="Cập nhật giỏ hàng" class="btn btn-default check_out">
                            </td>
                            <td colspan="4" style="text-align: right;">
                                <a class="btn btn-default check_out" href="{{route('delete-all-product')}}">Hủy toàn bộ sản phẩm</a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <li>Tổng tiền <span>{{number_format($total,0,',','.').' '.'VNĐ'}}</span></li>
                                @if($coupons = session()->get('coupon'))

                                @foreach ($coupons as $coupon)

                                        @if ($coupon['coupon_condition'] == 1)
                                            <li>Mã giảm: {{$coupon['coupon_number'].'%'}}</li>
                                        @php
                                        $calculation_coupon = ($total*$coupon['coupon_number'])/100;
                                        $total_apply_coupon = $total - $calculation_coupon;
                                            @endphp
                                            <li>Số tiền giảm: {{number_format($calculation_coupon,0,',','.').' '.'VNĐ'}}</li>
                                            <li>Tiền sau khi giảm: {{number_format($total_apply_coupon,0,',','.').' '.'VNĐ'}} </li>

                                        @else
                                            <li>Mã giảm: {{$coupon['coupon_number'].'VNĐ'}}</li>
                                            @php
                                                $calculation_coupon = $coupon['coupon_number'];
                                                $total_apply_coupon = $total - $calculation_coupon;
                                            @endphp
                                            <li>Số tiền giảm: {{number_format($calculation_coupon,0,',','.').' '.'VNĐ'}}</li>
                                            <li>Tiền sau khi giảm: {{number_format($total_apply_coupon,0,',','.').' '.'VNĐ'}} </li>
                                        @endif

                                    @endforeach
{{--                                    <li>Mã giảm: {{number_format($calculation_coupon,0,',','.').' '.'VNĐ'}}</li>--}}
{{--                                    <li>Tiền sau khi giảm: {{number_format($total_apply_coupon,0,',','.').' '.'VNĐ'}} </li>--}}
                                @endif

{{--                                <li>Thuế <span>{{Cart::tax(0,',','.').' '.'VNĐ'}}</span></li>--}}
{{--                                <li>Phí vận chuyển <span>Free</span></li>--}}
                                <li>Thành tiền <span>{{' '.'VNĐ'}}</span></li>
                            </td>
                            <td>
                                @if(session()->get('customer_id') != null && session()->get('shipping_id') == null)
                                    <a class="btn btn-default check_out" href="{{route('checkout')}}">Thanh Toán</a>
                                @elseif(session()->get('customer_id') != null && session()->get('shipping_id') != null)
                                    <a class="btn btn-default check_out" href="{{route('payment')}}">Thanh Toán</a>
                                @else
                                    <a class="btn btn-default check_out" href="{{route('login-checkout')}}">Thanh Toán</a>
                                @endif
                            </td>

                        </tr>
                    @else
                    <tr>
                        <td colspan="5"><center>Làm ơn nhập thêm sản phẩm vào giỏ hàng</center></td>
                    </tr>
                    @endif
                    </form>
                    <tr>
                        <td colspan="5">
                            @if(session()->get('cart'))
                            <form method="post" action="{{route('coupons.check-coupon')}}">
                                @csrf
                                <input type="text" name="coupon_code" placeholder="Nhập mã giảm giá">
                                <input type="submit" value="Tính mã giảm giá">
                            </form>
                            @endif
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
