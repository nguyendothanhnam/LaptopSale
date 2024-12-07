<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Seo Meta-->
    <meta name="description" content="{{ $meta_desc }}">
    <meta name="author" content="{{ $meta_keywords }}">
    <meta name="keywords" content="INDEX,FOLLOW">
    <meta name="robots" content="INDEX,FOLLow">
    <link rel="canonical" href="{{ $url_canonical }}">
    <link rel="icon" type="image/x-icon" href="">

    {{-- <meta property="og:image" content="{{$image_og}}">
    <meta property="og:site_name" content="thiatv.com">
    <meta property="og:description" content="{{$meta_desc}}">
    <meta property="og:title" content="{{$meta_title}}">
    <meta property="og:url" content="{{$url_canonical}}">
    <meta property="og:type" content="website"> --}}
    <!--Seo Meta-->
    <title>{{ $meta_title }}</title>
    <link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/prettyPhoto.css') }}" rel="styles  heet">
    <link href="{{ asset('frontend/css/prettyPhoto.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/sweetalert.css') }}" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="{{ 'public/fontend/image/ico/favicon.ico' }}">
    <link rel="apple-touch-icon-precomposed" sizes="144x144"
        href="frontend/image/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114"
        href="frontend/image/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72"
        href="frontend/image/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="frontend/image/ico/apple-touch-icon-57-precomposed.png">
</head><!--/head-->

