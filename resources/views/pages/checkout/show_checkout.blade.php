@extends('pages.layouts.master')

@section('title')
    <title>Trang thanh toán</title>
@endsection

@section('js')
    <script>
        $(document).ready(function (){

            $('.send_order').click(function (){
                swal({
                        title: "Xác nhận đơn hàng?",
                        text: "Đơn hàng sẽ không được hoàn trả khi đặt, bạn có muốn đặt không?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Cám ơn, mua hàng!",
                        cancelButtonText: "Đóng, Chưa mua!",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            var shipping_email = $('.shipping_email').val();
                            var shipping_name = $('.shipping_name').val();
                            var shipping_address = $('.shipping_address').val();
                            var shipping_phone = $('.shipping_phone').val();
                            var shipping_notes = $('.shipping_notes').val();
                            var shipping_method = $('.payment_select').val();
                            var order_fee = $('.order_fee').val();
                            var order_coupon = $('.order_coupon').val();

                            var _token = $("input[name='_token']").val();
                            $.ajax({
                                url: '{{route('confirm-order')}}',
                                method: 'POST',
                                data: {_token:_token, shipping_email: shipping_email, shipping_name: shipping_name, shipping_address: shipping_address, shipping_phone:shipping_phone,
                                    shipping_notes:shipping_notes, shipping_method: shipping_method, order_fee:order_fee, order_coupon:order_coupon},
                                success: function (data){
                                    swal("Đơn hàng!", "Đơn hàng của bạn đã được gửi thành công.", "success");

                                }
                            })

                            // window.setTimeout(function (){
                            //     location.reload();
                            // },3000);

                        } else {
                            swal("Đóng", "Đơn hàng chưa được gửi, làm ơn hoàn tất đơn hàng", "error");
                        }
                    });

            });

            $('.calculate_delivery').click(function (){
               var matp = $('.city').val();
               var maqh = $('.province').val();
               var xaid = $('.wards').val();
               var _token = $("input[name='_token']").val();
               $.ajax({
                   url: '{{route('calculate-feeship')}}',
                   method: 'POST',
                   data: {_token:_token, matp: matp, maqh: maqh, xaid: xaid},
                   success: function (data){
                      location.reload();
                   }
               })
            });

            $('.choose').change(function (){
                var action = $(this).attr('id');
                var ma_id = $(this).val();
                var _token = $("input[name='_token']").val();
                var result = '';
                var dataUrl = $(this).data('url');
                if(action == 'city')
                {
                    result = 'province';
                }else{
                    result = 'wards';
                }
                $.ajax({
                    url: dataUrl,
                    method: 'POST',
                    data: {_token:_token, ma_id:ma_id, action:action },
                    success: function (data){
                        $('#'+result).html(data);
                    }
                });
            })
        })
    </script>
@endsection

