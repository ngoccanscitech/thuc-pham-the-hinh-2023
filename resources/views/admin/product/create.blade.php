@extends('admin.layouts.admin')

@section('title')
    <title>Tạo Sản Phẩm</title>
@endsection

@section('css')
    <link href="{{asset('vendors/select2/select2.min.css')}}" rel="stylesheet"/>
    <link href="{{asset('admins/product/add/add.css')}}" rel="stylesheet"/>
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('admin.partials.content-header', ['name'=>'Product', 'key'=>'Add'])
        <!-- /.content-header -->

        {{--        @include('partials.alert')--}}
        <!-- Main content -->
        <form action="{{route('products.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            @csrf
                            <div class="form-group">
                                <label>Tên Sản Phẩm</label>
                                <input type="text" name="name"
                                       data-validation="length" data-validation-length="min20"
                                       data-validation-error-msg="You can not upload images larger than 512kb"
                                       value="{{old('name')}}" class="form-control @error('name') is-invalid @enderror"
                                       id="exampleInputEmail1" placeholder="Nhập tên sản phẩm">
                                @error('name')
                                <div class="alert alert-danger">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Giá sản phẩm</label>
                                <input type="text" value="{{old('price')}}" name="price"
                                       class="form-control @error('price') is-invalid @enderror">
                                @error('price')
                                <div class="alert alert-danger">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Số lượng</label>
                                <input type="number" min="1" name="quantity" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Ảnh đại diện</label>
                                <input type="file" name="feature_image_path" class="form-control-file">
                            </div>
                            <div class="form-group">
                                <label>Ảnh chi tiết</label>
                                <input type="file" multiple name="image_path[]" class="form-control-file">
                            </div>
                            <div class="form-group">
                                <label for="">Chọn Danh Mục</label>
                                <select class="form-control select2_init" name="category_id">
                                    <option value="0">danh mục</option>
                                    {!!$htmlOption!!}
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Chọn thương hiệu</label>
                                <select class="form-control" name="brand_id">
                                    <option value="0">thương hiệu</option>
                                    @foreach($brands as $brand)
                                        <option value="{{$brand->id}}">{{$brand->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Nhập tags cho sản phẩm</label>
                                <select name="tags[]" class="form-control tags_select_choose" multiple="multiple">
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Chọn hiển thị: </label>
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" name="status" value="0">
                                    <label class="form-check-label">Có</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" name="status" value="1">
                                    <label class="form-check-label">Không</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nhập nội dung</label>
                                <textarea class="form-control @error('contents') is-invalid @enderror"
                                          id="ck_editor_init" name="contents" rows="3">{{old('contents')}}</textarea>
                                @error('contents')
                                <div class="alert alert-danger">
                                    {{$message}}
                                </div>
                                @enderror
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
