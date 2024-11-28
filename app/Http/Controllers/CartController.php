<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function save_cart(Request $request ){

        $productId = $request->productid_hidden;
        $quantity = $request->qty;
        $product_info = DB::table('tbl_product')->where('product_id', $productId)->first( );

        // Cart::add('293ad', 'Product 1', 1, 9.99);
        // Cart::destroy();

        $data['id'] = $product_info->product_id;
        $data['qty'] = $quantity;
        $data['name'] = $product_info->product_name;
        $data['price'] = $product_info->product_price;
        $data['weight'] = 1;
        $data['options']['image'] = $product_info->product_image;

        Cart::add($data);
        Cart::setGlobalTax(10);

        return Redirect::to('/show-cart');
        
    }

    public function show_cart(Request $request){
        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id', 'desc')->get();

        //SEO
        $meta_desc = "Giỏ hàng của bạn";
        $meta_keywords = "Giỏ hàng";
        $meta_title = "Giỏ hàng của bạn";
        $url_canonical = $request->url();

        return view('pages.cart.show_cart')
        ->with('category',$cate_product)
        ->with('brand',$brand_product)
        ->with(compact('meta_desc', 'meta_keywords', 'meta_title', 'url_canonical'));
    }

    public function delete_to_cart($rowId){
        Cart::remove($rowId);
        return Redirect::to('/show-cart');
    }
    public function update_cart_quantity(Request $request){
        $rowId = $request->rowId_cart;
        $qty = $request->cart_quantity;

        Cart::update($rowId, $qty);
        return Redirect::to('/show-cart');
    }

    public function add_cart_ajax(Request $request)
{
    $data = $request->all(); // Lấy tất cả dữ liệu từ request
    $session_id = substr(md5(microtime()), rand(0, 26), 5); // Tạo session ID duy nhất
    $cart = Session::get('cart', []); // Lấy giỏ hàng hiện tại hoặc khởi tạo mảng rỗng

    $is_available = false;

    // Duyệt giỏ hàng và kiểm tra sản phẩm
    foreach ($cart as $key => $item) {
        if ($item['product_id'] == $data['cart_product_id']) {
            $is_available = true;
            break;
        }
    }

    // Nếu sản phẩm chưa tồn tại, thêm vào giỏ hàng
    if (!$is_available) {
        $cart[] = [
            'session_id'   => $session_id,
            'product_name' => $data['cart_product_name'],
            'product_id'   => $data['cart_product_id'],
            'product_image' => $data['cart_product_image'],
            'product_qty'  => $data['cart_product_qty'],
            'product_price' => $data['cart_product_price'],
        ];
    }

    Session::put('cart', $cart); // Cập nhật giỏ hàng
    Session::save(); // Lưu session

    return response()->json(['success' => true, 'cart' => $cart]);
}


    public function gio_hang(Request $request){
        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id', 'desc')->get();

        //SEO
        $meta_desc = "Giỏ hàng của bạn";
        $meta_keywords = "Giỏ hàng";
        $meta_title = "Giỏ hàng của bạn";
        $url_canonical = $request->url();

        return view('pages.cart.cart_ajax')->with('category',$cate_product)->with('brand',$brand_product)
        ->with(compact('meta_desc', 'meta_keywords', 'meta_title', 'url_canonical'));
    }
}
