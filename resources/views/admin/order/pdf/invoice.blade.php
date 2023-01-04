<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
    <style>
        body {
            font-family: DejaVu Sans;
        }

        .table-styling {
            border: 1px solid #000;
        }

        .table-styling tbody tr td {
            border: 1px solid #000;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <h1>
                    <center>Công ty TMĐT Thiên Ân</center>
                </h1>
                <h4>
                    <center>Độc lập - Tự do - Hạnh phúc</center>
                </h4>
                <div class="col-md-12">
                    <h4 class="name-table">Người đặt hàng</h4>
                    <table class="table-styling">
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
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <h4 class="name-table">Ship hàng tới</h4>
                    <table class="table-styling">
                        <thead>
                        <tr>
                            <th scope="col">Tên người nhận</th>
                            <th scope="col">Địa chỉ</th>
                            <th scope="col">Số điện thoại</th>
                            <th scope="col">Email</th>
                            <th scope="col">Ghi chú</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{$order->shipping->name}}</td>
                            <td>{{$order->shipping->address}}</td>
                            <td>{{$order->shipping->phone}}</td>
                            <td>{{$order->shipping->email}}</td>
                            <td>{{$order->shipping->notes}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <h4 class="name-table">Đơn hàng đặt</h4>
                    <table class="table-styling">
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
                                        Không có mã
                                    @endif
                                </td>
                                <td>{{number_format($product->product_price,0,',','.')}}</td>
                                <td>
                                    {{$product->product_sales_quantity}}
                                </td>
                                <td>{{number_format($product->product_sales_quantity*$product->product_price,0,',','.')}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12" style="margin-top: 15px;">
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
                        $coupon = $total * $coupon_number / 100;
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
                </div>
                <div class="col-md-12" style="margin-top: 15px;">
                    <h4>Ký tên</h4>
                    <table>
                        <thead>
                        <tr>
                            <th width="200px">Người lập phiếu</th>
                            <th width="800px">Người nhận</th>

                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </div>

</div>
<!-- ./wrapper -->


</body>
</html>


