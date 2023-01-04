@extends('admin.layouts.admin')

@section('title')
    <title>Danh Sách Slider</title>
@endsection

@section('css')
    <link rel="stylesheet" href="{{asset('admins/slider/list/list.css')}}">
@endsection

@section('js')
    <script src="{{asset('vendors/sweetAlert2/sweetalert2@11.js')}}"></script>
    <script src="{{asset('admins/main.js')}}"></script>
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('admin.partials.content-header', ['name'=>'Slider', 'key'=>'List'])
        <!-- /.content-header -->
        @include('admin.partials.alert')
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{route('sliders.create')}}" class="btn btn-success float-right m-2">Add</a>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tên Slider</th>
                                <th scope="col">Mô Tả</th>
                                <th scope="col">Hình Ảnh</th>
                                <th scope="col">Hành Động</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sliders as $slider)
                                <tr>
                                    <th scope="row">{{$slider->id}}</th>
                                    <td>{{$slider->name}}</td>
                                    <td>{!! $slider->description !!}</td>
                                    <td>
                                        <img src="{{$slider->image_path}}" class="slider_image" alt="No Image">
                                    </td>
                                    <td>
                                        <a href="{{route('sliders.edit',['slider'=>$slider->id])}}"
                                           class="btn btn-success btn-sm">Edit
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href=""
                                           data-url="{{route('sliders.destroy', ['slider'=>$slider->id])}}"
                                           class="btn btn-danger btn-sm action_delete">Delete
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12">{{$sliders->links()}}</div>
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
