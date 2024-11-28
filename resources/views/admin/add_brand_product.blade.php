@extends('admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thêm thương hiệu sản phẩm
                </header>
                <?php
                    $message = Session::get('message');
                    if ($message) {
                        echo '<span class="text-alert">' . $message . '</span>';
                        Session('message', null);
                    }
                    ?>
                <div class="panel-body">
                    
                    <div class="position-center">
                        <form role="form" action="{{ asset('/save-brand-product') }}" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên thương hiệu</label>
                                <input type="text" name="brand_product_name" class="form-control" value="{{ old('brand_product_name') }}"
                                    id="exampleInputEmail1" placeholder="Tên thương hiệu">
                                    @error('brand_product_name')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Mô tả thương hiệu</label>
                                <textarea style="resize: none" rows="8" class="form-control ckeditor" name="brand_product_desc"
                                    id="exampleInputPassword1" placeholder="Mô tả thương hiệu">{{ old('brand_product_desc') }}</textarea>
                                    @error('brand_product_desc')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Từ khóa thương hiệu</label>
                                <textarea style="resize: none" rows="8" class="form-control ckeditor" name="brand_product_keywords" 
                                    id="exampleInputPassword1" placeholder="Từ khóa thương hiệu">{{ old('brand_product_keywords') }}</textarea>
                                    @error('brand_product_name')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Hiển thị</label>
                                <select name="brand_product_status" class="form-control input-sm m-bot15">
                                    <option value="0">Hiện</option>
                                    <option value="1">Ẩn</option>
                                </select>
                            </div>
                            <button type="submit" name="add_brand_product" class="btn btn-info">Thêm thương hiệu</button>
                        </form>
                    </div>

                </div>
            </section>
        </div>
    @endsection
