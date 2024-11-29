@extends('admin_layout')
@section('admin_content')
<div class="form-w3layouts">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Sửa thương hiệu sản phẩm
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
                        <form role="form" action="{{ route('branches.update', $branch->branch_id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="branch_name">Tên thương hiệu</label>
                                <input type="text" value="{{ old('branch_name', $branch->branch_name) }}" name="branch_name" class="form-control" id="branch_name" placeholder="Tên thương hiệu">
                            </div>

                            <div class="form-group">
                                <label for="branch_product_keywords">Từ khóa thương hiệu</label>
                                <input type="text" value="{{ old('branch_product_keywords', $branch->branch_product_keywords) }}" name="branch_product_keywords" class="form-control" id="branch_product_keywords" placeholder="Từ khóa thương hiệu">
                            </div>

                            <div class="form-group">
                                <label for="branch_desc">Mô tả thương hiệu</label>
                                <textarea rows="8" class="form-control" name="branch_desc" id="branch_desc" placeholder="Mô tả thương hiệu">{{ old('branch_desc', $branch->branch_desc) }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="branch_status">Trạng thái</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="branch_status" value="1" {{ $branch->branch_status == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="branch_status" style="font-weight: normal;">Hoạt động</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="branch_status" value="0" {{ $branch->branch_status == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="branch_status" style="font-weight: normal;">Không hoạt động</label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-info btn-block">Lưu</button>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
