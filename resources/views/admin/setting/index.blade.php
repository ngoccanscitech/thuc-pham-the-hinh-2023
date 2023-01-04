@extends('admin.layouts.admin')

@section('title')
    <title>Danh Sách Setting</title>
@endsection

@section('css')
    <link rel="stylesheet" href="{{asset('admins/setting/index/index.css')}}">
@endsection

@section('js')
    <script src="{{asset('vendors/sweetAlert2/sweetalert2@11.js')}}"></script>
    <script src="{{asset('admins/main.js')}}"></script>
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('admin.partials.content-header', ['name'=>'Setting', 'key'=>'List'])
        <!-- /.content-header -->
        @include('admin.partials.alert')
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="btn-group float-right">
                            <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                                Add setting
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- dropdown menu links -->
                                <li><a href="{{route('settings.create').'?type=Text'}}">Text</a></li>
                                <li><a href="{{route('settings.create').'?type=Textarea'}}">Textarea</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col" style="width: 30%">Config Key</th>
                                <th scope="col" style="width: 30%">Config Value</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($settings as $setting)
                                <tr>
                                    <th scope="row">{{$setting->id}}</th>
                                    <td>{{$setting->config_key}}</td>
                                    <td>{{$setting->config_value}}</td>
                                    <td>
                                        <a href="{{route('settings.edit', ['setting'=>$setting->id]).'?type='.$setting->type}}"
                                           class="btn btn-success btn-sm">Edit
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href=""
                                           data-url="{{route('settings.destroy', ['setting'=>$setting->id])}}"
                                           class="btn btn-danger btn-sm action_delete">Delete
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12">{{$settings->links()}}</div>
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
