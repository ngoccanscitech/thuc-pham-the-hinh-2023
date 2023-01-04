@extends('admin.layouts.admin')

@section('title')
    <title>Sửa Slider</title>
@endsection

@section('css')
    <link href="{{asset('vendors/select2/select2.min.css')}}" rel="stylesheet"/>
    <link href="{{asset('admins/slider/add/add.css')}}" rel="stylesheet"/>
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('admin.partials.content-header', ['name'=>'Slider', 'key'=>'Edit'])
        <!-- /.content-header -->

        @include('admin.partials.alert')
        <!-- Main content -->
        <form action="{{route('sliders.update',['slider'=>$slider->id])}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            @csrf
                            <div class="form-group">
                                <label>Tên Slider</label>
                                <input type="text" name="name" value="{{$slider->name}}" class="form-control"
                                       id="exampleInputEmail1" placeholder="Nhập tên slider">
                            </div>
                            <div class="form-group">
                                <label>Hình Ảnh</label>
                                <input type="file" name="slider_image" class="form-control-file">
                                <div class="row container_slider">
                                    <div class="col-md-4">
                                        <img class="slider_image" src="{{$slider->image_path}}" alt="No image">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Mô Tả</label>
                                <textarea class="form-control" name="description" id="ck_editor_init" name="description"
                                          rows="3">{{$slider->description}}</textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </div>
        </form>
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

@section('js')
    <script src="{{asset('vendors/select2/select2.min.js')}}"></script>
    <script src="https://cdn.ckeditor.com/4.19.1/standard/ckeditor.js"></script>
    <script src="{{asset('admins/product/add/add.js')}}"></script>
@endsection
