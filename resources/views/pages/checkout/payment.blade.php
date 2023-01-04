@extends('pages.layouts.master')

@section('title')
    <title>Trang thanh toán</title>
@endsection

@section('content')
    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="{{route('home')}}">Home</a></li>
                    <li class="active">Thanh toán giỏ hàng</li>
                </ol>
            </div><!--/breadcrums-->
            <div class="review-payment">
                <h2>Xem lại giỏ hàng</h2>
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
                                <a href=""><img src="{{config('app.base_url').$product->options->image}}" width="100"
                                                alt=""></a>
                            </td>
                            <td class="cart_description">
                                <h4><a href="">{{$product->name}}</a></h4>
                                <p>ID: {{$product->id}}</p>
                            </td>
                            <td class="cart_price">
                                <p>{{number_format($product->price,0, ',','.').' '.'VNĐ'}}</p>
                            </td>
                            <td class="cart_quantity">
                                <div class="cart_quantity_button">
                                    <form action="{{route('cart.update')}}" method="post">
                                        @csrf
                                        <input class="cart_quantity_input" type="text" name="cart_quantity" value="{{$product->qty}}"
                                               autocomplete="off" size="2">
                                        <input type="hidden" value="{{$product->rowId}}" name="rowId_cart" class="form-control">
                                        <input type="submit" value="Cập nhật" name="update_qty" class="btn btn-default btn-sm">
                                    </form>
                                </div>
                            </td>
                            <td class="cart_total">
                                <p class="cart_total_price">
                                    {{number_format($product->price*$product->qty,0, ',','.').' '.'VNĐ'}}
                                </p>
                            </td>
                            <td class="cart_delete">
                                <a class="cart_quantity_delete" href="{{route('cart.deleteItem',['rowId'=>$product->rowId])}}"><i class="fa fa-times"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <form action="{{'order-place'}}" method="post">
                @csrf
                <div class="payment-options">
                    <h4>Chọn hình thức thanh toán</h4>
                    <span>
						<label><input name="payment_option" value="1" type="checkbox"> Trả bằng thẻ ATM</label>
					</span>
                    <span>
						<label><input name="payment_option" value="2" type="checkbox"> Trả tiền mặt</label>
					</span>
                    <input type="submit" value="Đặt hàng" class="btn btn-primary btn-sm">
                </div>
            </form>
        </div>
    </section>
@endsection

