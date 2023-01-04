@extends('admin.layouts.admin')

@section('title')
    <title>Thêm Vận Chuyển</title>
@endsection

@section('js')
    <script src="{{asset('admins/delivery/create.js')}}"></script>
    <script>
        $(function () {
            $(document).on('blur', '.feeship_edit', function () {
                var feeship_id = $(this).data('feeship_id');
                var feeship_value = $(this).text();
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: '{{route('update-feeship')}}',
                    method: 'POST',
                    data: {feeship_id: feeship_id, feeship_value: feeship_value, _token: _token},
                    success: function (data) {
                        location.reload();
                    }
                });
            })
        })
    </script>
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('admin.partials.content-header', ['name'=>'Delivery', 'key'=>'Add'])
        <!-- /.content-header -->

        @include('admin.partials.alert')
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <form action="{{route('categories.store')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="">Chọn tỉnh thành phố</label>
                                <select class="form-control city choose" data-url="{{route('select-delivery')}}"
                                        name="city" id="city">
                                    <option value="0">---Chọn thành phố---</option>
                                    @foreach($cities as $city)
                                        <option value="{{$city->matp}}">{{$city->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Chọn quận huyện</label>
                                <select class="form-control province choose" data-url="{{route('select-delivery')}}"
                                        name="province" id="province">
                                    <option value="0">---Chọn quận huyện---</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Chọn xã phường</label>
                                <select class="form-control wards" name="wards" id="wards">
                                    <option value="0">---Chọn xã phường---</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Phí vận chuyển</label>
                                <input type="text" name="fee-ship" class="form-control fee-ship">
                            </div>
                            <button type="button" data-url="{{route('store-delivery')}}"
                                    class="btn btn-primary add_delivery">Submit
                            </button>
                        </form>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
        <div id="load_delivery">
            <input type="hidden" value="{{route('show-feeship')}}" class="url_route">
        </div>
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
