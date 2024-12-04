@extends('layout')
@section("title","Trang xác nhận thanh toán")
@section("content")
<section id="cart_items">
    <div class="breadcrumbs">
        <ol class="breadcrumb">
            <li><a href="#">Home</a></li>
            <li class="active">Thanh toán giỏ hàng</li>
        </ol>
    </div><!--/breadcrums-->

    <div class="review-payment">
        <h2>Xem lại giỏ hàng và chọn phương thức thanh toán</h2>
    </div>

    <div class="table-responsive cart_info">
        <table class="table table-condensed">
            <thead>
                <tr class="cart_menu">
                <td class="description">Tên sản phẩm</td>
                    <td class="image">Hình ảnh</td>
                    
                    <td class="price">Giá sản phẩm</td>
                    <td class="quantity">Số lượng</td>
                    <td class="total">Thành tiền</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
            <?php
				$totalcartPrice = 0;
			?>
    @if(Session::get('cart'))
        @foreach(Session::get('cart') as $key => $cart)
            <tr>
                <td class="cart_product">
                    <a href=""><img src="{{URL::to('public/upload/product/'.$cart['product_image'])}}" alt="" width="50" height="50"></a>
                </td>
                <td class="cart_description">
                    <h4><a href="{{URL::to('chi-tiet-san-pham/'.$cart['product_id'])}}">{{$cart['product_name']}}</a></h4>
                    <!-- <p>Mã: {{$cart['product_id']}}</p> -->
                </td>
                <td class="cart_price">
                    <p>{{number_format($cart['product_price'],0,',','.')}}đ</p>
                </td>
                <td class="cart_quantity">
                    {{ csrf_field() }}
                    <div class="cart_quantity_button">
                        <input class="cart_quantity_input" type="number" min="1" name="quantity_change[{{$cart['session_id']}}]" value="{{$cart['product_qty']}}" size="2">
                    </div>
                </td>
                <td class="cart_total">
                    <p class="cart_total_price">
                        @php
                            $totalPrice = $cart['product_price'] * $cart['product_qty'];
                            echo number_format($totalPrice,0,',','.');
                            $totalcartPrice += $totalPrice ?? 0; // Đảm bảo không lỗi undefined variable
                        @endphp
                        đ
                    </p>
                </td>
                <td class="cart_delete">
                    <a class="cart_quantity_delete" href="{{URL::to('/del-cart/'.$cart['session_id'])}}"><i class="fa fa-times"></i></a>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="6">Giỏ hàng của bạn hiện đang trống.</td>
        </tr>
    @endif
</tbody>

        </table>
    </div>
    <div class="payment-options">
        <div class="review-payment">
            <h2>Chọn hình thức thanh toán</h2>
        </div>
        <form action="{{URL::to('save-order')}}" method="POST">
            {{ csrf_field() }}
            <span>
                <label><input type="checkbox" name="payment_value" value="1"> Trả trước bằng thẻ ATM</label>
            </span>
            <span>
                <label><input type="checkbox" name="payment_value" value="2"> Trả tiền khi nhận hàng</label>
            </span>
            <span>
                <label><input type="checkbox" name="payment_value" value="3"> Trả bằng thẻ ghi nợ</label>
            </span>
            <input type="submit" class="btn btn-primary sm-10" value="Đặt hàng">

        </form>
    </div>
    </div>

</section> <!--/#cart_items-->
@endsection