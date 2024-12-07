@extends('layout')
@section('content')
    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="{{ asset('/') }}">Trang chủ</a></li>
                    <li class="active">Giỏ hàng của bạn</li>
                </ol>
            </div>
            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
                @elseif (session()->has('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <div class="table-responsive cart_info">
                
                <table class="table table-condensed">
                    <form action="{{ URL::to('/update-cart') }}" method="POST">
                        @csrf
                    <thead>
                        <tr class="cart_menu">
                            <td class="image">Hình ảnh</td>
                            <td class="description">Tên sản phẩm</td>
                            <td class="price">Giá sản phẩm</td>
                            <td class="quantity">Số lượng</td>
                            <td class="total">Thành tiền</td>
                            <td class="">Xóa</td>
                        </tr>
                    </thead>
                    <tbody>
                        @if (Session::has('cart') != null)
                        @php
                            $total = 0;
                        @endphp
                        @foreach (Session::get('cart') as $key => $cart)
                        @php
                            $subtotal = $cart['product_price'] * $cart['product_qty'];
                            $total += $subtotal;
                        @endphp
                            <tr>
                                <td class="cart_product">
                                    <img src="{{ asset('public/uploads/product/'.$cart['product_image']) }}" width="90" alt="{{ $cart['product_name'] }}">
                                </td>
                                <td class="cart_description">
                                    <h4><a href="" class="truncate"></a></h4>
                                    <p>{{ $cart['product_name'] }}</p>
                                </td>
                                <td class="cart_price">
                                    <p>{{number_format($cart['product_price'],0,',','.') }} VND</p>
                                </td>
                                <td class="cart_quantity">
                                    <div class="cart_quantity_button">
                                        @csrf
                                        <input class="cart_quantity" type="number" name="cart_qty[{{ $cart['session_id'] }}]" value="{{ $cart['product_qty'] }}" min="1" autocomplete="off"
                                            size="1" style="width: 70px">
                                        </div>
                                </td>
                                <td class="cart_total">
                                    <p class="cart_total_price">
                                        {{number_format($subtotal,0,',','.') }} VND
                                    </p>
                                </td>
                                <td class="cart_delete">
                                    <a class="cart_quantity_delete" href="{{ URL::to('/del-product/'.$cart['session_id']) }}"><i class="fa fa-trash-o"></i></a>
                                </td>
                            </tr>
                            @endforeach
                            <tr>
                                <td>
                                    <input type="submit" value="Cập nhật giỏ hàng" name="update_qty" class="btn btn-default check_out">
                                </td>
                                <td>
                                    <a class="btn btn-default check_out" href="{{URL::to ('/del-all-product') }}">Xóa tất cả</a>
                                </td>
                                <td>
                                    @if (Session::get('coupon'))
                                    <a href="{{ url('/unset-coupon') }}" class="btn btn-default check_out">Hủy mã giảm giá</a>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="total_area">
                                        <ul>
                                            <li>Tổng tiền: <span>{{number_format($total,0,',','.') . ' VND'}}</span></li>
                                            <li>Mã giảm:
                                                @if (Session::get('coupon'))
                                                    @foreach (Session::get('coupon') as $key => $cou)
                                                        @if ($cou['coupon_condition'] == 1)
                                                            <span>{{ $cou['coupon_number'] }} %</span>
                                                            <p>
                                                                @php
                                                                    $total_coupon = ($total * $cou['coupon_number'])/100;
                                                                    echo '<li>Tổng giảm: <span>' . number_format($total_coupon, 0, ',', '.') . ' VND </span>  </li>';
                                                                @endphp
                                                            </p>
                                                            <p>
                                                                @php
                                                                    $total = $total - $total_coupon;
                                                                    // echo number_format($total,0,',','.') . ' VND';
                                                                @endphp
                                                            </p>
                                                        @else
                                                            <span>{{number_format($cou['coupon_number'],0,',','.') }} VND</span>
                                                            <p>
                                                                @php
                                                                    $total = $total - $cou['coupon_number'];
                                                                    // echo number_format($total,0,',','.') . ' VND';
                                                                @endphp
                                                            </p>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </li>
                                            <li>Thành tiền: <span>{{number_format($total,0,',','.') . ' VND' }}</span></li>
                                            {{-- <li>Thuế<span></span></li>
                                            <li>Phí vận chuyển <span>Free</span></li>
                                            <li>Thành tiền <span></span></li> --}}
                                        </ul>
                                        {{-- <a class="btn btn-default check_out" href="">Thanh toán</a> --}}
                                        
                                    </div>
                                </td>
                            </tr>
                            @else
                            <tr>
                                <td colspan="6"><center><p>Không có sản phẩm nào trong giỏ hàng</p></center></td>
                            </tr>
                            @endif
                    </tbody>
                </form>
                @if (Session::has('cart') != null)
                <tr>
                    <td>
                        <ul>
                            <form action="{{ url('/check-coupon') }}" method="POST">
                                @csrf
                                <input type="text" class="form-control" name="coupon" placeholder="Nhập mã giảm giá">
                                <br>
                                <input type="submit" class="btn btn-default check_coupon" value="Tính mã giảm giá" name="check_coupon">
                            </form>                            
                        </ul>
                    </td>
                </tr>
                @endif
                </table>
            
            
            </div>
        </div>
    </section> <!--/#cart_items-->

    {{-- <section id="do_action">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div class="total_area">
                        <ul>
                            <li>Tổng tiền: <span>{{number_format($total,0,',','.') }}</span></li>
                            <li>Thuế<span></span></li>
                            <li>Phí vận chuyển <span>Free</span></li>
                            <li>Thành tiền <span></span></li>
                        </ul>
                        <a class="btn btn-default check_out" href="">Thanh toán</a>
                        <a class="btn btn-default check_out" href="">Tính mã giảm giá</a>
                    </div>
                </div>
            </div>
        </div>
    </section><!--/#do_action--> --}}
@endsection
