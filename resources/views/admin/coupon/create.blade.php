@extends('admin.layouts.admin')

@section('title')
    <title>Tạo Mã Giảm Giá</title>
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('admin.partials.content-header', ['name'=>'Coupon', 'key'=>'Add'])
        <!-- /.content-header -->

        @include('admin.partials.alert')
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <form action="{{route('coupons.store')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label>Tên Mã giảm giá</label>
                                <input type="text" name="coupon_name" value="{{old('name')}}" class="form-control"
                                       id="exampleInputEmail1" placeholder="Nhập tên mã">
                            </div>
                            <div class="form-group">
                                <label>Mã giảm giá</label>
                                <input type="text" name="coupon_code" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Số lượng mã</label>
                                <input type="text" name="coupon_time" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Tính năng mã</label>
                                <select class="form-control" name="coupon_condition">
                                    <option value="0">---Chọn---</option>
                                    <option value="1">Giảm theo phần trăm</option>
                                    <option value="2">Giảm theo giá tiền</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Nhập số % hoặc tiền giảm</label>
                                <input type="text" name="coupon_number" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
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
