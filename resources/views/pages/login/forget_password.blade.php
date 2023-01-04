@extends('pages.layouts.master')

@section('title')
    <title>Quên mật khẩu</title>
@endsection

@section('css')

@endsection

@section('content')
    <section id="form"><!--form-->
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-1">
                    <div class="login-form"><!--login form-->
                        <h2>Điền email để lấy lại mật khẩu</h2>
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
                        <form action="{{route('recovery-password')}}" method="post">
                            @csrf
                            <input type="text" name="account_email" placeholder="Nhập email">
                            <button type="submit" class="btn btn-default">Gửi</button>
                        </form>
                    </div><!--/login form-->
                </div>
            </div>
        </div>
    </section>
@endsection
