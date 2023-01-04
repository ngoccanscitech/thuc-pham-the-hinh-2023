@extends('admin.layouts.admin')

@section('title')
    <title>Thông tin chi tiết Đơn Hàng</title>
@endsection

@section('css')
    <link rel="stylesheet" href="{{asset('admins/order/show.css')}}"/>
@endsection

@section('js')
    <script src="{{asset('admins/order/show.js')}}"></script>
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('admin.partials.content-header', ['name'=>'Order', 'key'=>'Detail'])
        <!-- /.content-header -->
        @include('admin.partials.alert')
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="d-flex justify-content-end mb-4">
                    <a class="btn btn-primary" href="{{route('orders.create-pdf',['order'=>$order->id])}}">Xuất hóa đơn
                        PDF</a>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="name-table">Thông tin đăng nhập</h4>
                        <table class="table table-striped">
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
                        <h4 class="name-table">Thông tin vận chuyển hàng</h4>
                        <table class="table table-striped">
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
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="name-table">Liệt kê thông tin chi tiết đơn hàng</h4>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">STT</th>
                                <th scope="col">Tên sản phẩm</th>
                                <th scope="col">Mã giảm giá</th>
                                <th scope="col">Số lượng kho còn</th>
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
                                    <td>{{$product->product->quantity}}</td>
                                    <td>{{number_format($product->product_price,0,',','.')}}</td>
                                    <td>
                                        <input type="number" class="order_quantity_{{$product->product_id}}"
                                               {{$order->status == 2 ? 'disabled' : ''}}
                                               value="{{$product->product_sales_quantity}}"
                                               name="product_sales_quantity">
                                        <input type="hidden" class="order_qty_storage_{{$product->product_id}}"
                                               value="{{$product->product->quantity}}">
                                        <input type="hidden" class="order_product_{{$product->product_id}}"
                                               value="{{$product->product_id}}" name="order_product_id">
                                        <input type="hidden" class="order_{{$product->product_id}}"
                                               value="{{$product->order_id}}" name="order_id">
                                        @if($order->status !=2)
                                            <button type="submit" class="btn_update_qty"
                                                    data-url="{{route("orders.update-row-qty")}}"
                                                    data-product_id="{{$product->product_id}}" name="update_quantity"
                                                    class="btn btn-default btn-sm">Cập nhật
                                            </button>
                                        @endif
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
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <h4>Chọn hình thức xử lý</h4>
                                    @if($order->status == 1)
                                        <form action="">
                                            @csrf
                                            <select class="form-control confirm_order_detail"
                                                    data-data_url= {{route('orders.update-order-qty')}}>
                                                <option value="">---Chọn hình thức đơn hàng---</option>
                                                <option id="{{$order->id}}" selected value="1">Chưa xử lý</option>
                                                <option id="{{$order->id}}" value="2">Đã xử lý - đã giao hàng</option>
                                                <option id="{{$order->id}}" value="3">Hủy đơn hàng</option>
                                            </select>
                                        </form>
                                    @elseif($order->status == 2)
                                        <form action="">
                                            @csrf
                                            <select class="form-control confirm_order_detail"
                                                    data-data_url= {{route('orders.update-order-qty')}}>
                                                <option value="">---Chọn hình thức đơn hàng---</option>
                                                <option id="{{$order->id}}" value="1">Chưa xử lý</option>
                                                <option id="{{$order->id}}" selected value="2">Đã xử lý - đã giao hàng
                                                </option>
                                                <option id="{{$order->id}}" value="3">Hủy đơn hàng</option>
                                            </select>
                                        </form>
                                    @else
                                        <form action="">
                                            @csrf
                                            <select class="form-control confirm_order_detail"
                                                    data-data_url= {{route('orders.update-order-qty')}}>
                                                <option value="">---Chọn hình thức đơn hàng---</option>
                                                <option id="{{$order->id}}" value="1">Chưa xử lý</option>
                                                <option id="{{$order->id}}" value="2">Đã xử lý - đã giao hàng</option>
                                                <option id="{{$order->id}}" selected value="3">Hủy đơn hàng</option>
                                            </select>
                                        </form>
                                    @endif

                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
        <div class="p-3">
            <h5>Title</h5>
            <p>Sidebar content</p>
        </div>
    </aside>
    <!-- /.control-sidebar -->
@endsection
