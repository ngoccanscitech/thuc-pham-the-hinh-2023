<header id="header"><!--header-->
    <div class="header_top"><!--header_top-->
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="contactinfo">
                        <ul class="nav nav-pills">
                            <li><a href="#"><i class="fa fa-phone"></i>{{getConfigValueFromSettingTable('phone_contact')}}</a></li>
                            <li><a href="#"><i class="fa fa-envelope"></i> {{getConfigValueFromSettingTable('email')}}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="social-icons pull-right">
                        <ul class="nav navbar-nav">
                            <li>
                                <a href="{{getConfigValueFromSettingTable('facebook_link')}}">
                                    <i class="fa fa-facebook"></i>
                                </a>
                            </li>
                            <li><a href="{{getConfigValueFromSettingTable('twitter_link')}}"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                            <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
                            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/header_top-->

    <div class="header-middle"><!--header-middle-->
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div class="logo pull-left">
                        <a href="index.html"><img src="/eshopper/images/home/logo.png" alt="" /></a>
                    </div>
                    <div class="btn-group pull-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
                                USA
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="#">Canada</a></li>
                                <li><a href="#">UK</a></li>
                            </ul>
                        </div>

                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
                                DOLLAR
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="#">Canadian Dollar</a></li>
                                <li><a href="#">Pound</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="shop-menu pull-right">
                        <ul class="nav navbar-nav">
                            <li><a href="{{route('login-checkout')}}"><i class="fa fa-user"></i> Tài khoản</a></li>
                            <li><a href="#"><i class="fa fa-star"></i> Yêu thích</a></li>
                            @if(session()->get('customer_id') != null && session()->get('shipping_id') == null)
                            <li><a href="{{route('checkout')}}"><i class="fa fa-crosshairs"></i> Thanh toán</a></li>
                            @elseif(session()->get('customer_id') != null && session()->get('shipping_id') != null)
                                <li><a href="{{route('payment')}}"><i class="fa fa-crosshairs"></i> Thanh toán</a></li>
                            @else
                                <li><a href="{{route('login-checkout')}}"><i class="fa fa-lock"></i> Thanh toán</a></li>
                            @endif
                            <li><a href="{{route('cart.show')}}"><i class="fa fa-shopping-cart"></i> Giỏ hàng</a></li>
                            @if(session()->get('customer_id') != null)
                                <li><a href="{{route('history')}}"><i class="fa fa-bell"></i> Lịch sử đơn hàng</a>
                                </li>
                            @endif
                            @if(session()->get('customer_id') != null)
                                <li><a href="{{route('logout-checkout')}}"><i class="fa fa-lock"></i> Đăng xuất</a>
                                    <img src="{{session()->get('customer_picture')}}" width="15%" alt="No Image">
                                    {{session()->get('customer_name')}}
                                </li>
                            @else
                                <li><a href="{{route('login-checkout')}}"><i class="fa fa-lock"></i> Đăng nhập</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/header-middle-->

    <div class="header-bottom"><!--header-bottom-->
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    @include('pages.components.main-menu')
                </div>
                <div class="col-sm-4">
                    <div class="search_box pull-right">
                        <form action="{{route('tim-kiem')}}" method="post">
                            @csrf
                            <input type="text" name="keyword" placeholder="Tìm kiếm sản phẩm"/>
                            <input type="submit" style="margin-top: 0px;color: black" class="btn btn-primary btn-sm" name="submit" value="Tìm kiếm">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/header-bottom-->
</header><!--/header-->
