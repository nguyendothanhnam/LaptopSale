@extends('layout')
@section('content')
    <div class="features_items"><!--features_items-->

        @foreach ($brand_name as $key => $name)
            <h2 class="title text-center">{{ $name->brand_name }}</h2>
        @endforeach
        @foreach ($brand_by_id as $key => $product)
            <a href="{{ URL::to('/chi-tiet-san-pham/' . $product->product_id) }}">
                <div class="col-sm-4">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                {{-- <img src="{{ asset('public/uploads/product/' . $product->product_image) }}" height="200px"
                                    alt="" />
                                <h2>{{ number_format((float) $product->product_price) . ' ' . 'VND' }}</h2>
                                <p>{{ $product->product_name }}</p>
                                <a href="#" class="btn btn-default add-to-cart">
                                    <i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</a> --}}
                                    <form>
                                        @csrf
                                        <input type="hidden" class="cart_product_id_{{ $product ->product_id }}" value="{{ $product -> product_id }}">
                                        <input type="hidden" class="cart_product_name_{{ $product ->product_id }}" value="{{ $product -> product_name }}">
                                        <input type="hidden" class="cart_product_image_{{ $product ->product_id }}" value="{{ $product -> product_image }}">
                                        <input type="hidden" class="cart_product_price_{{ $product ->product_id }}" value="{{ $product -> product_price }}">
                                        <input type="hidden" class="cart_product_qty_{{ $product ->product_id }}" value="1">
                                        
                                        <a href="{{ URL::to('/chi-tiet-san-pham/' . $product->product_id) }}">
                                        <img src="{{ asset('public/uploads/product/' . $product->product_image) }}" height="200px" alt="" />
                                        <h2>{{ number_format((float) $product->product_price) . ' ' . 'VND' }}</h2>
                                        <p>{{ $product->product_name }}</p>
                                        </a>
                                        <button type="button" class=" btn btn-default add-to-cart" data-id_product="{{ $product ->product_id }}"
                                         name="add-to-cart" >Thêm giỏ hàng</button>
                                    </form>
                            </div>

                        </div>
                        <div class="choose">
                            <ul class="nav nav-pills nav-justified">
                                <li><a href="#"><i class="fa fa-plus-square"></i>Yêu thích</a></li>
                                <li><a href="#"><i class="fa fa-plus-square"></i>So sánh</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </a>
        @endforeach
    </div><!--features_items-->
@endsection
