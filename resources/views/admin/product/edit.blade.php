@extends('admin.layouts.admin')

@section('title')
    <title>Sửa Sản Phẩm</title>
@endsection

@section('css')
    <link href="{{asset('vendors/select2/select2.min.css')}}" rel="stylesheet"/>
    <link href="{{asset('admins/product/add/add.css')}}" rel="stylesheet"/>
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('admin.partials.content-header', ['name'=>'Product', 'key'=>'Edit'])
        <!-- /.content-header -->

        @include('admin.partials.alert')
        <!-- Main content -->
        <form action="{{route('products.update',['product'=>$product->id])}}" method="post"
              enctype="multipart/form-data">
            @csrf
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            @csrf
                            <div class="form-group">
                                <label>Tên Sản Phẩm</label>
                                <input type="text" name="name" value="{{$product->name}}" class="form-control"
                                       id="exampleInputEmail1" placeholder="Nhập tên sản phẩm">
                            </div>
                            <div class="form-group">
                                <label>Giá sản phẩm</label>
                                <input type="text" value="{{$product->price}}" name="price" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Số lượng</label>
                                <input type="number" min="1" value="{{$product->quantity}}" name="quantity"
                                       class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Ảnh đại diện</label>
                                <input type="file" name="feature_image_path" class="form-control-file">
                                <div class="col-md-4 container_image">
                                    <div class="row">
                                        <img class="feature_image" src="{{$product->feature_image_path}}" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Ảnh chi tiết</label>
                                <input type="file" multiple name="image_path[]" class="form-control-file">
                                <div class="col-md-12 container_image_detail">
                                    <div class="row">
                                        @foreach($product->productImages as $productImageItem)
                                            <div class="col-md-3">
                                                <img class="image_detail_product"
                                                     src="{{$productImageItem->image_path}}" alt="">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Chọn Danh Mục</label>
                                <select class="form-control select2_init" name="category_id">
                                    <option value="0">danh mục</option>
                                    {!!$htmlOption!!}
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Chọn thương hiệu</label>
                                <select name="brand_id" id="" class="form-control">
                                    <option value="">Chọn thương hiệu</option>
                                    @foreach($brands as $brand)
                                        <option {{$product->brand->id == $brand->id ? 'selected' : ''}} value="{{$brand->id}}">{{$brand->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Nhập tags cho sản phẩm</label>
                                <select name="tags[]" class="form-control tags_select_choose" multiple="multiple">
                                    @foreach($product->tags as $tagItem)
                                        <option value="{{$tagItem->name}}" selected>{{$tagItem->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Chọn hiển thị</label>
                                <div class="form-check form-check-inline">
                                    <input type="radio" {{$product->status == 0 ? 'checked' : ''}} name="status"
                                           value="0" class="form-check-input">
                                    <label class="form-check-label">Có</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" {{$product->status == 1 ? 'checked' : ''}} name="status"
                                           value="1" class="form-check-input">
                                    <label class="form-check-label">Không</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nhập nội dung</label>
                                <textarea class="form-control" id="ck_editor_init" name="contents"
                                          rows="3">{{$product->content}}</textarea>
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
