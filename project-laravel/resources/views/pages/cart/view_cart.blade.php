@extends('layout')
@section("title","Trang giỏ hàng")
@section("content")
<section id="cart_items">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="{{URL::to('/')}}">Home</a></li>
				  <li class="active">Giỏ hàng của bạn</li>
				</ol>
			</div>
            
            
			<div class="table-responsive cart_info">
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
					<tbody>
                    <?php
					use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\Session;

					$carts = Cart::getContent();
                    ?>
                    @foreach($carts as $cart_item)
						<tr>
							<td class="cart_product">
								<a href=""><img src="{{URL::to('upload/product/'.$cart_item->options->image)}}" alt="" width="50" height="50"></a>
							</td>
							<td class="cart_description">
								<h4><a href="">{{$cart_item->name}}</a></h4>
								<p>Mã: {{$cart_item->id}}</p>
							</td>
							<td class="cart_price">
								<p>{{number_format($cart_item->price)." VND"}}</p>
							</td>
							<td class="cart_quantity">
								<form action="{{URL::to('/update-view-cart')}}" method="POST">
								{{ csrf_field() }}
								<div class="cart_quantity_button">
									<input type="hidden" name="rowIDChangeQty" value="{{$cart_item->rowId}}">
									<input class="cart_quantity_input" type="number" name="quantity_change" value="{{$cart_item->qty}}" size="2">
									<input type="submit" value="Cập nhật" class="submitQty">
								</div>
								</form>
							</td>
							<td class="cart_total">
								<p class="cart_total_price">
                                    <?php
                                        $subtotal = $cart_item->price * $cart_item->qty;
                                        echo number_format($subtotal). " VND";
                                    ?>
                                </p>
							</td>
							<td class="cart_delete">
								<a class="cart_quantity_delete" href="{{URL::to('/delete-to-cart'.$cart_item->rowId)}}"><i class="fa fa-times"></i></a>
							</td>
                        
						</tr>
                    @endforeach
					</tbody>
				</table>
			</div>
	</section> <!--/#cart_items-->
    <section id="do_action">
			<div class="row">
				<div class="col-sm-6">
					<div class="total_area">
						<ul>
							<li>Tổng tiền sản phẩm <span>{{ Cart::getSubtotal(0) . " VND" }}</span></li>
							<li>Thuế 
								<span>
									<?php
									// Get all conditions (tax included)
									$tax = 0;
									$conditions = Cart::getConditions();

									// Loop through conditions to find the tax
									foreach ($conditions as $condition) {
										if ($condition->getType() == 'tax') {
											$tax = $condition->getValue();
											break;
										}
									}

									// Display the tax
									echo number_format($tax, 0) . " VND";
									?>
								</span>
							</li>
							<li>Phí vận chuyển <span>Miễn phí</span></li>
							<li>Tổng tiền thanh toán <span>{{ Cart::getTotal(0) . " VND" }}</span></li>
						</ul>
							<?php
									$customer_id = Session::get('customer_id');
								
									if($customer_id != NULL && Cart::getContent()->count() == 0) {
									?>
									<a class="btn btn-default check_out" onclick="return alert('Bạn chưa có gì trong giỏ hàng, vui lòng thêm một sản phẩm')" href="#">Thanh toán</a>
									<?php }
									elseif($customer_id != NULL && Cart::getContent()->count() != 0){?>
										<a class="btn btn-default check_out" href="{{URL::to('/checkout')}}">Thanh toán</a>
									<?php } ?>
							
					</div>
				</div>
			</div>
	</section><!--/#do_action-->

@endsection