<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\Category;
use Mews\Purifier\Facades\Purifier;
session_start();

class CategoryProduct extends Controller
{
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('admin.dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function add_category_product()
    {
        $this -> AuthLogin();
        return view('admin.add_category_product');
    }
    public function all_category_product()
    {
        $this -> AuthLogin();
        $all_category_product = Category::orderBy('category_id', 'ASC')->get();
        // $all_category_product=DB::table('tbl_category_product')->get();
        $manager_category_product=view('admin.all_category_product')->with('all_category_product', $all_category_product);
        return view('admin_layout')->with('admin.all_category_product', $manager_category_product);
    }
    public function save_category_product(Request $request)
{
    // **1. Kiểm tra xác thực người dùng (AuthLogin)**
    $this->AuthLogin();

    // **2. Xác thực dữ liệu nhập**
    $validatedData = $request->validate([
        'category_product_name' => 'required|string|max:255',
        'category_product_desc' => 'required|string|min:10',
        'category_product_keywords' => 'required|string|min:5',
        'category_product_status' => 'required|in:0,1',
    ], [
        'category_product_name.required' => 'Tên danh mục không được để trống.',
        'category_product_desc.required' => 'Mô tả danh mục không được để trống.',
        'category_product_keywords.required' => 'Từ khóa danh mục không được để trống.',
        'category_product_status.required' => 'Trạng thái hiển thị là bắt buộc.',
    ]);

    // **3. Làm sạch dữ liệu CKEditor**
    $categoryDesc = Purifier::clean($validatedData['category_product_desc']);
    $categoryKeywords = Purifier::clean($validatedData['category_product_keywords']);

    // **4. Lưu dữ liệu vào cơ sở dữ liệu**
    $category = new Category();
    $category->category_name = $validatedData['category_product_name'];
    $category->category_desc = $categoryDesc; 
    $category->meta_keywords = $categoryKeywords; 
    $category->category_status = $validatedData['category_product_status'];
    $category->save();

    // **5. Thông báo thành công**
    Session::flash('message', 'Thêm danh mục sản phẩm thành công');
    return Redirect::to('/add-category-product');
}
    public function unactive_category_product($category_product_id)
    {
        $this -> AuthLogin();
        DB::table('tbl_category_product')->where('category_id', $category_product_id)->update(['category_status'=>1]);
        Session::put('message', 'Không kích hoạt danh mục sản phẩm thành công');
        return Redirect::to('/all-category-product');
    }
    public function active_category_product($category_product_id)
    {
        $this -> AuthLogin();
        DB::table('tbl_category_product')->where('category_id', $category_product_id)->update(['category_status'=>0]);
        Session::put('message', 'Kích hoạt danh mục sản phẩm thành công');
        return Redirect::to('/all-category-product');
    }
    public function edit_category_product($category_product_id)
    {
        $this -> AuthLogin();
        // $edit_category_product=DB::table('tbl_category_product')->where('category_id', $category_product_id)->get();
        $edit_category_product = Category::where('category_id', $category_product_id)->first();
        $manager_category_product=view('admin.edit_category_product')->with('edit_category_product', $edit_category_product);
        return view('admin_layout')->with('admin.edit_category_product', $manager_category_product);
    }
    public function delete_category_product($category_product_id)
    {
        $this -> AuthLogin();
        DB::table('tbl_category_product')->where('category_id', $category_product_id)->delete();
        Session::put('message', 'Xóa danh mục sản phẩm thành công');
        return Redirect::to('/all-category-product');
    }
    public function update_category_product(Request $request, $category_product_id)
    {
        $this -> AuthLogin();
        // $data = array();
        // $data['category_name'] = $request->category_product_name;
        // $data['category_desc'] = $request->category_product_desc;
        // $data['meta_keywords'] = $request->category_product_keywords;
        // DB::table('tbl_category_product')->where('category_id', $category_product_id)->update($data);
        $data = $request->all();
        $category = Category::find($category_product_id);
        $category->category_name=$data['category_product_name'];
        $category->category_desc=$data['category_product_desc'];   
        $category->meta_keywords=$data['category_product_keywords'];  
        $category->save();
        Session::put('message', 'Cập nhật danh mục sản phẩm thành công');
        return Redirect::to('/all-category-product');
    }

    //End function admin page
    public function show_category_home(Request $request ,$category_id){
        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id', 'desc')->get();
        $category_by_id = DB::table('tbl_product')->join('tbl_category_product','tbl_product.category_id','=','tbl_category_product.category_id')->where('tbl_product.category_id',$category_id)->get();
        
        if (!empty($category_by_id) && is_array($category_by_id)) {
            foreach ($category_by_id as $key => $val) {
                // SEO
                $meta_desc = $val->category_desc ?? '';
                $meta_keywords = $val->meta_keywords ?? '';
                $meta_title = $val->category_name ?? '';
                $url_canonical = $request->url();
                // SEO
            }
        } else {
            $meta_desc = '';
            $meta_keywords = '';
            $meta_title = 'Default Title';
            $url_canonical = $request->url();
        }
        

        $category_name = DB::table('tbl_category_product')->where('tbl_category_product.category_id',$category_id)->limit(1)->get();
        
        return view('pages.category.show_category')
        ->with('category',$cate_product)->with('brand',$brand_product)
        ->with('category_by_id',$category_by_id)
        ->with('category_name',$category_name)
        ->with('meta_desc', $meta_desc)
        ->with('meta_keywords', $meta_keywords)
        ->with('url_canonical', $url_canonical)
        ->with('meta_title', $meta_title);
    }

    
}