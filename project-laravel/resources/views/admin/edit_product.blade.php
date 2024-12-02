@extends('admin_layout')
@section('admin_content')
<div class="form-w3layouts">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Chỉnh sửa sản phẩm
                </header>
                <?php 
                    $message = Session::get('message');
                    if($message) {
                        echo "<span class='text-alert'>".$message."</span>";
                        Session::put('message',null);
                    }
                ?>
                <div class="panel-body">
                    <div class="position-center">
                        <form role="form" action="{{ route('products.update', $product->product_id) }}" method="POST" enctype='multipart/form-data'>
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên sản phẩm</label>
                                <input type="text" value="{{ old('product_name', $product->product_name) }}" name="product_name" class="form-control" id="exampleInputEmail1" placeholder="Tên sản phẩm">
                                @error('product_name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                           
                            <div class="form-group">
                                <label for="exampleInputEmail1">Giá sản phẩm</label>
                                <input type="text" value="{{ old('product_price', $product->product_price) }}" name="product_price" class="form-control" id="exampleInputEmail1" placeholder="Giá sản phẩm">
                                @error('product_price')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Hình ảnh sản phẩm</label>
                                <input type="file" name="product_image" class="form-control" id="exampleInputEmail1">
    @if ($product->product_image)
    <img src="{{ asset('storage/' . $product->product_image) }}" alt="Product Image" width="100" height="100">
    @endif
    @error('product_image')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Mô tả sản phẩm</label>
                                <textarea rows="8" class="form-control" name="product_desc" id="exampleInputPassword1" placeholder="Mô tả sản phẩm">{{ old('product_desc', $product->product_desc) }}</textarea>
                                @error('product_desc')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Nội dung sản phẩm</label>
                                <textarea rows="8" class="form-control" name="product_content" id="exampleInputPassword1" placeholder="Nội dung sản phẩm">{{ old('product_content', $product->product_content) }}</textarea>
                                @error('product_content')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Danh mục</label>
                                <select class="form-control input-sm m-bot15" name="category_id">
                                    @foreach($category_product as $key => $cate)
                                        <option value="{{ $cate->category_id }}" {{ $product->category_id == $cate->category_id ? 'selected' : '' }}>{{ $cate->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Thương hiệu</label>
                                <select class="form-control input-sm m-bot15" name="branch_id">
                                    @foreach($branch_product as $key => $branch)
                                        <option value="{{ $branch->branch_id }}" {{ $product->branch_id == $branch->branch_id ? 'selected' : '' }}>{{ $branch->branch_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="product_status">Trạng thái</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="product_status" value="1" {{ $product->product_status == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="product_status" style="font-weight: normal;">Hoạt động</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="product_status" value="0" {{ $product->product_status == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="product_status" style="font-weight: normal;">Không hoạt động</label>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-info btn-block">Cập nhật sản phẩm</button>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
