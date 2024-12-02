@extends('layout') 

@section("title","Đặt hàng thành công")
@section("content")
    <section id="checkout_success">
        <div class="container">
            <h2>Đặt hàng thành công!</h2>
            <p>Cảm ơn bạn đã mua hàng tại cửa hàng của chúng tôi. Đơn hàng của bạn đã được gửi đi thành công.</p>
            <p>Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất để xác nhận và giao hàng.</p>
            <p><a href="{{ route('trang-chu') }}" class="btn btn-primary">Trở về trang chủ</a></p>
        </div>
    </section>
@endsection
