{{-- @extends('layout')
@section('content')
<div class="table-responsive cart_info">
    <table class="table table-condensed">
        <thead>
            <tr class="cart_menu">
                <td class="image">Hình ảnh</td>
                <td class="description">Tên sản phẩm</td>
                <td class="price">Giá sản phẩm</td>
                <td class="quantity">Số lượng</td>
                <td class="total">Thành tiền</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
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
                        <img src="{{ asset('public/uploads/product/' . $cart['product_image']) }}" width="90"
                            alt="{{ $cart['product_name'] }}" />
                    </td>
                    <td class="cart_description">
                        <h4><a href=""></a></h4>
                        <p>{{ $cart['product_name'] }}</p>
                    </td>
                    <td class="cart_price" style="width: 30%">
                        <p>{{ number_format($cart['product_price'], 0, ',', '.') }}đ</p>
                    </td>
                    <td class="cart_quantity">
                        <div class="cart_quantity_button">
                            <form action="" method="POST">

                                <input class="cart_quantity_" type="number" min="1" name="cart_quantity"
                                    value="{{ $cart['product_qty'] }}">

                                <input type="submit" value="Cập nhật" name="update_qty" class="btn btn-default btn-sm">
                            </form>
                        </div>
                    </td>
                    <td class="cart_total">
                        <p class="cart_total_price">
                            {{ number_format($subtotal, 0, ',', '.') }}đ

                        </p>
                    </td>
                    <td class="cart_delete">
                        <a class="cart_quantity_delete" href=""><i class="fa fa-times"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection --}}

@extends('layout')
@section('content')
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Shop</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="{{ URL::to('/trang-chu') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active text-white">Sản phẩm</li>
        </ol>
    </div>
    <!-- Single Page Header End -->


    <!-- Cart Page Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="table-responsive">
                <table class="table">

                    <thead>
                        <tr>
                            <th scope="col">Sản phẩm</th>
                            <th scope="col">Tên</th>
                            <th scope="col">Giá</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Tổng</th>
                            <th scope="col">Handle</th>
                        </tr>
                    </thead>
                    <tbody>

                        @php
                            $total = 0;
                        @endphp

                        @foreach (Session::get('cart') as $key => $cart)
                            <tr>
                                <th scope="row">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('public/uploads/product/' . $cart['product_image']) }}"
                                            class="img-fluid me-5 rounded-circle" style="width: 80px; height: 80px;"
                                            alt="{{ $cart['product_name'] }}">
                                    </div>
                                </th>
                                <td>
                                    <p class="mb-0 mt-4">{{ $cart['product_name'] }} </p>
                                </td>
                                <td>
                                    <p class="mb-0 mt-4">{{ number_format($cart['product_price']) . ' ' . 'VND' }}</p>
                                </td>
                                <td>
                                    <div class="input-group quantity mt-4" style="width: 100px;">
                                        <div class="input-group-btn">

                                            <form action="{{ URL::to('/update-cart-quantity') }}" method="POST">
                                                @csrf
                                                <!-- <button class="btn btn-sm btn-minus rounded-circle bg-light border" >
                                                <i class="fa fa-minus"></i>

                                                </button> -->
                                        </div>
                                        <input type="text" class="form-control form-control-sm text-center border-0"
                                            name="cart_quantity" value="{{ $cart['product_qty'] }}">
                                        <input type="hidden" value="" name="rowId_cart" class="form-control">
                                        <div class="input-group-btn">
                                            <!-- <button class="btn btn-sm btn-plus rounded-circle bg-light border">
                                                    <i class="fa fa-plus"></i>
                                                </button> -->
                                        </div>
                                        <input type="submit" value="Cập nhật" name="update_qty"
                                            class="btn btn-default btn-sm">
                                        </form>
                                    </div>
                                </td>
                                <td>
                                    <p class="mb-0 mt-4">
                                        <?php
                                        $subtotal = $cart['product_price'] * $cart['product_qty'];
                                        $total += $subtotal;
                                        
                                        echo number_format($subtotal) . ' ' . 'VND';
                                        ?>
                                    </p>
                                </td>
                                <td>
                                    <button class="btn btn-md rounded-circle bg-light border mt-4">

                                        <a class="cart_quantity_delete" href="">
                                            <i class="fa fa-times text-danger"></i></a>
                                    </button>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-5">
                <input type="text" class="border-0 border-bottom rounded me-5 py-3 mb-4" placeholder="Coupon Code">
                <button class="btn border-secondary rounded-pill px-4 py-3 text-primary" type="button">áp dụng khuyến
                    mãi</button>
            </div>
            <div class="row g-4 justify-content-end">
                <div class="col-8"></div>
                <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                    <div class="bg-light rounded">
                        <div class="p-4">
                            <h1 class="display-6 mb-4">Hóa đơn</h1>
                            <div class="d-flex justify-content-between mb-4">
                                <h5 class="mb-0 me-4">Tổng:</h5>
                                <p class="mb-0">{{ number_format($total) . ' ' . 'VND' }}</p>

                            </div>
                            <div class="d-flex justify-content-between">
                                <h5 class="mb-0 me-4">Ship</h5>
                                <div class="">
                                    <p class="mb-0"> Free</p>
                                </div>
                            </div>
                            <p class="mb-0 text-end"></p>
                        </div>
                        <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                            <h5 class="mb-0 ps-4 me-4">Thành tiền</h5>
                            <p class="mb-0 pe-4">{{ number_format($total) . ' ' . 'VND' }}</p>
                        </div>




                        <a class="btn btn-default check_out" href="">
                            <button
                                class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4 ms-4"
                                type="button">Thanh toán</button>
                        </a>




                        <!-- <a href="chackout.html">
                                <button class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4 ms-4" type="button">  Checkout</button>
                            </a> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart Page End -->
@endsection
