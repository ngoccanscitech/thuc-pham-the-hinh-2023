@extends('pages.layouts.master')

@section('title')
    <title>Giỏ hàng</title>
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
                $cartProducts = Cart::content()
                ?>
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
                    @foreach($cartProducts as $product)
                        <tr>
                            <td class="cart_product">
                                <a href=""><img src="{{show_cart.blade}}" width="100"
                                                alt=""></a>
                            </td>
                            <td class="cart_description">
                                <h4><a href="">{{$product->name}}</a></h4>
                                <p>ID: {{$product->id}}</p>
                            </td>
                            <td class="cart_price">
                                <p>{{number_format($product->price,0, ',','.').' show_cart.blade.php'.'VNĐ'}}</p>
                            </td>
                            <td class="cart_quantity">
                                <div class="cart_quantity_button">
                                    <form action="{{route('cart.update')}}" method="post">
                                        @csrf
                                        <input class="cart_quantity_input" type="text" name="cart_quantity"
                                               value="{{$product->qty}}"
                                               autocomplete="off" size="2">
                                        <input type="hidden" value="{{$product->rowId}}" name="rowId_cart"
                                               class="form-control">
                                        <input type="submit" value="Cập nhật" name="update_qty"
                                               class="btn btn-default btn-sm">
                                    </form>
                                </div>
                            </td>
                            <td class="cart_total">
                                <p class="cart_total_price">
                                    {{number_format($product->price*$product->qty,0, ',','.').' show_cart.blade.php'.'VNĐ'}}
                                </p>
                            </td>
                            <td class="cart_delete">
                                <a class="cart_quantity_delete"
                                   href="{{route('cart.deleteItem',['rowId'=>$product->rowId])}}"><i
                                            class="fa fa-times"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <section id="do_action">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="total_area">
                        <ul>
                            <li>Tổng tiền <span>{{Cart::priceTotal(0,',','.').' show_cart.blade.php'.'VNĐ'}}</span></li>
                            <li>Thuế <span>{{Cart::tax(0,',','.').' show_cart.blade.php'.'VNĐ'}}</span></li>
                            <li>Phí vận chuyển <span>Free</span></li>
                            <li>Thành tiền <span>{{Cart::total(0,',','.').' show_cart.blade.php'.'VNĐ'}}</span></li>
                        </ul>
                        @if(session()->get('customer_id') != null && session()->get('shipping_id') == null)
                            <a class="btn btn-default check_out" href="{{route('checkout')}}">Thanh Toán</a>
                        @elseif(session()->get('customer_id') != null && session()->get('shipping_id') != null)
                            <a class="btn btn-default check_out" href="{{route('payment')}}">Thanh Toán</a>
                        @else
                            <a class="btn btn-default check_out" href="{{route('login-checkout')}}">Thanh Toán</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
