@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      LIỆT KÊ THƯƠNG HIỆU SẢN PHẨM
    </div>
    <?php
      $message = Session::get('message');
      if($message) {
        echo "<span class='text-alert'>".$message."</span>";
        Session::put('message',null);
      }
    ?>
    <div class="row w3-res-tb">
      {{-- <div class="col-sm-5 m-b-xs">
        <select class="input-sm form-control w-sm inline v-middle">
          <option value="0">Bulk action</option>
          <option value="1">Delete selected</option>
          <option value="2">Bulk edit</option>
          <option value="3">Export</option>
        </select>
        <button class="btn btn-sm btn-default">Apply</button>                
      </div> --}}
      <div class="col-sm-4">
      </div>
      <div class="col-sm-3">
        <form action="{{ route('search_branch') }}" method="GET">
          <div class="input-group">
            <input type="text" name="query" class="input-sm form-control" placeholder="Search" value="{{ request()->input('query') }}">
            <span class="input-group-btn">
              <button class="btn btn-sm btn-default" type="submit">Go!</button>
            </span>
          </div>
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
            <th>Tên thương hiệu</th>
            <th>Từ khóa</th>
            <th>Mô tả</th>
            <th>Trạng thái</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          @foreach($all_branch_product as $key =>$cate_pro)
          <tr>
            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
            <td>{{ $cate_pro->branch_name}}</td>
            <td>{{ $cate_pro->branch_product_keywords }}
            <td>{{ $cate_pro->branch_desc }}
            <td><span class="text-ellipsis">
              <?php
                if($cate_pro->branch_status == 0) {
              ?>
                <a href='#'>
                  <i class='fa fa-thumbs-down'></i>
                </a>
              <?php } else { ?>
                <a href='#'>
                  <i class='fa fa-thumbs-up'></i>
                </a>
              <?php 
                }
              ?>
            </span></td>
            
            <td>
              <a href="{{ route('branches.edit', ['branch_id' => $cate_pro->branch_id]) }}" class="active styling-edit" ui-toggle-class="">
                <i class="fa fa-pencil-square-o text-success text-active"></i>
              </a>
              
                <span>
                  <form action="{{ route('branches.delete', ['branch_id' => $cate_pro->branch_id]) }}" method="POST" style="display:inline;">
                      {{ csrf_field() }}
                      {{ method_field('DELETE') }}
                      <button type="submit" class="active styling-edit" onclick="return confirm('Bạn có chắc là muốn xóa thương hiệu sản phẩm này không ?')" style="border:none; background:none; padding:0; cursor:pointer;">
                          <i class="fa fa-times text-danger text"></i>
                      </button>
                  </form>
                </span>
              
            </td>
          </tr>
          @endforeach
          
        </tbody>
      </table>
    </div>
    <footer class="panel-footer">
      <div class="row">
        
        <div class="col-sm-5 text-center">
          <small class="text-muted inline m-t-sm m-b-sm">showing items</small>
        </div>
        <div class="col-sm-7 text-right text-center-xs">
          <ul class="pagination pagination-sm m-t-none m-b-none">
              <!-- Liên kết trang trước -->
              @if ($all_branch_product->onFirstPage())
                  <li class="disabled"><a href="#"><i class="fa fa-chevron-left"></i></a></li>
              @else
                  <li><a href="{{ $all_branch_product->previousPageUrl() }}"><i class="fa fa-chevron-left"></i></a></li>
              @endif
      
              <!-- Các trang phân trang -->
              @foreach ($all_branch_product->getUrlRange(1, $all_branch_product->lastPage()) as $page => $url)
                  <li class="{{ $page == $all_branch_product->currentPage() ? 'active' : '' }}">
                      <a href="{{ $url }}">{{ $page }}</a>
                  </li>
              @endforeach
      
              <!-- Liên kết trang sau -->
              @if ($all_branch_product->hasMorePages())
                  <li><a href="{{ $all_branch_product->nextPageUrl() }}"><i class="fa fa-chevron-right"></i></a></li>
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