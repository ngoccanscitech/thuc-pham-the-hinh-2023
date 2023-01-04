@extends('pages.layouts.master')

@section('title')
    <title>Giỏ hàng</title>
@endsection

@section('css')

@endsection

@section('content')
    <section id="form"><!--form-->
        <div class="container">
            <div class="row">
                <div class="col-sm-4 col-sm-offset-1">
                    <div class="login-form"><!--login form-->
                        @if(session()->get('error'))
                            <div class="alert alert-danger">
                                {{session()->get('error')}}
                            </div>
                        @endif
                        @if(session()->get('success'))
                            <div class="alert alert-success">
                                {{session()->get('success')}}
                            </div>
                        @endif
                        <h2>Đăng nhập tài khoản</h2>
                        <form action="{{route('login-customer')}}" method="post">
                            @csrf
                            <input type="text" name="email" placeholder="Tài khoản">
                            <input type="password" name="password" placeholder="Mật khẩu">
                            <span>
								<input type="checkbox" class="checkbox">
								Ghi nhớ đăng nhập
							</span>
                            <a href="{{route('forget-password')}}">Quên mật khẩu</a>
                            <button type="submit" class="btn btn-default">Đăng nhập</button>
                        </form>
                        <style type="text/css">
                            ul.list-login{
                                margin: 10px;
                                padding: 0px;
                            }
                            ul.list-login li{
                                display: inline;
                                padding: 5px;
                            }
                        </style>
                        <ul class="list-login">
                            <li>
                                <a href="{{route('login-google-customer')}}"><img width="10%" src="{{asset('images/google_icon.png')}}" alt="Đăng nhập bằng tài khoản google"></a>
                            </li>
                            <li>
                                <a href=""><img width="10%" src="{{asset('images/facebook_icon.png')}}" alt="Đăng nhập bằng tài khoản facebook"></a>
                            </li>
                        </ul>
                    </div><!--/login form-->
                </div>
                <div class="col-sm-1">
                    <h2 class="or">Hoặc</h2>
                </div>
                <div class="col-sm-4">
                    <div class="signup-form"><!--sign up form-->
                        <h2>Đăng ký tài khoản!</h2>
                        <form action="{{route('add-customer')}}" method="post">
                            @csrf
                            <input type="text" name="name" placeholder="Họ và tên">
                            <input type="email" name="email" placeholder="Địa chỉ email">
                            <input type="password" name="password" placeholder="Mật khẩu">
                            <input type="text" name="phone" placeholder="Số điện thoại">
                            <button type="submit" class="btn btn-default">Đăng ký</button>
                        </form>
                    </div><!--/sign up form-->
                </div>
            </div>
        </div>
    </section>
@endsection
