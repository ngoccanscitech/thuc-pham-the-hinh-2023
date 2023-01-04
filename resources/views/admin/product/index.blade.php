@extends('admin.layouts.admin')

@section('title')
    <title>Danh Sách Sản Phẩm</title>
@endsection

@section('css')
    <link rel="stylesheet" href="{{asset('admins/product/list/list.css')}}">
@endsection

@section('js')
    <script src="{{asset('vendors/sweetAlert2/sweetalert2@11.js')}}"></script>
    <script src="{{asset('admins/main.js')}}"></script>
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('admin.partials.content-header', ['name'=>'Product', 'key'=>'List'])
        <!-- /.content-header -->
        @include('admin.partials.alert')
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{route('products.create')}}" class="btn btn-success float-right m-2">Add</a>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tên Sản Phẩm</th>
                                <th scope="col">Giá</th>
                                <th scope="col">Số lượng</th>
                                <th scope="col">Hình Ảnh</th>
                                <th scope="col">Danh Mục</th>
                                <th scope="col">Hiển thị</th>
                                <th scope="col">Hành Động</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $productItem)
                                <tr>
                                    <th scope="row">{{$productItem->id}}</th>
                                    <td>{{$productItem->name}}</td>
                                    <td>{{number_format($productItem->price)}}</td>
                                    <td>{{$productItem->quantity}}</td>
                                    <td><img class="product_image_150_100"
                                             src="{{asset($productItem->feature_image_path)}}" alt=""></td>
                                    <td>{{optional($productItem->category)->name}}</td>
                                    <td>
                                        @if($productItem->status == 0)
                                            <a href="{{route('products.inactive', ['product'=>$productItem->id])}}"><span
                                                    class="fas-thumbs-up-styling fas fa-thumbs-up"></span></a>
                                        @else
                                            <a href="{{route('products.active', ['product'=>$productItem->id])}}"><span
                                                    class="fas-thumbs-down-styling fas fa-thumbs-down"></span></a>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{route('products.edit',['product'=>$productItem->id])}}"
                                           class="btn btn-success btn-sm">Edit
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href=""
                                           data-url="{{route('products.delete',['product'=>$productItem->id])}}"
                                           class="btn btn-danger btn-sm action_delete">Delete
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12">{{$products->links()}}</div>
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
