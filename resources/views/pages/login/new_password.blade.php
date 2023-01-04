@extends('pages.layouts.master')

@section('title')
    <title>Nhập password mới</title>
@endsection

@section('css')

@endsection

@section('content')
    <section id="form"><!--form-->
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-1">
                    <div class="login-form"><!--login form-->
                        <h2>Vui lòng nhập mật khẩu mới</h2>
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
                        @php
                        $token = $_GET['token'];
                        $email = $_GET['email'];
                        @endphp
                        <form action="{{route('reset-new-password')}}" method="post">
                            @csrf
                            <input type="hidden" name="account_email" value="{{$email}}">
                            <input type="hidden" name="account_token" value="{{$token}}">
                            <input type="password" name="account_password" placeholder="Nhập mật khẩu mới">
                            <button type="submit" class="btn btn-default">Gửi</button>
                        </form>
                    </div><!--/login form-->
                </div>
            </div>
        </div>
    </section>
@endsection
