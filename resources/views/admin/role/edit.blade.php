@extends('admin.layouts.admin')

@section('title')
    <title>Edit Role</title>
@endsection

@section('css')
    <link rel="stylesheet" href="{{asset('admins/role/add/add.css')}}"/>
@endsection

@section('js')
    <script src="{{asset('admins/role/add/add.js')}}"></script>
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('admin.partials.content-header', ['name'=>'Role', 'key'=>'Edit'])
        <!-- /.content-header -->

        {{--        @include('partials.alert')--}}
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <form action="{{route('roles.update',['role'=>$role->id])}}" method="post" style="width: 100%;">
                        @csrf
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Tên vai trò</label>
                                <input type="text" name="name" value="{{$role->name}}"
                                       class="form-control @error('name') is-invalid @enderror"
                                       placeholder="Nhập tên vai trò">
                            </div>
                            <div class="form-group">
                                <label>Mô tả vai trò</label>
                                <textarea name="display_name" class="form-control"
                                          rows="4">{{$role->display_name}}</textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="">
                                <input type="checkbox" class="check_all">
                                Check All
                            </label>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                @foreach($parentPermissions as $parentPermissionItem)
                                    <div class="card border-primary mb-3 col-md-12">
                                        <div class="card-header">
                                            <label for="">
                                                <input type="checkbox" class="checked_wrapper" value="">
                                            </label>
                                            Module {{$parentPermissionItem->name}}
                                        </div>
                                        <div class="row">
                                            @foreach($parentPermissionItem->childPermissions as $childPermission)
                                                <div class="card-body text-primary col-md-3">
                                                    <h5 class="card-title">
                                                        <label for="">
                                                            <input type="checkbox"
                                                                   {{$checkedPermissions->contains('id',$childPermission->id) ? 'checked' : ''}}
                                                                   class="checked_childrent" name="permission_id[]"
                                                                   value="{{$childPermission->id}}">
                                                        </label>
                                                        {{$childPermission->name}}
                                                    </h5>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
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

