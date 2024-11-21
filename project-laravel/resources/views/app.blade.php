<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Web của Tôi</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">Trang Web</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <!-- Hiển thị tên người dùng ở góc trái nếu đã đăng nhập -->
                    @if(Session::has('user_name'))
                        <li class="nav-item">
                            <span class="nav-link">Chào, {{ session('user_name') }}</span>
                        </li>
                    @endif
                    
                    <!-- Các liên kết khác, ví dụ Đăng nhập, Đăng ký, v.v. -->
                    @if(Auth::guest())
                        <li class="nav-item">
                            <a href="{{ URL::to('/login') }}" class="nav-link"><i class="fa fa-sign-in"></i> Đăng nhập</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ URL::to('/logout') }}" class="nav-link"><i class="fa fa-sign-out-alt"></i> Đăng xuất</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
