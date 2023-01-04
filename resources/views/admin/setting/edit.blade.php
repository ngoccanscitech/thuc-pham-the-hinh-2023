@extends('admin.layouts.admin')

@section('title')
    <title>Sửa Setting</title>
@endsection

@section('js')
    <script src="https://cdn.ckeditor.com/4.19.1/standard/ckeditor.js"></script>
    <script src="{{asset('admins/setting/add/add.js')}}"></script>
@endsection

@section('css')
    <link rel="stylesheet" href="{{asset('admins/setting/add/add.css')}}">
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('admin.partials.content-header', ['name'=>'Setting', 'key'=>'Edit'])
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <form action="{{route('settings.update',['setting'=>$setting->id])}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label>Config Key</label>
                                <input type="text" name="config_key" readonly value="{{$setting->config_key}}"
                                       class="form-control @error('config_key') is-invalid @enderror"
                                       placeholder="Nhập key config">
                                @error('config_key')
                                <div class="alert alert-danger">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Config Value</label>
                                @if(request()->type === 'Text')
                                    <input type="text" name="config_value" value="{{$setting->config_value}}"
                                           class="form-control @error('config_value') is-invalid @enderror"
                                           placeholder="Nhập value config">
                                    @error('config_value')
                                    <div class="alert alert-danger">{{$message}}</div>
                                    @enderror
                                @elseif(request()->type === 'Textarea')
                                    <textarea type="text" name="config_value"
                                              id="ck_editor_init"
                                              name="config_value"
                                              class="form-control @error('config_value') is-invalid @enderror"
                                              placeholder="Nhập value config">
                                        {{$setting->config_value}}
                                    </textarea>
                                    @error('config_value')
                                    <div class="alert alert-danger">{{$message}}</div>
                                    @enderror
                                @endif
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
