@extends('admin_layout')
@section('admin_content')
<div class="form-w3layouts">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thông tin sản phẩm
                </header>
               
                <div class="panel-body">
                    <div class="position-center">
                        <form role="form" action="{{ route('products.index') }}" method="GET" >
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên sản phẩm</label>
                                <input type="text"  value="{{ old('product_name', $product->product_name) }}" name="product_name" class="form-control" id="exampleInputEmail1" placeholder="Tên sản phẩm" readonly>    
                            </div>
                           
                            <div class="form-group">
                                <label for="exampleInputEmail1">Giá sản phẩm</label>
                                <input type="text" value="{{ old('product_price', $product->product_price) }}" name="product_price" class="form-control" id="exampleInputEmail1" placeholder="Giá sản phẩm" readonly>
                                
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Hình ảnh sản phẩm</label>
                                
    @if ($product->product_image)
    <img src="{{ asset('storage/' . $product->product_image) }}" alt="Product Image" width="150" height="150">
    @endif
    @error('product_image')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Mô tả sản phẩm</label>
                                <textarea rows="8" class="form-control" name="product_desc" id="exampleInputPassword1" placeholder="Mô tả sản phẩm" readonly>{{ old('product_desc', $product->product_desc) }}</textarea>
                                
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Nội dung sản phẩm</label>
                                <textarea rows="8" class="form-control" name="product_content" id="exampleInputPassword1" placeholder="Nội dung sản phẩm" readonly>{{ old('product_content', $product->product_content) }}</textarea>
                                
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Danh mục</label>
                                <select class="form-control input-sm m-bot15" name="category_id" disabled>
                                    @foreach($category_product as $key => $cate)
                                        <option value="{{ $cate->category_id }}" {{ $product->category_id == $cate->category_id ? 'selected' : '' }}>{{ $cate->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Thương hiệu</label>
                                <select class="form-control input-sm m-bot15" name="branch_id" disabled>
                                    @foreach($branch_product as $key => $branch)
                                        <option value="{{ $branch->branch_id }}" {{ $product->branch_id == $branch->branch_id ? 'selected' : '' }}>{{ $branch->branch_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="product_status">Trạng thái</label>
                                <div class="form-check" >
                                    <input class="form-check-input" type="radio" name="product_status" value="1" {{ $product->product_status == 1 ? 'checked' : '' }} disabled>
                                    <label class="form-check-label" for="product_status" style="font-weight: normal;">Hoạt động</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="product_status" value="0" {{ $product->product_status == 0 ? 'checked' : '' }} disabled>
                                    <label class="form-check-label" for="product_status" style="font-weight: normal;">Không hoạt động</label>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-info btn-block">Quay lại</button>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
