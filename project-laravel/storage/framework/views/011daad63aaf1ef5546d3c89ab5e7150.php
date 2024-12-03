<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?php echo e($meta_desc); ?>">
	<meta name="robots" content="INDEX,FOLLOW" />
	<meta name="keywords" content="<?php echo e($meta_keywords); ?>">
	<link rel="canonical" href="<?php echo e($meta_canonical); ?>" />
	<title><?php echo e($meta_title); ?></title>
	<meta property="og:image" content="<?php echo e($image_og); ?>" />
	<meta property="og:site_name" content="projectlaravel.com" />
	<meta property="og:description" content="<?php echo e($meta_desc); ?>" />
	<meta property="og:title" content="<?php echo e($meta_title); ?>" />
	<meta property="og:url" content="<?php echo e($meta_canonical); ?>" />
	<meta property="og:type" content="website" />
	<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

	<link href="<?php echo e(asset('frontend/css/bootstrap.min.css')); ?>" rel="stylesheet">

	<link href="<?php echo e(asset('frontend/css/font-awesome.min.css')); ?>" rel="stylesheet">
	<link href="<?php echo e(asset('frontend/css/prettyPhoto.css')); ?>" rel="stylesheet">
	<link href="<?php echo e(asset('frontend/css/animate.css')); ?>" rel="stylesheet">
	<link href="<?php echo e(asset('frontend/css/price-range.css')); ?>" rel="stylesheet">
	<link href="<?php echo e(asset('frontend/css/main.css')); ?>" rel="stylesheet">
	<link href="<?php echo e(asset('frontend/css/sweetalert.css')); ?>" rel="stylesheet">
	<link href="<?php echo e(asset('frontend/css/responsive.css')); ?>" rel="stylesheet">

	<link rel="shortcut icon" href="<?php echo e(asset('frontend/img/ico/favicon.ico')); ?>">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png')}}">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png')}}">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png')}}">
	<link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png')}}">

	<style>
		#button-logout {
			margin-top: 12px;
		}
		
	</style>
</head><!--/head-->

