<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title_admin')</title>
    <link rel="icon" type="image/png" href="/assets/img/logo.png">
    <link rel="stylesheet" href="{{ asset('assets/admin_css/style.css') }}">
    @yield('css_admin')
</head>

<body>
    <header>
        @if(session('success'))
        <div class="alert-box success">
            <span class="close-btn" onclick="this.parentElement.style.display='none';">&times;</span>
            🎉 {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert-box error">
            <span class="close-btn" onclick="this.parentElement.style.display='none';">&times;</span>
            ❌ {{ session('error') }}
        </div>
        @endif

        <div class="header-content">
            <div class="logo">Admin - Hệ Thống Quản Lý Bán Vé</div>
            <nav>
                <ul>
                    <li><a href="#">Trang Chủ</a></li>
                    <li><a href="#">Thống Kê</a></li>
                    <li><a href="#">Tài Khoản Admin</a></li>
                    <li><a href="#">Đăng Xuất</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
        <div class="main-content">
            <div class="sidebar">
                <ul>
                    <li><a href="/admin/home"><i class="icon">📊</i> Tổng Quan</a></li>
                    <li><a href="/admin/ticket"><i class="icon">🎫</i> Quản Lý Vé</a></li>
                    <li><a href="/admin/event"><i class="icon">🎭</i> Quản Lý Sự Kiện</a></li>
                    <li><a href="/admin/user"><i class="icon">👥</i> Quản Lý Người Dùng</a></li>
                    <li><a href="/admin/revenue"><i class="icon">💰</i> Quản Lý Doanh Thu</a></li>
                    <li><a href="/admin/report"><i class="icon">📝</i> Báo Cáo Chi Tiết</a></li>
                    <li><a href="/admin/chat"><i class="icon">💬</i> Chat Hỗ Trợ</a></li>
                    <li><a href="/admin/booking_manager"><i class="icon">📅</i> Quản Lý Đặt Chỗ</a></li>
                    <li><a href="/admin/setting"><i class="icon">⚙️</i> Cài Đặt Hệ Thống</a></li>
                    <li><a href="/admin/recycle_bin"><i class="icon">🗑️</i> Thùng Rác</a></li>

                </ul> 
            </div>
            @yield('content_admin')
        </div>
    </div>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let alerts = document.querySelectorAll('.alert-box');
        alerts.forEach(alert => {
            let audio = new Audio(alert.classList.contains('success') ? '/sounds/success.mp3' : '/sounds/error.mp3');
            audio.play();
        });
    });
</script>
</html>