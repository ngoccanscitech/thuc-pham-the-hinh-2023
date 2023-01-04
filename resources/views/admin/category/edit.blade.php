@extends('admin.layouts.admin')

@section('title')
    <title>Sửa Danh Mục</title>
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('admin.partials.content-header', ['name'=>'Category', 'key'=>'Edit'])
        <!-- /.content-header -->
        @include('admin.partials.alert')
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <form action="{{route('categories.update',['category'=>$category->id])}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label>Tên Danh Mục</label>
                                <input type="text" name="name" value="{{$category->name}}" class="form-control"
                                       id="exampleInputEmail1" placeholder="Nhập tên danh mục">
                            </div>
                            <div class="form-group">
                                <label>Từ khóa danh mục</label>
                                <textarea name="meta_keyword" rows="2"
                                          class="form-control">{{$category->meta_keyword}}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Mô tả danh mục</label>
                                <textarea name="meta_description" rows="3"
                                          class="form-control">{{$category->meta_description}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="">Chọn Danh Mục Cha</label>
                                <select class="form-control" name="parent_id">
                                    <option value="0">danh mục cha</option>
                                    {!!$htmlOption!!}
                                </select>
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
