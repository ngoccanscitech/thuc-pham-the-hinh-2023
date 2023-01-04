@extends('admin.layouts.admin')

@section('title')
    <title>Danh Sách Danh Mục</title>
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('admin.partials.content-header', ['name'=>'Category', 'key'=>'List'])
        <!-- /.content-header -->
        @include('admin.partials.alert')
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{route('categories.create')}}" class="btn btn-success float-right m-2">Add</a>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col" style="width: 40%">Name</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $catogory)
                                <tr>
                                    <th scope="row">{{$catogory->id}}</th>
                                    <td>{{$catogory->name}}</td>
                                    <td>
                                        @can('category-edit')
                                            <a href="{{route('categories.edit',['category'=>$catogory->id])}}"
                                               class="btn btn-success btn-sm">Edit
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endcan
                                        @can('category-delete')
                                            <a href="{{route('categories.destroy', ['category'=>$catogory->id])}}"
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
                    <div class="col-md-12">{{$categories->links()}}</div>
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
