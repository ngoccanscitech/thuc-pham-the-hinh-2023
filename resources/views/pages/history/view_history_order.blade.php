@extends('pages.layouts.master')

@section('title')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch sửc chi tiết đơn hàng</title>
    <link  rel="icon" type="image/x-icon" href="" />
@endsection

@section('css')
    <link rel="stylesheet" href="{{asset('home/home.css')}}"/>
@endsection

@section('js')
    <script rel="stylesheet" href="{{asset('home/home.js')}}"></script>
@endsection

@section('content')
    <section>
        <div class="container">
            <div class="d-flex justify-content-end mb-4">
                <a class="btn btn-primary" href="#" style="float: right;">Xuất hóa đơn PDF</a>
            </div>
            <div class="row">
                @include('pages.components.sidebar')

                <div class="col-md-9">
                    <h4 class="name-table" style="text-align: center">Chi tiết đơn hàng</h4>
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">Tên khách hàng</th>
                            <th scope="col">Số điện thoại</th>
                            <th scope="col">Email</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{$order->customer->name}}</td>
                            <td>{{$order->customer->phone}}</td>
                            <td>{{$order->customer->email}}</td>
                        </tr>
                        </tbody>
                    </table>
                    <br>
                    <h4 class="name-table">Thông tin vận chuyển hàng</h4>
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">Tên người vận chuyển</th>
                            <th scope="col">Địa chỉ</th>
                            <th scope="col">Số điện thoại</th>
                            <th scope="col">Email</th>
                            <th scope="col">Ghi chú</th>
                            <th scope="col">Hình thức thanh toán</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{$order->shipping->name}}</td>
                            <td>{{$order->shipping->address}}</td>
                            <td>{{$order->shipping->phone}}</td>
                            <td>{{$order->shipping->email}}</td>
                            <td>{{$order->shipping->notes}}</td>
                            <td>
                                @if($order->shipping->method == 1)
                                    <span>Chuyển khoản</span>
                                @else
                                    <span>Tiền mặt</span>
                                @endif
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <br>
                    <h4 class="name-table">Liệt kê thông tin chi tiết đơn hàng</h4>
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">STT</th>
                            <th scope="col">Tên sản phẩm</th>
                            <th scope="col">Mã giảm giá</th>
                            <th scope="col">Giá</th>
                            <th scope="col">Số lượng mua</th>
                            <th scope="col">Tổng tiền</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $i=0;
                            $total =0;
                        @endphp
                        @foreach($order->orderDetails as $product)
                            @php
                                $i++;
                                $subtotal = $product->product_sales_quantity*$product->product_price;
                                $total+=$subtotal;
                            @endphp
                            <tr class="color_qty_{{$product->product->id}}">
                                <td>{{$i}}</td>
                                <td>{{$product->product_name}}</td>
                                <td>
                                    @if($product->coupon != 'no')
                                        {{$product->coupon}}
                                    @else
                                        Không có mã giảm giá
                                    @endif
                                </td>
                                <td>{{number_format($product->product_price,0,',','.')}}</td>
                                <td>
                                    <input type="number" class="order_quantity_{{$product->product_id}}"
                                           {{$order->status == 2 ? 'disabled' : ''}}
                                           value="{{$product->product_sales_quantity}}" name="product_sales_quantity">
                                    <input type="hidden" class="order_qty_storage_{{$product->product_id}}" value="{{$product->product->quantity}}">
                                    <input type="hidden" class="order_product_{{$product->product_id}}" value="{{$product->product_id}}" name="order_product_id">
                                    <input type="hidden" class="order_{{$product->product_id}}" value="{{$product->order_id}}" name="order_id">
                                </td>
                                <td>{{number_format($product->product_sales_quantity*$product->product_price,0,',','.')}}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="2">
                                Tổng: {{number_format($total,0,',','.').' VNĐ'}} <br>
                                Phí ship: {{number_format($orderDetail->feeship,0,',','.').' VNĐ'}}
                                <br/>
                                @php
                                    $total_coupon = 0;
                                    $coupon = 0;
                                    $fee_ship = $orderDetail->feeship;
                                @endphp
                                @if($coupon_condition == 1)
                                    <?php
                                    $coupon = $total*$coupon_number/100;
                                    $total_coupon = $total + $fee_ship - $coupon;
                                    ?>
                                @else
                                    <?php
                                    $coupon = $coupon_number;
                                    $total_coupon = $total + $fee_ship - $coupon;
                                    ?>
                                @endif
                                Mã giảm: {{number_format($coupon, 0,',','.'). ' VNĐ'}}<br>
                                Thanh toán: {{number_format($total_coupon,0,',','.').' VNĐ'}}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
