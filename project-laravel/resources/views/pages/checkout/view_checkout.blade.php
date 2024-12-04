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
							<input type="button" class="btn btn-primary sm-10 confirm-order" value="Xác nhận đơn hàng">
							<?php
				$totalcartPrice = 0;
			?>
								@if(session()->has('message'))
								<div class="alert alert-danger">
									{{ session()->get('message') }}
								</div>
								@elseif(session()->has('error'))
								{{ session()->get('error') }}
								@endif

								<table class="table table-condensed">
									<thead>
										<tr class="cart_menu">
											<td class="image">Hình ảnh</td>
											<td class="description">Tên sản phẩm</td>
											<td class="price">Giá sản phẩm</td>
											<td class="quantity">Số lượng</td>
											<td class="total">Thành tiền</td>
											<td></td>
										</tr>
									</thead>
									<form action="{{URL::to('/update-cart')}}" method="POST">
										<tbody>

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
														$totalcartPrice += $totalPrice;
														@endphpđ</p>
												</td>
												<td class="cart_delete">
													<a class="cart_quantity_delete" href="{{URL::to('/del-cart/'.$cart['session_id'])}}"><i class="fa fa-times"></i></a>

												</td>

											</tr>
											@endforeach
											<tr>
												<td colspan="5">
													<input type="submit" value="Cập nhật giỏ hàng" class="submitQty check_out">
													<a href="{{URL::to('/delete-cart')}}" class="submitQty check_out">Xóa tất cả sản phẩm</a>



													@php
													$customer_id = session('customer_id');
													$cart = session('cart');
													@endphp

													@if (!$cart || count($cart) == 0)
													<!-- Nếu giỏ hàng trống -->
													<a class="check_out" onclick="return alert('Bạn chưa có gì trong giỏ hàng, vui lòng thêm một sản phẩm')" href="#">Thanh toán</a>
													@elseif ($customer_id != NULL)
													<!-- Nếu khách hàng đã đăng nhập -->
													<a class="check_out" href="{{ URL::to('/payment') }}">Thanh toán</a>
													@else
													<!-- Nếu khách hàng chưa đăng nhập -->
													<a class="check_out" href="{{ URL::to('/login-checkout') }}">Thanh toán</a>
													@endif
													<!-- <div class="pull-right">
														<ul>
															<li>Tổng tiền sản phẩm: <span>{{number_format($totalcartPrice,0,',','.')}} đ</span></li>

															@if(Session::get('coupon'))
															@foreach(Session::get('coupon') as $key => $val)
															@if($val['coupon_condition'] == 1)
															<li>Mã giảm: {{ $val['coupon_number']}} % <a href="{{url('/unset-coupon')}}"><i class="fa fa-times"></i></a></li>

															@php
															$couponMonmey = ($totalcartPrice * $val['coupon_number']) / 100;
															echo '<li>Số tiền được giảm: '.number_format($couponMonmey,0,',','.').' đ</li>';
															$totalAfterCoupon = $totalcartPrice - $couponMonmey;

															@endphp
															@else
															<li>Mã giảm: {{ number_format($val['coupon_number'],0,',','.')}} đ <a href="{{url('/unset-coupon')}}"><i class="fa fa-times"></i></a></li>

															@php
															echo '<li>Số tiền được giảm: '.number_format($val['coupon_number'],0,',','.').' đ</li>';
															$totalAfterCoupon = $totalcartPrice - $val['coupon_number'];

															@endphp
															@endif
															@endforeach
															@endif
															@if(Session::get('fee'))
															<li>Phí vận chuyển: <span>{{number_format(Session::get('fee'),0,',','.')}}
																	<a href="{{url('/delete-fee-home')}}"><i class="fa fa-times"></i></a>
																</span></li>
															@endif

															<?php
															$totalAfterAll = 0;
															if (session('coupon')) {
																$totalAfterAll = session('fee') ? $totalAfterCoupon + session('fee') : $totalAfterCoupon;
															} else {
																$totalAfterAll = session('fee') ? $totalcartPrice + session('fee') : $totalcartPrice;
															}
															echo '<li>Tổng tiền thanh toán: ' . number_format($totalAfterAll, 0, ',', '.') . ' đ</li>';
															?>

														</ul>
													</div> -->
												
												</td>
											</tr>


										</tbody>
									</form>
									
									@else
									<tr>
										<td colspan="5">
											<center>
												<p>Không có sản phẩm nào</p>
											</center>
										</td>
									</tr>
									@endif
								</table>


					</div>

</section> <!--/#cart_items-->
@endsection