@section('content')
    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="{{route('home')}}">Home</a></li>
                    <li class="active">Thanh toán giỏ hàng</li>
                </ol>
            </div><!--/breadcrums-->

            <div class="register-req">
                <p>Làm ơn đăng ký hoặc đăng nhập để thanh toán giỏ hàng và xem lại lịch sử mua hàng</p>
            </div><!--/register-req-->

            <div class="shopper-informations">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="shopper-info">
                            <p>Điền thông tin gửi hàng</p>
                            <form>
                                @csrf
                                <input type="email" name="email" class="shipping_email" placeholder="Email">
                                <input type="text" name="name" class="shipping_name" placeholder="Họ và tên">
                                <input type="text" name="address" class="shipping_address" placeholder="Địa chỉ">
                                <input type="text" name="phone"  class="shipping_phone" placeholder="Phone">

                                @if(session()->get('fee'))
                                <input type="hidden" name="order_fee" value="{{session()->get('fee')}}"  class="order_fee">
                                @else
                                    <input type="hidden" name="order_fee" value="25000"  class="order_fee">
                                @endif

                                @if(session()->get('coupon'))
                                    @foreach(session()->get('coupon') as $coupon)
                                <input type="hidden" name="order_coupon" value="{{$coupon['coupon_code']}}"  class="order_coupon">
                                    @endforeach
                                @else
                                    <input type="hidden" name="order_coupon" value="no"  class="order_coupon">
                                @endif

                                <textarea name="message"  class="shipping_notes" placeholder="Ghi chú đơn hàng của bạn" rows="4"></textarea>
                                <div>
                                    <div class="form-group">
                                        <label for="">Chọn hình thức thanh toán</label>
                                        <select class="form-control payment_select" name="payment_select">
                                            <option value="1">Qua chuyển khoản</option>
                                            <option value="2">Qua tiền mặt</option>
                                        </select>
                                    </div>
                                </div>
                                <input type="button" name="send_order" value="Xác nhận đơn hàng" class="btn btn-primary btn-sm send_order">
                            </form>
                            <form action="" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="">Chọn tỉnh thành phố</label>
                                    <select class="form-control city choose" data-url="{{route('select-delivery')}}" name="city" id="city">
                                        <option value="0">---Chọn thành phố---</option>
                                        @foreach($cities as $city)
                                            <option value="{{$city->matp}}">{{$city->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Chọn quận huyện</label>
                                    <select class="form-control province choose" data-url="{{route('select-delivery')}}" name="province" id="province">
                                        <option value="0">---Chọn quận huyện---</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Chọn xã phường</label>
                                    <select class="form-control wards" name="wards" id="wards">
                                        <option value="0">---Chọn xã phường---</option>
                                    </select>
                                </div>
                                <button type="button" class="btn btn-primary calculate_delivery">Tính phí vận chuyển</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive cart_info">
                <?php
                $cartProducts = session()->get('cart');
                //
                ?>
                @if($message = session()->get('success'))
                    <div class="alert alert-success">
                        {{$message}}
                    </div>
                @endif
                @if($message = session()->get('error'))
                    <div class="alert alert-danger">
                        {{$message}}
                    </div>
                @endif
                <table class="table table-condensed">
                    <thead>
                    <tr class="cart_menu">
                        <td class="image">Hình ảnh</td>
                        <td class="description">Mô tả</td>
                        <td class="price">Giá</td>
                        <td class="quantity">Số lượng</td>
                        <td class="total">Tổng</td>
                        <td></td>
                    </tr>
                    </thead>
                    <tbody>
                    <form action="{{route('cart.update-cart')}}" method="post">
                        @csrf
                        @if(session()->get('cart') == true)
                            @php
                                $total = 0
                            @endphp
                            @foreach($cartProducts as $key => $product)
                                @php
                                    $sub_total = $product['product_price']*$product['product_qty'];
                                    $total += $sub_total;
                                @endphp
                                <tr>
                                    <td class="cart_product">
                                        <a href=""><img src="{{config('app.base_url').$product['product_image_path']}}" width="100"
                                                        alt=""></a>
                                    </td>
                                    <td class="cart_description">
                                        <h4><a href="">{{$product['product_name']}}</a></h4>
                                        <p>ID: {{$product['product_id']}}</p>
                                    </td>
                                    <td class="cart_price">
                                        <p>{{number_format($product['product_price'],0, ',','.').' '.'VNĐ'}}</p>
                                    </td>
                                    <td class="cart_quantity">
                                        <div class="cart_quantity_button">

                                            <input class="cart_quantity_input" type="number" min="1" name="cart_qty[{{$product['session_id']}}]" value="{{$product['product_qty']}}"
                                                   autocomplete="off" size="2">


                                        </div>
                                    </td>
                                    <td class="cart_total">
                                        <p class="cart_total_price">
                                            {{number_format($sub_total,0, ',','.').' '.'VNĐ'}}
                                        </p>
                                    </td>
                                    <td class="cart_delete">
                                        <a class="cart_quantity_delete" href="{{route('cart.deleteProductSession',['sessionId'=>$product['session_id']])}}"><i class="fa fa-times"></i></a>
                                    </td>
                                </tr>

                            @endforeach

                            <tr>
                                <td>
                                    <input type="submit" value="Cập nhật giỏ hàng" class="btn btn-default check_out">
                                </td>
                                <td colspan="2" style="text-align: right;">
                                    <a class="btn btn-default check_out" href="{{route('delete-all-product')}}">Hủy toàn bộ sản phẩm</a>
                                </td>
                                <td colspan="2" style="text-align: right;">
                                    <a class="btn btn-default check_out" href="{{route('delete-coupon')}}">Xóa mã khuyến mãi</a>
                                </td>
                            </tr>
                            <tr>
                                <!-- Tính tổng
                                 1. Tồn tại coupon, Không tồn tại feeship
                                 2. Tồn tại feeship, Không tồn tại coupon
                                 3. Tồn tại coupon, tồn tại feeship
                                 4. Không có cả hai thì hiện tổng bình thường
                                 -->
                                <td>
                                    <li>Tổng tiền <span>{{number_format($total,0,',','.').' '.'VNĐ'}}</span></li>
                                    @if(session()->get('coupon') && empty(session()->get('fee')))
                                        @php
                                            $coupons = session()->get('coupon');
                                        @endphp
                                        @foreach ($coupons as $coupon)
                                            @if ($coupon['coupon_condition'] == 1)
                                                @php
                                                    $calculation_coupon = ($total*$coupon['coupon_number'])/100;
                                                    $total_apply_coupon = $total - $calculation_coupon;
                                                @endphp
                                                <li>Mã giảm: {{$coupon['coupon_number'].'%'}} <span>-->Số tiền giảm: {{number_format($calculation_coupon,0,',','.').' '.'VNĐ'}}</span></li>
                                                <li>Tổng còn:
                                                    {{number_format($total_apply_coupon,0,',','.').' '.'VNĐ'}}
                                                </li>
                                            @else
                                                @php
                                                    $calculation_coupon = $coupon['coupon_number'];
                                                    $total_apply_coupon = $total - $calculation_coupon;
                                                @endphp
                                                <li>Mã giảm: {{number_format($coupon['coupon_number'], 0,',','.').' VNĐ'}} <span>-->Số tiền giảm: {{number_format($calculation_coupon,0,',','.').' '.'VNĐ'}}</span></li>
                                                <li>Tổng còn: {{number_format($total_apply_coupon,0,',','.').' '.'VNĐ'}} </li>
                                            @endif

                                        @endforeach

                                    @elseif(empty(session()->get('coupon')) && session()->get('fee'))
                                        @php
                                            $calculation_fee = session()->get('fee');
                                            $total_apply_coupon = $total - $calculation_fee;
                                        @endphp
                                        <li>
                                            <a class="cart_quantity_delete" href="{{route('cart.delete-fee')}}"><i class="fa fa-times"></i></a>
                                            Phí vận chuyển <span>{{number_format($calculation_fee, 0, ',', '.').' VNĐ'}}</span></li>
                                        <li>Tổng còn:
                                            {{number_format($total_apply_coupon,0,',','.').' '.'VNĐ'}}
                                        </li>
                                    @elseif(session()->get('coupon') && session()->get('fee'))
                                        @php
                                           $coupons = session()->get('coupon')
                                        @endphp
                                        @foreach ($coupons as $coupon)
                                            @if ($coupon['coupon_condition'] == 1)
                                                @php
                                                        $calculation_fee = session()->get('fee');
                                                        $calculation_coupon = ($total*$coupon['coupon_number'])/100;
                                                        $total_apply_coupon = $total - $calculation_coupon;
                                                        $total_apply_coupon_fee = $total_apply_coupon + $calculation_fee;
                                                @endphp
                                                <li>Mã giảm: {{$coupon['coupon_number'].'%'}} <span>-->Số tiền giảm: {{number_format($calculation_coupon,0,',','.').' '.'VNĐ'}}</span></li>
                                                <li>
                                                    <a class="cart_quantity_delete" href="{{route('cart.delete-fee')}}"><i class="fa fa-times"></i></a>
                                                    Phí vận chuyển <span>{{number_format($calculation_fee, 0, ',', '.').' VNĐ'}}</span></li>
                                                <li>Tổng còn:
                                                    {{number_format($total_apply_coupon_fee,0,',','.').' '.'VNĐ'}}
                                                </li>
                                            @else
                                                @php
                                                    $calculation_fee = session()->get('fee');
                                                    $calculation_coupon = $coupon['coupon_number'];
                                                    $total_apply_coupon = $total - $calculation_coupon;
                                                    $total_apply_coupon_fee = $total_apply_coupon + $calculation_fee;
                                                @endphp
                                                <li>Mã giảm: {{number_format($coupon['coupon_number'], 0,',','.').' VNĐ'}} <span>-->Số tiền giảm: {{number_format($calculation_coupon,0,',','.').' '.'VNĐ'}}</span></li>
                                                <a class="cart_quantity_delete" href="{{route('cart.delete-fee')}}"><i class="fa fa-times"></i></a>
                                                Phí vận chuyển <span>{{number_format($calculation_fee, 0, ',', '.').' VNĐ'}}</span></li>
                                                <li>Tổng còn: {{number_format($total_apply_coupon_fee,0,',','.').' '.'VNĐ'}} </li>
                                            @endif

                                        @endforeach

                                    @endif


{{--                                    @if($fee = session()->get('fee'))--}}
{{--                                        <li>--}}
{{--                                            <a class="cart_quantity_delete" href="{{route('cart.delete-fee')}}"><i class="fa fa-times"></i></a>--}}
{{--                                            Phí vận chuyển <span>{{number_format($fee, 0, ',', '.').' VNĐ'}}</span></li>--}}
{{--                                    @endif--}}
                                </td>
                                <td>
                                    @if(session()->get('customer_id') != null && session()->get('shipping_id') == null)
                                        <a class="btn btn-default check_out" href="{{route('checkout')}}">Thanh Toán</a>
                                    @elseif(session()->get('customer_id') != null && session()->get('shipping_id') != null)
                                        <a class="btn btn-default check_out" href="{{route('payment')}}">Thanh Toán</a>
                                    @else
                                        <a class="btn btn-default check_out" href="{{route('login-checkout')}}">Thanh Toán</a>
                                    @endif
                                </td>

                            </tr>
                        @else
                            <tr>
                                <td colspan="5"><center>Làm ơn nhập thêm sản phẩm vào giỏ hàng</center></td>
                            </tr>
                        @endif
                    </form>
                    <tr>
                        <td colspan="5">
                            @if(session()->get('cart'))
                                <form method="post" action="{{route('coupons.check-coupon')}}">
                                    @csrf
                                    <input type="text" name="coupon_code" placeholder="Nhập mã giảm giá">
                                    <input type="submit" value="Tính mã giảm giá">
                                </form>
                            @endif
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </section>
@endsection
