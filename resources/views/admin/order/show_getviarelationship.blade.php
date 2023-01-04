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
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="name-table">Thông tin khách hàng</h4>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">Tên khách hàng</th>
                                <th scope="col">Số điện thoại</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>{{$order->customer->name}}</td>
                                <td>{{$order->customer->phone}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="name-table">Thông tin vận chuyển</h4>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">Tên người vận chuyển</th>
                                <th scope="col">Địa chỉ</th>
                                <th scope="col">Số điện thoại</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>{{$order->shipping->name}}</td>
                                <td>{{$order->shipping->address}}</td>
                                <td>{{$order->shipping->phone}}</td>
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
                                <th scope="col">Tên sản phẩm</th>
                                <th scope="col">Số lượng kho còn</th>
                                <th scope="col">Giá</th>
                                <th scope="col">Số lượng mua</th>
                                <th scope="col">Tổng tiền</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order->orderDetails as $product)
                                <tr class="color_qty_{{$product->product->id}}">
                                    <td>{{$product->product_name}}</td>
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
                                    Phí ship:
                                    <br/>
                                    Thanh toán:
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
