@extends('admin.layouts.admin')

@section('title')
    <title>Danh Sách Đơn Hàng</title>
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('admin.partials.content-header', ['name'=>'Order', 'key'=>'List'])
        <!-- /.content-header -->
        @include('admin.partials.alert')
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col" style="width: 40%">Tên khách hàng</th>
                                <th scope="col">Tổng tiền</th>
                                <th scope="col">Ngày tháng đặt hàng</th>
                                <th scope="col">Tình trạng đơn hàng</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <th scope="row">{{$order->id}}</th>
                                    <td>{{$order->customer->name}}</td>
                                    <td>{{$order->total}}</td>
                                    <td>{{$order->created_at}}</td>
                                    <td>
                                        @if($order->status == 1)
                                            <span>Đơn hàng mới</span>
                                        @elseif($order->status == 2)
                                            <span>Đơn hàng đã xử lý</span>
                                        @else
                                            <span>Hủy đơn hàng</span>
                                        @endif
                                    </td>
                                    <td>
                                        @can('category-edit')
                                            <a href="{{route('orders.show',['order'=>$order->id])}}"
                                               class="btn btn-success btn-sm">View
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        @endcan
                                        @can('category-delete')
                                            <a href=""
                                               onclick="return confirm('Bạn có chắc muốn xóa danh mục này?')"
                                               class="btn btn-danger btn-sm">Delete
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12">{{$orders->links()}}</div>
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
