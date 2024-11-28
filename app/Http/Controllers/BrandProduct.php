<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\Brand;
use Mews\Purifier\Facades\Purifier;
// session_start();

class BrandProduct extends Controller
{
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('admin.dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function add_brand_product()
    {
        $this -> AuthLogin();
        return view('admin.add_brand_product');
    }
    public function all_brand_product()
    {
        $this -> AuthLogin();
        $all_brand_product=DB::table('tbl_brand')->get();
        $manager_brand_product=view('admin.all_brand_product')->with('all_brand_product', $all_brand_product);
        return view('admin_layout')->with('admin.all_brand_product', $manager_brand_product);
    }
    public function save_brand_product(Request $request)
    {
        $this -> AuthLogin();
        // $data = array();
        // $data['brand_name'] = $request->brand_product_name;
        // $data['brand_desc'] = $request->brand_product_desc;
        // $data['brand_status'] = $request->brand_product_status;
        // $data['meta_keywords'] = $request->brand_product_keywords;
        // DB::table('tbl_brand')->insert($data);
        // Session::put('message', 'Thêm thương hiệu sản phẩm thành công');
        // return Redirect::to('/add-brand-product');

        // Xác thực dữ liệu
        $validatedData = $request->validate([
            'brand_product_name' => 'required|string|max:255',
            'brand_product_desc' => 'required|string|min:10',
            'brand_product_keywords' => 'required|string|min:5',
            'brand_product_status' => 'required|in:0,1',
        ], [
            'brand_product_name.required' => 'Tên thương hiệu không được để trống.',
            'brand_product_desc.required' => 'Mô tả thương hiệu không được để trống.',
            'brand_product_keywords.required' => 'Từ khóa thương hiệu không được để trống.',
            'brand_product_status.required' => 'Trạng thái hiển thị là bắt buộc.',
        ]);

        // Nếu cần, làm sạch dữ liệu (dùng Purifier hoặc strip_tags)
        $brand_product_desc = Purifier::clean($validatedData['brand_product_desc']); // Sử dụng Purifier nếu cần
        $brand_product_keywords = Purifier::clean($validatedData['brand_product_keywords']); // Làm sạch từ khóa

        // Lưu vào database
        $brand = new Brand(); // Tạo instance của model
        $brand->brand_name = $validatedData['brand_product_name'];
        $brand->brand_desc = $brand_product_desc;
        $brand->brand_keywords = $brand_product_keywords;
        $brand->brand_status = $validatedData['brand_product_status'];
        $brand->save();

        // Thông báo thành công
        Session::flash('message', 'Thêm thương hiệu sản phẩm thành công');
        return Redirect::to('/add-brand-product'); // Redirect tới trang thêm thương hiệu
    }
    public function unactive_brand_product($brand_product_id)
    {
        $this -> AuthLogin();
        DB::table('tbl_brand')->where('brand_id', $brand_product_id)->update(['brand_status'=>1]);
        Session::put('message', 'Không kích hoạt thương hiệu sản phẩm thành công');
        return Redirect::to('/all-brand-product');
    }
    public function active_brand_product($brand_product_id)
    {
        $this -> AuthLogin();
        DB::table('tbl_brand')->where('brand_id', $brand_product_id)->update(['brand_status'=>0]);
        Session::put('message', 'Kích hoạt thương hiệu sản phẩm thành công');
        return Redirect::to('/all-brand-product');
    }
    public function edit_brand_product($brand_product_id)
    {
        $this -> AuthLogin();
        $edit_brand_product=DB::table('tbl_brand')->where('brand_id', $brand_product_id)->get();
        $manager_brand_product=view('admin.edit_brand_product')->with('edit_brand_product', $edit_brand_product);
        return view('admin_layout')->with('admin.edit_brand_product', $manager_brand_product);
    }
    public function delete_brand_product($brand_product_id)
    {
        $this -> AuthLogin();
        DB::table('tbl_brand')->where('brand_id', $brand_product_id)->delete();
        Session::put('message', 'Xóa thương hiệu sản phẩm thành công');
        return Redirect::to('/all-brand-product');
    }
    public function update_brand_product(Request $request, $brand_product_id)
    {
        $this -> AuthLogin();
        $data = array();
        $data['brand_name'] = $request->brand_product_name;
        $data['brand_desc'] = $request->brand_product_desc;
        $data['meta_keywords'] = $request->brand_product_keywords;
        DB::table('tbl_brand')->where('brand_id', $brand_product_id)->update($data);
        Session::put('message', 'Cập nhật thương hiệu sản phẩm thành công');
        return Redirect::to('/all-brand-product');  
    }

    //End Function Admin Page
    public function show_brand_home(Request $request ,$brand_id){
        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id', 'desc')->get();
        
        $brand_by_id = DB::table('tbl_product')
        ->join('tbl_brand','tbl_product.brand_id','=','tbl_brand.brand_id')
        ->where('tbl_product.brand_id',$brand_id)->get();

        $brand_name = DB::table('tbl_brand')->where('tbl_brand.brand_id',$brand_id)->limit(1)->get(); 

        foreach($brand_by_id as $key =>$val)
            //SEO
            $meta_desc = $val -> brand_desc;
            $meta_keywords = $val ->meta_keywords;
            $meta_title = $val -> brand_name;
            $url_canonical = $request->url();
            //Seo

        return view('pages.brand.show_brand')
        ->with('category',$cate_product)->with('brand',$brand_product)
        ->with('brand_by_id',$brand_by_id)
        ->with('brand_name',$brand_name)
        ->with('meta_desc', $meta_desc)
        ->with('meta_keywords', $meta_keywords)
        ->with('url_canonical', $url_canonical)
        ->with('meta_title', $meta_title);
    }
}
