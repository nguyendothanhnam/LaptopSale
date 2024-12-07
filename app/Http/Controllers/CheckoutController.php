<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use Gloudemans\Shoppingcart\Facades\Cart;

class CheckoutController extends Controller
{
    public function AuthLogin()
    {
        $admin_id = Session::get('admin_id');
        if ($admin_id) {
            return Redirect::to('admin.dashboard');
        } else {
            return Redirect::to('admin')->send();
        }
    }

    public function login_checkout(Request $request){
            //SEO
            $meta_desc ="Trang đăng nhập khách hàng";
            $meta_keywords ="Login customer";
            $meta_title = "Đăng nhập thanh toán";
            $url_canonical = $request->url();

        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id', 'desc')->get();
        return view('pages.checkout.login_checkout')
        ->with('category',$cate_product)
        ->with('brand',$brand_product)
        ->with(compact('meta_desc', 'meta_keywords', 'meta_title', 'url_canonical'));;
    }
    public function add_customer(Request $request){
        $data = array();
        $data['customer_name'] = $request->customer_name;
        $data['customer_email'] = $request->customer_email;
        $data['customer_password'] = md5($request->customer_password);
        $data['customer_phone'] = $request->customer_phone;
        $customer_id = DB::table('tbl_customers')->insertGetId($data);

        Session::put('customer_id',$customer_id);
        Session::put('customer_name',$request->customer_name);
        return Redirect::to('/checkout');
    }

    public function checkout(Request $request){
        //SEO
        $meta_desc ="Trang thanh toán giỏ hàng";
        $meta_keywords ="Thanh toán giỏ hàng";
        $meta_title = "Trang thanh toán giỏ hàng";
        $url_canonical = $request->url();

        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id', 'desc')->get();
        return view('pages.checkout.show_checkout')
        ->with('category',$cate_product)
        ->with('brand',$brand_product)
        ->with(compact('meta_desc', 'meta_keywords', 'meta_title', 'url_canonical'));;
    }

    public function save_checkout_customer(Request $request){
        $data = array();
        $data['shipping_name'] = $request->shipping_name;
        $data['shipping_email'] = $request->shipping_email;
        $data['shipping_address'] = $request->shipping_address;
        $data['shipping_phone'] = $request->shipping_phone;
        $data['shipping_notes'] = $request->shipping_notes;
        $shipping_id = DB::table('tbl_shipping')->insertGetId($data);

        Session::put('shipping_id',$shipping_id);
        return Redirect::to('/payment');
    }

    public function payment(Request $request){
        //SEO
        $meta_desc ="Trang thanh toán giỏ hàng";
        $meta_keywords ="Thanh toán giỏ hàng";
        $meta_title = "Trang thanh toán giỏ hàng";
        $url_canonical = $request->url();

        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id', 'desc')->get();
        return view('pages.checkout.payment')
        ->with('category',$cate_product)
        ->with('brand',$brand_product)
        ->with(compact('meta_desc', 'meta_keywords', 'meta_title', 'url_canonical'));;
    }

    public function order_place(Request $request){
        
         //SEO
         $meta_desc = "Giỏ hàng của bạn";
         $meta_keywords = "Giỏ hàng";
         $meta_title = "Giỏ hàng của bạn";
         $url_canonical = $request->url();

        //insert payment method
        $data = array();
        $data['payment_method'] = $request->payment_option;
        $data['payment_status'] = 'Đang chờ xử lý';
        $payment_id = DB::table('tbl_payment')->insertGetId($data);

        //insert order
        $order_data = array();
        $order_data['customer_id'] = Session::get('customer_id');
        $order_data['shipping_id'] = Session::get('shipping_id');
        $order_data['payment_id'] = $payment_id;
        $order_data['order_total'] = Cart::subtotal();
        $order_data['order_status'] = 'Đang chờ xử lý';
        $order_id = DB::table('tbl_order')->insertGetId($order_data);
        // $body_massage = 'mã đơn hàng  '.$order_id.'tổng tiền: '.$order_data['order_total']; 

        //insert order detail
        foreach(Cart::content() as $v_content){
            $order_d_data = array();
            $order_d_data['order_id'] = $order_id;
            $order_d_data['product_id'] = $v_content->id;
            $order_d_data['product_name'] = $v_content->name;
            $order_d_data['product_price'] = $v_content->price;
            $order_d_data['product_sales_quantity'] = $v_content->qty;
            DB::table('tbl_order_details')->insert($order_d_data);
        }

        if($data['payment_method'] == 1){
            echo 'Thanh toán bằng thẻ ATM';
        }elseif($data['payment_method'] == 2){
            Cart::destroy();
            $cate_product = DB::table('tbl_category_product')
            ->where('category_status','0')
            ->orderby('category_id', 'desc')->get();
            $brand_product = DB::table('tbl_brand')
            ->where('brand_status','0')
            ->orderby('brand_id', 'desc')->get();

            // Send email to customer
            app('App\Http\Controllers\HomeController')->send_mail();
            
            return view('pages.checkout.handcash')
            ->with('category',$cate_product)
            ->with('brand',$brand_product)
            ->with(compact('meta_desc', 'meta_keywords', 'meta_title', 'url_canonical'));;
        }else{
            echo 'Thanh toán bằng thẻ ghi nợ';
        }

        // Session::put('payment_id',$payment_id);
        // return Redirect::to('/payment');
    }

    public function logout_checkout(Request $request){
        Session::flush();
        return Redirect('/login-checkout');
    }

    public function login_customer(Request $request){
        $email = $request->email_account;
        $password = md5($request->password_account);
        $result = DB::table('tbl_customers')->where('customer_email',$email)->where('customer_password',$password)->first();
        if($result){
            Session::put('customer_id',$result->customer_id);
            return Redirect::to('/checkout');
        }else{
            return Redirect::to('/login-checkout');
        }
    }

    public function manage_order(){
        $this->AuthLogin();
        $all_order_info = DB::table('tbl_order')
        ->join('tbl_customers','tbl_order.customer_id','=','tbl_customers.customer_id')
        ->select('tbl_order.*','tbl_customers.customer_name')
        ->orderby('tbl_order.order_id','desc')->get();
        $manage_order = view('admin.manage_order')->with('all_order_info',$all_order_info);
        return view('admin_layout')->with('admin.manage_order',$manage_order);
    }

    public function view_order($orderID){
        $this->AuthLogin();
        $order_by_id = DB::table('tbl_order')
        ->join('tbl_customers','tbl_order.customer_id','=','tbl_customers.customer_id')
        ->join('tbl_shipping','tbl_order.shipping_id','=','tbl_shipping.shipping_id')
        ->join('tbl_order_details','tbl_order.order_id','=','tbl_order_details.order_id')
        // ->join('tbl_payment','tbl_order.payment_id','=','tbl_payment.payment_id')
        ->select('tbl_order.*','tbl_customers.*','tbl_shipping.*','tbl_order_details.*')
        ->first();
        $manage_order_by_id = view('admin.view_order')->with('order_by_id',$order_by_id);
        return view('admin_layout')->with('admin.view_order',$manage_order_by_id);
        
    }
}
