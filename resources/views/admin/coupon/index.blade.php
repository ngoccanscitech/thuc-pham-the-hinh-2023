@extends('admin.layouts.admin')

@section('title')
    <title>Danh Sách Mã Giảm Giá</title>
@endsection

@section('js')
    <script src="{{asset('vendors/sweetAlert2/sweetalert2@11.js')}}"></script>
    <script src="{{asset('admins/main.js')}}"></script>
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('admin.partials.content-header', ['name'=>'Coupon', 'key'=>'List'])
        <!-- /.content-header -->
        @include('admin.partials.alert')
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{route('coupons.create')}}" class="btn btn-success float-right m-2">Thêm mới</a>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">Tên Mã</th>
                                <th scope="col">Mã code</th>
                                <th scope="col">Số lượng</th>
                                <th scope="col">Điện kiện giảm giá</th>
                                <th scope="col">Số giá</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($coupons as $key => $coupon)
                                <tr>
                                    <td>{{$coupon->coupon_name}}</td>
                                    <td>{{$coupon->coupon_code}}</td>
                                    <td>{{$coupon->coupon_time}}</td>
                                    <td>
                                        @if($coupon->coupon_condition == 1)
                                            Giảm theo phần trăm
                                        @else
                                            Giảm theo giá tiền
                                        @endif
                                    </td>
                                    <td>
                                        @if($coupon->coupon_condition == 1)
                                            {{$coupon->coupon_number.'%'}}
                                        @else
                                            {{$coupon->coupon_number.' VNĐ'}}
                                        @endif
                                    </td>
                                    <td>
                                        @can('category-delete')
                                            <a href=""
                                               data-url="{{route('coupons.destroy',['coupon'=>$coupon->id])}}"
                                               class="btn btn-danger btn-sm action_delete">Xóa
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12">{{$coupons->links()}}</div>
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
