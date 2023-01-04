<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Mail xác nhận đơn hàng</title>
</head>
<body>
<div class="container" style="background:#222 ;border-radius : 12px ;padding : 15px ; ">
    <div class="col-md-12">
        <p style="text-align:center;color:#fff"> Đây là email tự động . Quý khách vui lòng không trả lời email này .</p>
        <div class="row" style="background:cadetblue;padding:15px">
            <div class="col-md-6" style="text-align:center;color:#fff;font-weight:bold;font-size : 30px">
                <h4 style="margin:0"> CÔNG TY BÁN HÀNG LARAVEL </h4>
                <h6 style="margin:0"> DỊCH VỤ BÁN HÀNG - VẬN CHUYỂN - NHẬP KHẨU CHUYÊN NGHIỆP </h6>
            </div>
            <div class="col-md-6 logo" style="color:#fff">
                <p> Chào ban <strong style="color:#000;text-decoration:underline;"> {{$shipping_array['customer_name']}}
                    </strong></p>
            </div>
            <div class="col-md-12">
                <p style="color:#fff;font-size:17px;"> Bạn hoặc một ai đó đã đăng ký dịch vụ tại shop với thông tin như
                    sau : </p>
                <h4 style="color:#000;text-transform:uppercase;"> Thông tin don hàng </h4>
                <p> Mã đơn hàng : <strong style="text-transform:uppercase;color:#fff"> {{$code['order_code']}} </strong></p>
                <p> Mã khuyến mãi áp dụng : <strong style="text-transform:uppercase;color:#fff">{{$code['coupon_code']}}
                    </strong></p>
                <p> Dịch vụ : <strong style="text-transform:uppercase;color:#fff"> Đặt hàng trực tuyến </strong></p>
                <h4 style="color:#000;text-transform:uppercase;"> Thông tin người nhận </h4>
                <p> Email :
                    @if ( $shipping_array['shipping_email'] == '')
                        không có
                    @else
                        <span style="color:#fff"> {{$shipping_array['shipping_email']}} </span>
                    @endif
                </p>
                <p> Họ và tên người gửi :
                    @if ( $shipping_array['shipping_name'] == '')
                        không có
                    @else
                        <span style="color:#fff"> {{$shipping_array['shipping_name']}} </span>
                    @endif
                </p>
                <p> Địa chỉ nhận hàng :
                    @if ( $shipping_array['shipping_address'] == '')
                        không có
                    @else
                        <span style="color:#fff"> {{$shipping_array['shipping_address']}} </span>
                    @endif
                </p>
                <p> Số điện thoại :
                    @if ( $shipping_array['shipping_phone'] == '')
                        không có
                    @else
                        <span style="color:#fff"> {{$shipping_array['shipping_phone']}} </span>
                    @endif
                </p>
                <p> Ghi chú đơn hàng :
                    @if ( $shipping_array['shipping_notes'] == '')
                        không có
                    @else
                        <span style="color:#fff"> {{$shipping_array['shipping_notes']}} </span>
                    @endif
                </p>
                <p> Hình thức thanh toán :<strong style="text-transform:uppercase;color:#fff">
                        @if ( $shipping_array['shipping_method'] == 1)
                            Chuyển khoản ATM
                        @else
                            Tiền mặt
                        @endif
                    </strong>
                </p>
                <p style="color: #fff">Nếu thông tin người nhận hàng không có thì chúng tôi sẽ liên hệ với người đặt hàng để
                    trao đổi thông tin về đơn hàng đã đặt</p>
                <h4 style="color: #000;text-transform: uppercase">Sản phẩm đã đặt</h4>
                <table class="table table-striped" style="border: 1px">
                    <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Số tiền</th>
                        <th>Số lượng đặt</th>
                        <th>Thành tiền</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $total = 0;
                        $subtotal = 0;
                    @endphp
                    @foreach($cart_array as $cart)
                        @php
                            $subtotal = $cart['product_price']*$cart['product_qty'];
                            $total+=$subtotal;
                        @endphp
                        <tr>
                            <td>{{$cart['product_name']}}</td>
                            <td>{{number_format($cart['product_price'], 0, ',', '.').' '. 'VNĐ'}}</td>
                            <td>{{$cart['product_qty']}}</td>
                            <td>{{number_format($subtotal, 0, ',', '.').' '. 'VNĐ'}}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="4" align="right">Tổng tiền thanh toán: {{number_format($total,0,',','.')}} VNĐ</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <p style="color: #fff;text-align: center;font-size: 15px">Xem lại lịch sử đơn hàng đã đặt tại:
                <a  target="_blank" href="{{route('history')}}">Lịch sử đơn hàng của bạn
                </a></p>
            <p style="color: #fff">Mọi chi tiết xin liên hệ website tại: <a target="_blank" href="">Shop</a>, hoặc liên hệ
                qua số hotline: 19005889. Xin cám ơn quý khách đã đặt hàng ở shop chúng tôi.</p>
        </div>
    </div>
</div>
</body>
</html>
