@extends('admin_layout')
@section('admin_content')
<div class="form-w3layouts">
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Thêm sản phẩm
                        </header>
                        <?php

use Illuminate\Support\Facades\Session;

                            $message = Session::get('message');
                            if($message) {
                                echo "<span class='text-alert'>".$message."</span>";
                                Session::put('message',null);
                            }
                        ?>
                        <div class="panel-body">
                            <div class="position-center">
                                <form role="form" action="{{ route('products.save') }}" method="POST" enctype='multipart/form-data'>
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên sản phẩm</label>
                                    <input type="text" name="product_name" class="form-control" id="exampleInputEmail1" placeholder="Tên sản phẩm">
                                    
                                </div>
                               
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Giá sản phẩm</label>
                                    <input type="text" name="product_price" class="form-control" id="exampleInputEmail1" placeholder="Giá sản phẩm">
                                    
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Hình ảnh sản phẩm</label>
                                    <input type="file" name="product_image" class="form-control" id="exampleInputEmail1">
                                    
                                </div>
                               
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả sản phẩm</label>
                                    <textarea rows="5" class="form-control" name="product_desc" id="exampleInputPassword1" placeholder="Mô tả sản phẩm">
                                    </textarea>
                                    
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Nội dung sản phẩm</label>
                                    <textarea rows="5" class="form-control" name="product_content" id="exampleInputPassword1" placeholder="Mô tả sản phẩm">
                                    </textarea>
                                    
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">Danh mục</label>
                                    <select class="form-control input-sm m-bot15" name="selectCategory">
                                    @foreach($category_product as $key => $cate)
                                        <option value="{{$cate->category_id}}">{{$cate->category_name}}</option>
                                    @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">Thương hiệu</label>
                                    <select class="form-control input-sm m-bot15" name="selectBranch">
                                    @foreach($branch_product as $key => $branch)
                                        <option value="{{$branch->branch_id}}">{{$branch->branch_name}}</option>
                                    @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">Trạng thái</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="product_status" id="flexRadioDefault1" value="1"  checked>
                                        <label class="form-check-label fx-6" for="flexRadioDefault1" style=" font-weight: normal;">
                                          Hoạt động
                                        </label>
                                      </div>
                                      <div class="form-check">
                                        <input class="form-check-input" type="radio" name="product_status" id="flexRadioDefault2" value="0">
                                        <label class="form-check-label" for="flexRadioDefault2" style=" font-weight: normal;">
                                          Không hoạt động
                                        </label>
                                      </div>
                                </div>
                               
                                <button type="submit" class="btn btn-info btn-block">Thêm sản phẩm</button>
                            </form>
                            </div>

                        </div>
                    </section>

            </div>
</div>
</div>
@endsection