<body>

    <header id="header"><!--header--><div class="header-middle"><!--header-middle-->
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="companyinfo">
                        <h2><span>LAP</span>WIBU</h2>
                    </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="shop-menu pull-right">
                            <ul class="nav navbar-nav">
                                <li><a href="#"><i class="fa fa-star"></i> Yêu thích</a></li>
                                <?php 
                                    $customer_id = Session::get('customer_id');
                                    $shipping_id = Session::get('shipping_id');
                                    if ($customer_id != NULL && $shipping_id == NULL) {
                                    ?>
                                <li>
                                    <a href="{{ URL::to('/checkout') }}"><i class="fa fa-crosshairs"></i> Thanh
                                        toán</a>
                                </li>
                                <?php
                                    } elseif($customer_id != NULL && $shipping_id != NULL) {
                                    ?>
                                <li>
                                    <a href="{{ URL::to('/payment') }}"><i class="fa fa-crosshairs"></i> Thanh
                                        toán</a>
                                </li>
                                <?php    
                                    } else {
                                    ?>
                                <li>
                                    <a href="{{ URL::to('/login-checkout') }}"><i class="fa fa-crosshairs"></i> Thanh
                                        toán</a>
                                </li>
                                <?php
                                    }
                                ?>

                                <li><a href="{{ URL::to('/gio-hang') }}"><i class="fa fa-shopping-cart"></i>Giỏ
                                        hàng</a></li>

                                <?php 
                                    $customer_id = Session::get('customer_id');
                                    if ($customer_id != NULL) {
                                    ?>
                                <li>
                                    <a href="{{ URL::to('/logout-checkout') }}"><i class="fa fa-unlock"></i> Đăng
                                        xuất</a>
                                </li>
                                <?php    
                                    } else {
                                    ?>
                                <li>
                                    <a href="{{ URL::to('/login-checkout') }}"><i class="fa fa-lock"></i> Đăng
                                        nhập</a>
                                </li>
                                <?php
                                    }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/header-middle-->

        <div class="header-bottom"><!--header-bottom-->
            <div class="container">
                <div class="row">
                    <div class="col-sm-7">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse"
                                data-target=".navbar-collapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        <div class="mainmenu pull-left">
                            <ul class="nav navbar-nav collapse navbar-collapse">
                                <li><a href="{{ URL::to('/trang-chu') }}" class="active">Trang chủ</a></li>
                                <li class="dropdown"><a href="#">Tin tức<i class="fa fa-angle-down"></i></a>

                                </li>
                                <li><a href="contact-us.html">Liên hệ</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <form action="{{ URL::to('/tim-kiem') }}" method="POST">
                            @csrf
                            <div class="search_box pull-right">
                                <input type="text" placeholder="Search" />
                                <input type="submit" name="search_items" class="btn btn-success btn-sm"
                                    value="Tìm kiếm">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div><!--/header-bottom-->
    </header><!--/header-->

    <section id="slider"><!--slider-->
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div id="slider-carousel" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
                            <li data-target="#slider-carousel" data-slide-to="1"></li>
                            <li data-target="#slider-carousel" data-slide-to="2"></li>
                        </ol>

                        <div class="carousel-inner">
                            <div class="item active">
                                <div class="col-sm-6">
                                    <h1><span>E</span>-SHOPPER</h1>
                                    <h2>Free E-Commerce Template</h2>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                        incididunt ut labore et dolore magna aliqua. </p>
                                    <button type="button" class="btn btn-default get">Get it now</button>
                                </div>
                                <div class="col-sm-6">
                                    <img src="frontend/image/girl1.jpg" class="girl img-responsive" alt="" />
                                    <img src="frontend/image/pricing.png" class="pricing" alt="" />
                                </div>
                            </div>
                            <div class="item">
                                <div class="col-sm-6">
                                    <h1><span>E</span>-SHOPPER</h1>
                                    <h2>100% Responsive Design</h2>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                        incididunt ut labore et dolore magna aliqua. </p>
                                    <button type="button" class="btn btn-default get">Get it now</button>
                                </div>
                                <div class="col-sm-6">
                                    <img src="frontend/image/girl2.jpg" class="girl img-responsive" alt="" />
                                    <img src="frontend/image/pricing.png" class="pricing" alt="" />
                                </div>
                            </div>

                            <div class="item">
                                <div class="col-sm-6">
                                    <h1><span>E</span>-SHOPPER</h1>
                                    <h2>Free Ecommerce Template</h2>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                        incididunt ut labore et dolore magna aliqua. </p>
                                    <button type="button" class="btn btn-default get">Get it now</button>
                                </div>
                                <div class="col-sm-6">
                                    <img src="frontend/image/girl3.jpg" class="girl img-responsive" alt="" />
                                    <img src="frontend/image/pricing.png" class="pricing" alt="" />
                                </div>
                            </div>

                        </div>

                        <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
                            <i class="fa fa-angle-left"></i>
                        </a>
                        <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </section><!--/slider-->

    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div class="left-sidebar">
                        <h2>Danh mục sản phẩm</h2>
                        <div class="panel-group category-products" id="accordian"><!--category-productsr-->
                            @foreach ($category as $key => $cate)
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a
                                                href="{{ URL::to('/danh-muc-san-pham/' . $cate->category_id) }}">{{ $cate->category_name }}</a>
                                        </h4>
                                    </div>
                                </div>
                            @endforeach
                        </div><!--/category-products-->

                        <div class="brands_products"><!--brands_products-->
                            <h2>Thương hiệu sản phẩm</h2>
                            <div class="brands-name">
                                <ul class="nav nav-pills nav-stacked">
                                    @foreach ($brand as $key => $brand)
                                        <li>
                                            <a href="{{ URL::to('/thuong-hieu-san-pham/' . $brand->brand_id) }}">
                                                <span class="pull-right">(1)</span>{{ $brand->brand_name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div><!--/brands_products-->

                    </div>
                </div>

                <div class="col-sm-9 padding-right">
                    @yield('content')
                </div>
            </div>
        </div>
    </section>

    <footer id="footer"><!--Footer-->
        <div class="footer-widget">
            <div class="container">
                <div class="row">
                    <div class="companyinfo">
                        <h2><span>LAP</span>WIBU</h2>
                    </div>
                    <div class="col-sm-3">
                        <div class="single-widget">
                            <h2>Service</h2>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="#">Online Help</a></li>
                                <li><a href="#">Contact Us</a></li>
                                <li><a href="#">Order Status</a></li>
                                <li><a href="#">Change Location</a></li>
                                <li><a href="#">FAQ’s</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="single-widget">
                            <h2>Quock Shop</h2>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="#">T-Shirt</a></li>
                                <li><a href="#">Mens</a></li>
                                <li><a href="#">Womens</a></li>
                                <li><a href="#">Gift Cards</a></li>
                                <li><a href="#">Shoes</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="single-widget">
                            <h2>Policies</h2>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="#">Terms of Use</a></li>
                                <li><a href="#">Privecy Policy</a></li>
                                <li><a href="#">Refund Policy</a></li>
                                <li><a href="#">Billing System</a></li>
                                <li><a href="#">Ticket System</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="single-widget">
                            <h2>About Shopper</h2>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="#">Company Information</a></li>
                                <li><a href="#">Careers</a></li>
                                <li><a href="#">Store Location</a></li>
                                <li><a href="#">Affillate Program</a></li>
                                <li><a href="#">Copyright</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <p class="pull-left">Copyright © 2024 LAPWIBU Inc. All rights reserved.</p>
                </div>
            </div>
        </div>

    </footer><!--/Footer-->

    {{-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> --}}
    <script src="{{ asset('frontend/js/sweetalert.min.js') }}"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert/dist/sweetalert.min.js"></script> --}}

    <script src="{{ asset('frontend/js/jquery.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.scrollUp.min.js') }}"></script>
    <script src="{{ asset('frontend/js/price-range.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.prettyPhoto.js') }}"></script>
    <script src="{{ asset('frontend/js/main.js') }}"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}

    <script type="text/javascript">
        $(document).ready(function() {
            $('.add-to-cart').click(function(){
                var id = $(this).data('id_product');
                var cart_product_id = $('.cart_product_id_' + id).val();
                var cart_product_name = $('.cart_product_name_' + id).val();
                var cart_product_image = $('.cart_product_image_' + id).val();
                var cart_product_price = $('.cart_product_price_' + id).val();
                var cart_product_qty = $('.cart_product_qty_' + id).val();
                var _token = $('input[name="_token"]').val();
                
                $.ajax({
                    url: '{{ URL::to('/add-cart-ajax') }}',
                    method: 'POST',
                    data: {
                        cart_product_id: cart_product_id,
                        cart_product_name: cart_product_name,
                        cart_product_image: cart_product_image,
                        cart_product_price: cart_product_price,
                        cart_product_qty: cart_product_qty,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        swal({
                            title: "Đã thêm sản phẩm vào giỏ hàng",
                            text: "Bạn có thể mua tiếp hoặc tới giỏ hàng để thanh toán",
                            showCancelButton: true,
                            cancelButtonText: "Xem tiếp",
                            confirmButtonClass: "btn-success",
                            confirmButtonText: "Đi tới giỏ hàng",
                            closeOnConfirm: false
                        },
                        function(){
                            window.location.href = "{{ URL::to('/gio-hang') }}";
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>
