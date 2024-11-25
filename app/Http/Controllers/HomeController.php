<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        //SEO
        $meta_desc = "Laptop tiện ích, đa dạng, chất lượng";
        $meta_keywords = "WIBULAPTOP";
        $meta_title = "LapWibu";
        $url_canonical = $request->url();

        $cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderby('brand_id', 'desc')->get();

        $all_product = DB::table('tbl_product')->where('product_status', '0')->orderby('product_id', 'desc')->limit(4)->get();

        return view('pages.home')->with('category', $cate_product)
            ->with('brand', $brand_product)
            ->with('all_product', $all_product)
            ->with('meta_desc', $meta_desc)
            ->with('meta_keywords', $meta_keywords)
            ->with('url_canonical', $url_canonical)
            ->with('meta_title', $meta_title);
        // return view('pages.home')->with(compact('cate_product','brand_product', 'all_product'));
    }

    public function search(Request $request)
    {
        $keywords = $request->keywords_submit;
        $cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderby('brand_id', 'desc')->get();

        $search_product = DB::table('tbl_product')->where('product_name', 'like', '%' . $keywords . '%')->get();

        return view('pages.sanpham.search')->with('category', $cate_product)->with('brand', $brand_product)->with('search_product', $search_product);
    }

    public function send_mail(){
        $to_name = "Thành Nam";
        $to_email ="hinenevil@gmail.com";
        // $link_reset_pass = url('/update-new-pass?email='.$to_email.'&token='.$rand_id);

        $data = array("name"=>"Mail từ tài khoản khách hàng","body"=>"Mail gửi về vấn đề sản phẩm");
        Mail::send('pages.send_mail', $data,function($message) use ($to_name, $to_email){
            $message->to($to_email)->subject("Quên mật khẩu");
            $message->from($to_email,$to_name);
        });
        return redirect('/')->with('message','');
    }
}
