@extends('admin_layout')
@section('admin_content')
<div class="form-w3layouts">
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Thêm thương hiệu sản phẩm
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
                                <form role="form" action="{{ route('branches.save_branch') }}" method="POST">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên thương hiệu</label>
                                    <input type="text" name="branch_name" class="form-control" id="exampleInputEmail1" placeholder="Tên thương hiệu" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Từ khóa thương hiệu</label>
                                    <input type="text" name="branch_product_keywords" class="form-control" id="exampleInputEmail1" placeholder="Từ khóa thương hiệu" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả thương hiệu</label>
                                    <textarea rows="8" class="form-control" name="branch_desc" id="exampleInputPassword1" placeholder="Mô tả thương hiệu" required>
                                    </textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">Trạng thái</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="branch_status" id="flexRadioDefault1" value="1"  checked>
                                        <label class="form-check-label fx-6" for="flexRadioDefault1" style=" font-weight: normal;">
                                          Hoạt động
                                        </label>
                                      </div>
                                      <div class="form-check">
                                        <input class="form-check-input" type="radio" name="branch_status" id="flexRadioDefault2" value="0">
                                        <label class="form-check-label" for="flexRadioDefault2" style=" font-weight: normal;">
                                          Không hoạt động
                                        </label>
                                      </div>
                                </div>
                               
                                <button type="submit" class="btn btn-info btn-block">Thêm thương hiệu</button>
                            </form>
                            </div>

                        </div>
                    </section>

            </div>
</div>
</div>
@endsection