@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            DANH SÁCH SẢN PHẨM
        </div>

        <div class="row w3-res-tb">
            <div class="col-sm-3">
                <form action="{{ route('search-product') }}" method="GET" class="input-group">
                    <input type="text" class="input-sm form-control" name="query" placeholder="Tìm kiếm sản phẩm">
                    <span class="input-group-btn">
                        <button class="btn btn-sm btn-default" type="submit">Tìm kiếm</button>
                    </span>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped b-t b-light">
                <thead>
                    <tr>
                        <th style="width:20px;">
                            <label class="i-checks m-b-none">
                                <input type="checkbox"><i></i>
                            </label>
                        </th>
                        <th>Tên sản phẩm</th>
                        <th>Giá sản phẩm</th>
                        <th>Hình ảnh sản phẩm</th>
                        <th>Danh mục</th>
                        <th>Thương hiệu</th>
                        <th>Trạng thái</th>
                        <th style="width:30px;"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($all_product as $key => $product)
                    <tr>
                        <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                        <td>{{ $product->product_name}}</td>
                        <td>{{ $product->product_price }}</td>
                        <td><img src="{{ asset('storage/' . $product->product_image) }}" class="img-thumbnail style-img-all-product" alt="Lỗi ảnh"></td>

                        <td>
                            {{ $product->category ? $product->category->category_name : 'No Category' }}
                        </td>
                        <td>{{ $product->brand->branch_name }} </td>

                        <td><span class="text-ellipsis">
                                <?php
                                if ($product->product_status == 0) {
                                ?>

                                    <i class='fa fa-thumbs-down'></i>

                                <?php } else { ?>

                                    <i class='fa fa-thumbs-up'></i>

                                <?php
                                }
                                ?>
                            </span></td>

                        <td>
                            <a href="{{ route('products.edit', $product->product_id) }}" class="active styling-edit" ui-toggle-class="">
                                <i class="fa fa-pencil-square-o text-success text-active"></i>
                            </a>
                            <form action="{{ route('products.delete', ['product_id' => $product->product_id]) }}" method="POST" style="display:inline;">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="active styling-edit" onclick="return confirm('Bạn có chắc là muốn xóa thương hiệu sản phẩm này không ?')" style="border:none; background:none; padding:0; cursor:pointer;">
                                    <i class="fa fa-times text-danger text"></i>
                                </button>
                            </form>
                            <a href="{{ route('products.show', $product->product_id) }}"><i class="fa fa-file-text"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <footer class="panel-footer">
                <div class="row">
                    <div class="col-sm-5 text-center">
                        <small class="text-muted inline m-t-sm m-b-sm">showing {{ $all_product->firstItem() }} to {{ $all_product->lastItem() }} of {{ $all_product->total() }} items</small>
                    </div>
                    <div class="col-sm-7 text-right text-center-xs">
                        <ul class="pagination pagination-sm m-t-none m-b-none">
                            <!-- Liên kết trang trước -->
                            @if ($all_product->onFirstPage())
                            <li class="disabled"><a href="#"><i class="fa fa-chevron-left"></i></a></li>
                            @else
                            <li><a href="{{ $all_product->previousPageUrl() }}"><i class="fa fa-chevron-left"></i></a></li>
                            @endif

                            <!-- Các trang phân trang -->
                            @foreach ($all_product->getUrlRange(1, $all_product->lastPage()) as $page => $url)
                            <li class="{{ $page == $all_product->currentPage() ? 'active' : '' }}">
                                <a href="{{ $url }}">{{ $page }}</a>
                            </li>
                            @endforeach

                            <!-- Liên kết trang sau -->
                            @if ($all_product->hasMorePages())
                            <li><a href="{{ $all_product->nextPageUrl() }}"><i class="fa fa-chevron-right"></i></a></li>
                            @else
                            <li class="disabled"><a href="#"><i class="fa fa-chevron-right"></i></a></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </footer>

        </div>
    </div>
    @endsection