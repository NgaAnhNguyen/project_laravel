@extends('layout') 
@section("title", "Trang thanh toán")
@section("content")
<section id="cart_items">
    <div class="breadcrumbs">
        <ol class="breadcrumb">
            <li><a href="#">Home</a></li>
            <li class="active">Thanh toán</li>
        </ol>
    </div><!--/breadcrumbs-->
    
    <div class="register-req">
        <p>Vui lòng nhập thông tin giao hàng để tiến hành thanh toán</p>
    </div><!--/register-req-->
    
    <!-- Display Cart Items -->
    <div class="cart-items">
        <h3>Danh sách mặt hàng trong giỏ hàng</h3>
        @if(count($cart) > 0)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tên sản phẩm</th>
                    <th>Hình ảnh</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart as $item)
                <tr>
                    <td>{{ $item['product_name'] }}</td>
                    <td><img src="{{ $item['product_image'] }}" alt="{{ $item['product_name'] }}" width="100"></td>
                    <td>{{ number_format($item['product_price'], 0, ',', '.') }} VND</td>
                    <td>{{ $item['product_qty'] }}</td>
                    <td>{{ number_format($item['product_price'] * $item['product_qty'], 0, ',', '.') }} VND</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Hiển thị tổng tiền -->
        <div class="total-amount">
            <h4>Tổng tiền đơn hàng: <span>{{ number_format($totalAmount, 0, ',', '.') }} VND</span></h4>
            <h4>Phí vận chuyển: <span>{{ number_format($shippingFee, 0, ',', '.') }} VND</span></h4>
            <h4>Tổng cộng: <span>{{ number_format($totalAmountWithShipping, 0, ',', '.') }} VND</span></h4>
        </div>
        @else
        <p>Giỏ hàng của bạn trống! Vui lòng thêm sản phẩm vào giỏ hàng.</p>
        @endif
    </div><!--/cart-items-->
    
    <div class="shopper-informations">
        <div class="row">
            <div class="col-sm-12 clearfix">
                <div class="bill-to">
                    <p>Thông tin đơn hàng</p>
                    <div class="form-one">
                        <form method="POST" action="{{ route('checkout.store') }}">
                            @csrf
                            <label for="shipping_name">Tên người nhận <span style="color: red;">*</span></label>
                            <input type="text" id="shipping_name" name="shipping_name" class="shipping_name" placeholder="Tên người nhận" required>

                            <label for="shipping_email">Địa chỉ email <span style="color: red;">*</span></label>
                            <input type="email" id="shipping_email" name="shipping_email" class="shipping_email" placeholder="Địa chỉ email" required>

                            <label for="shipping_phone">Số điện thoại <span style="color: red;">*</span></label>
                            <input type="text" id="shipping_phone" name="shipping_phone" class="shipping_phone" placeholder="Số điện thoại" required>

                            <label for="shipping_address">Địa chỉ nhận hàng <span style="color: red;">*</span></label>
                            <input type="text" id="shipping_address" name="shipping_address" class="shipping_address" placeholder="Địa chỉ nhận hàng" required>

                            <label for="shipping_note">Ghi chú đơn hàng của bạn</label>
                            <textarea name="shipping_note" id="shipping_note" class="shipping_note" placeholder="Ghi chú đơn hàng của bạn" rows="5"></textarea>

                            <div class="form-group">
                                <label for="payment_select">Chọn phương thức thanh toán <span style="color: red;">*</span></label>
                                <select class="form-control input-sm m-bot15 payment_select" name="payment_select" id="payment_select" required>
                                    <option value="0">Tiền mặt</option>
                                    <option value="1">Chuyển khoản</option>
                                </select>
                            </div>

                            <input type="submit" class="btn btn-primary sm-10" value="Xác nhận đơn hàng">
                        </form>
                    </div>
                </div>
            </div>          
        </div>
    </div>
</section> <!--/#cart_items-->
@endsection
