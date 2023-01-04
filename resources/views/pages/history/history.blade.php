@extends('pages.layouts.master')

@section('title')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch sử đơn hàng</title>
    <link  rel="icon" type="image/x-icon" href="" />
@endsection

@section('css')
    <link rel="stylesheet" href="{{asset('home/home.css')}}"/>
@endsection

@section('js')
    <script rel="stylesheet" href="{{asset('home/home.js')}}"></script>
@endsection

@section('content')
    <section>
        <div class="container">
            <div class="row">
                @include('pages.components.sidebar')

                <div class="col-md-9">
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">Thứ tự</th>
                            <th scope="col" style="width: 40%">Mã đơn hàng</th>
                            <th scope="col">Ngày tháng đặt hàng</th>
                            <th scope="col">Tình trạng đơn hàng</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <th scope="row">{{$order->id}}</th>
                                <td>{{$order->order_code}}</td>
                                <td>{{$order->created_at}}</td>
                                <td>
                                    @if($order->status == 1)
                                        <span>Đơn hàng mới</span>
                                    @elseif($order->status == 2)
                                        <span>Đơn hàng đã xử lý</span>
                                    @else
                                        <span>Hủy đơn hàng</span>
                                    @endif
                                </td>
                                <td>
                                        <a href="{{route('view-history-order',['order'=>$order->id])}}" class="btn btn-success btn-sm">Xem đơn hàng
                                        </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$orders->links()}}
                </div>
            </div>
        </div>
    </section>
@endsection