<body>
	<header id="header"><!--header-->
		<div class="header_top"><!--header_top-->
			<div class="container">
				<div class="row">
				<div class="col-sm-6">
                <div class="logo">
                    <a href="<?php echo e(url('/')); ?>" class="nav-link">
                        <span style="font-size: 40px; font-weight: bold; color: #022C64;">BookStore</span>
                    </a>
                </div>
            </div>
					<div class="col-sm-6" style="float: right;">
						<div class="login-buttons pull-right">
							<ul class="nav navbar-nav">
								<?php if(session('customer_id')): ?>
								<!-- Người dùng đã đăng nhập -->
								<li>
									<a href="#" class="nav-link">
										<i class="fa fa-user"></i> <?php echo e(session('customer_name')); ?>

									</a>
								</li>


								<!-- Form đăng xuất -->
								<li>
									<form action="<?php echo e(URL::to('/logout')); ?>" method="POST" style="display:inline;">
										<?php echo csrf_field(); ?> <!-- Bảo vệ CSRF -->
										<button id="button-logout" style="margin: top 30px;" type="submit" class="nav-link" style="border: none; background: none;">
											<i class="fa fa-sign-out-alt"></i> Đăng xuất
										</button>
									</form>
								</li>
								<?php else: ?>
								<!-- Người dùng chưa đăng nhập -->
								<li>
									<a href="<?php echo e(URL::to('/login')); ?>" class="nav-link">
										<i class="fa fa-sign-in"></i> Đăng nhập 
									</a>
								</li>


								
								<li>
								
								</li>
								<?php endif; ?>


				</div>
			</div>
		</div><!--/header_top-->
		
		<div class="header-middle"><!--header-middle-->
			<div class="container">
				<div class="row">
					<div class="col-sm-4">
						<div class="logo pull-left">
							<a href="<?php echo e(URL::to('dashboard')); ?>"><img src="<?php echo e(URL::to('public/frontend/img/home/logo.png')); ?>" alt="" /></a>

						</div>
						
					</div>

			</div>
		</div><!--/header_top-->
		
		
	
		<div class="header-bottom"><!--header-bottom-->
			<div class="container">
				<div class="row">
					<div class="col-sm-8">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
						<div class="mainmenu pull-left">
							<ul class="nav navbar-nav collapse navbar-collapse">
								<li><a href="<?php echo e(URL::to('/trang-chu')); ?>" class="active" style="color:cornflowerblue">Trang chủ</a></li>
								<li class="dropdown"><a href="#">Sản phẩm<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                        <li><a href="<?php echo e(URL::to('/dashboard')); ?>">Products</a></li>
										<li><a href="<?php echo e(URL::to('/dashboard')); ?>">Product Details</a></li> 
                                    </ul>


                                </li> 
								<li><a href="<?php echo e(URL::to('/gio-hang')); ?>">Giỏ hàng</a></li>
								<li><a href="<?php echo e(URL::to('/contact')); ?>">Liên hệ</a></li>

							</ul>

						</div>
					</div>
				</div>


			</div><!--/header_top-->

			

			<div class="header-bottom"><!--header-bottom-->
				<div class="container">
					<div class="row">
						<div class="col-sm-8">
							<div class="navbar-header">
								<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
									<span class="sr-only">Toggle navigation</span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
								</button>
							</div>
							<div class="mainmenu pull-left">
								<ul class="nav navbar-nav collapse navbar-collapse">
									<li><a href="<?php echo e(URL::to('/trang-chu')); ?>" class="active" style="color:cornflowerblue">Trang chủ</a></li>
									<li class="dropdown"><a href="#">Sản phẩm<i class="fa fa-angle-down"></i></a>
										<ul role="menu" class="sub-menu">
											<li><a href="<?php echo e(URL::to('/trang-chu')); ?>">Products</a></li>
											<li><a href="<?php echo e(URL::to('/trang-chu')); ?>">Product Details</a></li>
										</ul>
									</li>
									<li><a href="<?php echo e(URL::to('/gio-hang')); ?>">Giỏ hàng</a></li>
									<li><a href="<?php echo e(URL::to('/contact')); ?>">Liên hệ</a></li>
								</ul>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="search_box pull-right" style="color:cornflowerblue">
								<form action="<?php echo e(URL::to('/tim-kiem')); ?>" method="POST">
									<?php echo e(csrf_field()); ?>

									<input type="text" placeholder="Tìm kiếm sản phẩm" name="keywordsubmit" />
									<input type="submit" value="Tìm kiếm" style="margin-top:0; background-color:cornflowerblue; color:white" class="btn btn-primary">
								</form>
							</div>
						</div>
					</div>
				</div>
			</div><!--/header-bottom-->
	</header><!--/header-->



	<section>


	
	<section id="section">
		<div class="container" style="color:blue">
			<div class="row mt-4">
				<div class="col-sm-3">
					<div class="left-sidebar">
						<h2 style="color:cornflowerblue">Danh mục sản phẩm</h2>


						<div class="panel-group category-products" id="accordian"><!--category-productsr-->

						<div class="panel-group category-products" id="accordian">


							<?php $__currentLoopData = $category_product; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $cate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title"><a href="<?php echo e(URL::to('danh-muc-san-pham/'.$cate->category_id)); ?>"><?php echo e($cate->category_name); ?></a></h4>
								</div>
							</div>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



						</div>
	
						<div class="brands_products">

							<h2 style="color:cornflowerblue">Thương hiệu sản phẩm</h2>
							<div class="brands-name">
								<ul class="nav nav-pills nav-stacked">
									<?php $__currentLoopData = $branch_product; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

									<li><a href="<?php echo e(URL::to('thuong-hieu-san-pham/'.$branch->branch_id)); ?>"> <span class="pull-right">
												(50)
											</span><?php echo e($branch->branch_name); ?></a></li>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</ul>
							</div>
						</div><!--/brands_products-->



						<div class="shipping text-center"><!--shipping-->
							<img src="<?php echo e(URL::to('public/frontend/img/home/shipping.jpg')); ?>" alt="" />
						</div><!--/shipping-->

					</div>
				</div>

				<div class="col-sm-9 padding-right">
									<?php $__currentLoopData = $branch_product; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<li><a href="<?php echo e(URL::to('thuong-hieu-san-pham/'.$branch->branch_id)); ?>"> <span class="pull-right">(50)</span><?php echo e($branch->branch_name); ?></a></li>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</ul>
							</div>
						</div>
	
						<div class="shipping text-center">
							<img src="<?php echo e(URL::to('frontend/img/home/shipping.jpg')); ?>" alt="" />
						</div>
					</div>
				</div>

	
				<!-- Cột bên phải (nội dung chính) -->
				<div class="col-sm-9 ">
					<?php echo $__env->yieldContent('content'); ?>
				</div>
			</div>
		</div>
	</section>

	
	<footer id="footer"><!--Footer-->
		<div class="footer-top">
			<div class="container">
				<div class="row">
					<div class="col-sm-2">
						<div class="companyinfo">
							<h2><span>e</span>-shopper</h2>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit,sed do eiusmod tempor</p>
						</div>
					</div>
					<div class="col-sm-7">
						<div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="#">
									<div class="iframe-img">
										<img src="<?php echo e(URL::to('frontend/img/home/iframe1.png')); ?>" alt="" />
									</div>
									<div class="overlay-icon">
										<i class="fa fa-play-circle-o"></i>
									</div>
								</a>
								<p>Circle of Hands</p>
								<h2>24 DEC 2014</h2>
							</div>
						</div>
						
						<div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="#">
									<div class="iframe-img">
										<img src="<?php echo e(URL::to('frontend/img/home/iframe2.png')); ?>" alt="" />
									</div>
									<div class="overlay-icon">
										<i class="fa fa-play-circle-o"></i>
									</div>
								</a>
								<p>Circle of Hands</p>
								<h2>24 DEC 2014</h2>
							</div>
						</div>
						
						<div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="#">
									<div class="iframe-img">
										<img src="<?php echo e(URL::to('frontend/img/home/iframe3.png')); ?>" alt="" />
									</div>
									<div class="overlay-icon">
										<i class="fa fa-play-circle-o"></i>
									</div>
								</a>
								<p>Circle of Hands</p>
								<h2>24 DEC 2014</h2>
							</div>
						</div>
						
						<div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="#">
									<div class="iframe-img">
										<img src="<?php echo e(URL::to('frontend/img/home/iframe4.png')); ?>" alt="" />
									</div>
									<div class="overlay-icon">
										<i class="fa fa-play-circle-o"></i>
									</div>
								</a>
								<p>Circle of Hands</p>
								<h2>24 DEC 2014</h2>
							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="address">
							<img src="<?php echo e(URL::to('frontend/img/home/map.png')); ?>" alt="" />
							<p>505 Da Nang, Viet Nam</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="footer-widget">
			<div class="container">
				<div class="row">
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Service</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">Online Help</a></li>
								<li><a href="#">Contact Us</a></li>
								<li><a href="#">Order Status</a></li>
								<li><a href="#">Change Location</a></li>
								<li><a href="#">FAQ’s</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Quock Shop</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">T-Shirt</a></li>
								<li><a href="#">Mens</a></li>
								<li><a href="#">Womens</a></li>
								<li><a href="#">Gift Cards</a></li>
								<li><a href="#">Shoes</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Policies</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">Terms of Use</a></li>
								<li><a href="#">Privecy Policy</a></li>
								<li><a href="#">Refund Policy</a></li>
								<li><a href="#">Billing System</a></li>
								<li><a href="#">Ticket System</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>About Shopper</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">Company Information</a></li>
								<li><a href="#">Careers</a></li>
								<li><a href="#">Store Location</a></li>
								<li><a href="#">Affillate Program</a></li>
								<li><a href="#">Copyright</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-3 col-sm-offset-1">
						<div class="single-widget">
							<h2>About Shopper</h2>
							<form action="#" class="searchform">
								<input type="text" placeholder="Your email address" />
								<button type="submit" class="btn btn-default"><i class="fa fa-arrow-circle-o-right"></i></button>
								<p>Get the most recent updates from <br />our site and be updated your self...</p>
							</form>
						</div>
					</div>
					
				</div>
			</div>
		</div>
		
		
		
	</footer><!--/Footer-->
	


	<footer id="footer"><!--Footer-->
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-sm-2">
                    <div class="companyinfo">
                        <h2><span style="color:#022C64">Book</span>Store</h2>
                        <p>Chúng tôi cung cấp sách với chất lượng tốt và giá cả hợp lý. Đọc sách, thay đổi cuộc sống.</p>
                    </div>
                </div>
                <div class="col-sm-7">
                    <div class="col-sm-3">
                        <div class="video-gallery text-center">
                            <a href="#">
                                <div class="iframe-img">
                                    <img src="<?php echo e(URL::to('public/frontend/img/home/bookstore1.png')); ?>" alt="BookStore Image" />
                                </div>
                                <div class="overlay-icon">
                                    <i class="fa fa-play-circle-o"></i>
                                </div>
                            </a>
                            <p>Sách về Kinh Doanh</p>
                            <h2>24 DEC 2024</h2>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="video-gallery text-center">
                            <a href="#">
                                <div class="iframe-img">
                                    <img src="<?php echo e(URL::to('public/frontend/img/home/bookstore2.png')); ?>" alt="BookStore Image" />
                                </div>
                                <div class="overlay-icon">
                                    <i class="fa fa-play-circle-o"></i>
                                </div>
                            </a>
                            <p>Sách văn hoá xã hội</p>
                            <h2>24 DEC 2024</h2>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="video-gallery text-center">
                            <a href="#">
                                <div class="iframe-img">
                                    <img src="<?php echo e(URL::to('public/frontend/img/home/bookstore3.png')); ?>" alt="BookStore Image" />
                                </div>
                                <div class="overlay-icon">
                                    <i class="fa fa-play-circle-o"></i>
                                </div>
                            </a>
                            <p>Sách Văn Học</p>
                            <h2>24 DEC 2024</h2>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="video-gallery text-center">
                            <a href="#">
                                <div class="iframe-img">
                                    <img src="<?php echo e(URL::to('public/frontend/img/home/bookstore4.png')); ?>" alt="BookStore Image" />
                                </div>
                                <div class="overlay-icon">
                                    <i class="fa fa-play-circle-o"></i>
                                </div>
                            </a>
                            <p>Sách khoa học công nghệ</p>
                            <h2>24 DEC 2024</h2>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-sm-3">
                    <div class="address">
                        <img src="<?php echo e(URL::to('public/frontend/img/home/map.png')); ?>" alt="Store Location" />
                        <p>1234 Book Street, City Name, Country</p>
                    </div>
                </div> -->
            </div>
        </div>
    </div>

    <div class="footer-widget">
        <div class="container">
            <div class="row">
                <div class="col-sm-2">
                    <div class="single-widget">
                        <h2>Dịch vụ</h2>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="#">Trợ giúp trực tuyến</a></li>
                            <li><a href="#">Liên hệ với chúng tôi</a></li>
                            <li><a href="#">Tình trạng đơn hàng</a></li>
                            <li><a href="#">Đổi địa điểm</a></li>
                            <li><a href="#">Câu hỏi thường gặp</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="single-widget">
                        <h2>Cửa hàng nhanh</h2>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="#">Sách Kinh Doanh</a></li>
                            <li><a href="#">Sách Khoa Học</a></li>
                            <li><a href="#">Sách Văn Học</a></li>
                            <li><a href="#">Sách Thiếu Nhi</a></li>
                            <li><a href="#">Quà Tặng</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="single-widget">
                        <h2>Chính sách</h2>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="#">Điều khoản sử dụng</a></li>
                            <li><a href="#">Chính sách bảo mật</a></li>
                            <li><a href="#">Chính sách hoàn tiền</a></li>
                            <li><a href="#">Hệ thống thanh toán</a></li>
                            <li><a href="#">Hệ thống ticket</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="single-widget">
                        <h2>Về Shop</h2>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="#">Thông tin công ty</a></li>
                            <li><a href="#">Cơ hội nghề nghiệp</a></li>
                            <li><a href="#">Vị trí cửa hàng</a></li>
                            <li><a href="#">Chương trình liên kết</a></li>
                            <li><a href="#">Bản quyền</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-3 col-sm-offset-1">
                    <div class="single-widget">
                        <h2>Nhận thông tin</h2>
                        <form action="#" class="searchform">
                            <input type="email" placeholder="Địa chỉ email của bạn" />
                            <button type="submit" class="btn btn-default"><i class="fa fa-arrow-circle-o-right"></i></button>
                            <p>Nhận thông tin mới nhất từ cửa hàng của chúng tôi và luôn cập nhật xu hướng sách mới.</p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer><!--/Footer-->




	<script src="<?php echo e(asset('frontend/js/jquery.js')); ?>"></script>
	<script src="<?php echo e(asset('frontend/js/bootstrap.min.js')); ?>"></script>
	<script src="<?php echo e(asset('frontend/js/jquery.scrollUp.min.js')); ?>"></script>
	<script src="<?php echo e(asset('frontend/js/price-range.js')); ?>"></script>
	<script src="<?php echo e(asset('frontend/js/jquery.prettyPhoto.js')); ?>"></script>
	<script src="<?php echo e(asset('frontend/js/main.js')); ?>"></script>
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	<script src="<?php echo e(asset('frontend/js/sweetalert.min.js')); ?>"></script>
	<script>
		$(document).ready(function() {
			$('.add-to-cart').click(function() {
				var id = $(this).data('id_product');
				var cart_product_id = $('.product_id_' + id).val();
				var cart_product_name = $('.product_name_' + id).val();
				var cart_product_image = $('.product_image_' + id).val();
				var cart_product_price = $('.product_price_' + id).val();
				var cart_product_qty = $('.product_qty_' + id).val();
				var cart_product_token = $('input[name="_token"]').val();
				$.ajax({
					url: '<?php echo e(URL::to("/add-cart-ajax")); ?>',
					method: 'POST',
					data: {
						cart_product_id: cart_product_id,
						cart_product_name: cart_product_name,
						cart_product_image: cart_product_image,
						cart_product_price: cart_product_price,
						cart_product_qty: cart_product_qty,
						_token: cart_product_token
					},
					success: function(data) {
						swal({
								title: "Đã thêm sản phẩm vào giỏ hàng",
								text: "Bạn có thể mua hàng tiếp hoặc tới giỏ hàng để tiến hành thanh toán",
								icon: "success",
								showCancelButton: true,
								cancelButtonText: "Xem tiếp",

								confirmButtonClass: "btn-success",
								confirmButtonText: "Đi đến giỏ hàng",
								closeOnConfirm: false,
							}, function() {
								window.location.href = "<?php echo e(url('/gio-hang')); ?>";
							}

						);

					},
					error: function(data, textStatus, errorThrown) {
						console.log(data);
					},
				})
			});
		})
	</script>


	<div id="fb-root"></div>
	<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v11.0&appId=1011902732305839&autoLogAppEvents=1" nonce="D3BpO0xr"></script>

	<script>
		$(document).ready(function() {

			$('.confirm-order').click(function() {
				var shipping_name = $('.shipping_name').val();
				var shipping_email = $('.shipping_email').val();
				var shipping_phone = $('.shipping_phone').val();
				var shipping_address = $('.shipping_address').val();
				var shipping_note = $('.shipping_note').val();
				var payment_select = $('.payment_select').val();
				var _token = $('input[name="_token"]').val();

				var feeship = $('.fee_shipping').val();
				var coupon = $('.coupon_value').val();
				swal({
						title: "Xác nhận đặt hàng ?",
						text: "Bạn sẽ không thể hủy đơn hàng sau khi thực hiện thao tác này!",
						type: "warning",
						showCancelButton: true,
						confirmButtonClass: "btn-danger",
						confirmButtonText: "Ok, đồng ý",
						cancelButtonText: "Không, để sau",
						closeOnConfirm: false,
						closeOnCancel: false
					},
					function(isConfirm) {
						if (isConfirm) {
							$.ajax({
								url: '<?php echo e(url::to("/confirm-order")); ?>',
								method: 'POST',
								data: {
									shipping_name: shipping_name,
									shipping_email: shipping_email,
									shipping_phone: shipping_phone,
									shipping_address: shipping_address,
									shipping_note: shipping_note,
									payment_select: payment_select,
									feeship: feeship,
									coupon: coupon,
									_token: _token
								},
								success: function() {

								}
							});
							swal("Thành công!", "Đơn hàng của bạn đã được xác nhận", "success");
							window.setTimeout(() => {
								location.reload();
							}, 3000);
						} else {
							swal("Đã đóng!", "Đơn hàng chưa được gửi đi", "error");
						}
					});

			});
			$('.feeship_calculate').click(function() {
				var cityId = $('.city').val();
				var provinceId = $('.province').val();
				var wardId = $('.ward').val();
				var _token = $('input[name="_token"]').val();

				if (cityId == 0 || provinceId == 0 || wardId == 0) {

					alert('Vui lòng chọn địa chỉ giao hàng');
				} else {
					$.ajax({
						url: '<?php echo e(url::to("/calculate-fee")); ?>',
						method: 'POST',
						data: {
							cityId: cityId,
							provinceId: provinceId,
							wardId: wardId,
							_token: _token
						},
						success: function() {
							location.reload();
						}
					})
				}
			});
			$('.choose').on('change', function() {
				var action = $(this).attr('id');
				var ma_id = $(this).val();
				var _token = $('input[name="_token"]').val();
				var result = '';

				if (action == 'nameCity') {
					result = "nameProvince";
				} else {
					result = "nameWards";
				}

				$.ajax({
					url: '<?php echo e(url::to("/get-delivery-home")); ?>',
					method: 'POST',
					data: {
						action: action,
						ma_id: ma_id,
						_token: _token
					},
					success: function(data) {
						$('#' + result).html(data);
					}
				})
			});
		});
	</script>
</body>

</html><?php /**PATH C:\Users\ADMIN\Downloads\project_laravel\project-laravel\resources\views/layout.blade.php ENDPATH**/ ?>