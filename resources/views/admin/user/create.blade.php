@extends('admin.layouts.admin')

@section('title')
    <title>Cấp quyền cho user</title>
@endsection

@section('css')
    <link href="{{asset('vendors/select2/select2.min.css')}}" rel="stylesheet"/>
    <link href="{{asset('admins/user/add/add.css')}}" rel="stylesheet"/>
@endsection

@section('js')
    <script src="{{asset('vendors/select2/select2.min.js')}}"></script>
    <script src="{{asset('admins/user/add/add.js')}}"></script>
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('admin.partials.content-header', ['name'=>'User', 'key'=>'Add'])
        <!-- /.content-header -->

        {{--        @include('partials.alert')--}}
        <!-- Main content -->
        <form action="{{route('users.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            @csrf
                            <div class="form-group">
                                <label>Tên Người Dùng</label>
                                <input type="text" name="name" value="{{old('name')}}"
                                       class="form-control @error('name') is-invalid @enderror" id="exampleInputEmail1"
                                       placeholder="Nhập tên người dùng">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" value="{{old('email')}}" name="email"
                                       class="form-control @error('price') is-invalid @enderror">
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password"
                                       class="form-control @error('price') is-invalid @enderror">
                            </div>
                            <div class="form-group">
                                <label>Nhập role cho nười dùng</label>
                                <select name="role_id[]" class="form-control tags_select_choose" multiple="multiple">
                                    <option value=""></option>
                                    @foreach($roles as $role)
                                        <option value="{{$role->id}}">{{$role->name}}</option>
                                    @endforeach
                                </select>
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


