<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="/assets/img/logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="/assets/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.5.5/css/simple-line-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/login-header.css">
    @yield('css')
    <title>@yield('title_login')</title>

</head>
<body>
    
@if (session()->has('error'))
    <div class="custom-alert custom-alert-error" role="alert">
        <div class="alert-content">
            <span class="alert-icon"><i class="fas fa-exclamation-triangle"></i></span>
            <span class="alert-message">{{ session('error') }}</span>
            <button class="alert-close" onclick="this.parentElement.parentElement.classList.add('closing'); setTimeout(() => this.parentElement.parentElement.style.display='none', 500);">×</button>
        </div>
    </div>
@endif
@if (session()->has('success'))
    <div class="custom-alert custom-alert-success" role="alert">
        <div class="alert-content">
            <span class="alert-icon"><i class="fas fa-check-circle"></i></span>
            <span class="alert-message">{{ session('success') }}</span>
            <button class="alert-close" onclick="this.parentElement.parentElement.classList.add('closing'); setTimeout(() => this.parentElement.parentElement.style.display='none', 500);">×</button>
        </div>
    </div>
@endif
<div id="page-transition">
    <img src="/assets/img/logo.png" alt="Loading Logo" class="transition-logo">
    <div class="loading-bar"></div>
    <p class="loading-text">Đang tải...</p>
</div>

<div id="header-login-login">
    <div class="nagivation-bar">
        <div class="logo-navb">
            <a href="/"><img src="/assets/img/logo.png" alt=""></a>
        </div>
        <div class="main-heading">
            <h3 class="style-heading">Đề mục chính</h3>
            <ul>
                <li class="li-navb"><a href="/booking"><i style="color: #259a04;" class="ti-bookmark"></i> Đặt chỗ của tôi</a></li>
                <li class="li-navb"><a href="/messages"><i style="color: #259a04;" class="ti-star"></i> Tin nhắn</a></li>
            </ul>
            <h3 class="style-heading">Mục lưu trữ</h3>
            <ul>
                <li class="li-navb"><a href="/comment"><i style="color: #259a04;" class="ti-bookmark"></i> Đánh giá</a></li>
                <li class="li-navb"><a href="/favourite"><i style="color: #259a04;" class="ti-star"></i> Đánh dấu ưa thích</a></li>
            </ul>
            <h3 class="style-heading">Mục cá nhân</h3>
            <ul>
                <li class="li-navb"><a href="/account"><i style="color: #259a04;" class="ti-user"></i> Trang cá nhân</a></li>
                <li class="li-navb"><a href="/order"><i style="color: #259a04;" class="ti-shopping-cart"></i> Đơn hàng</a></li>
                <li class="li-navb"><a href="/login"><i style="color: #259a04;" class="ti-power-off"></i> Đăng xuất</a></li>
            </ul>
        </div>
    </div>
    <div class="content-wrapper">
        <!-- Thêm nút menu toggle -->
        <button class="menu-toggle" id="menu-toggle">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <div class="content-bar">
            <div id="header-login">
                <div class="header-login-content">
                    <div class="header-login-right">
                        <div class="header-login-nav" id="header-login-nav">
                            <a href="/music"><span class="text-nav">Vé âm nhạc</span></a>
                            <a href="/workshop"><span class="text-nav">Vé hội thảo</span></a>
                            <a href="/tour"><span class="text-nav">Vé tham quan</span></a>
                        </div>
                    </div>
                    <div class="header-login-left">
                        <div class="header-login-widget">
                            <div class="cart-icon">
                                <i class="fa fa-shopping-cart fa-rotate-360"></i>
                                <span class="cart-number">0</span>
                                <div class="mini-cart">
                                    <a class="product-mini">
                                        <img src="/assets/img/care-about.png" alt="">
                                        <div class="wrap-mini">
                                            <div class="name-mini">Khóa "BÍ MẬT VÂN TAY" - Hiểu Về Chính Mình</div>
                                            <p class="quantity-mini">1 x 790,000 VND</p>
                                        </div>
                                    </a>
                                    <hr>
                                    <p class="total-mini"><b style="color: #444444;">Tổng:</b> 790,000đ</p>
                                    <div class="mini-action">
                                        <a href="" class="mini-see">Xem giỏ hàng</a>
                                        <a href="" class="mini-checkout">Thanh toán</a>
                                    </div>
                                </div>
                            </div>
                            @if (Auth::check())
                            <div class="account-menu">
                                <div class="account-info" id="account-info">
                                    <img src="{{asset(Auth::user()->img)}}" alt="Avatar" class="account-avatar">
                                    <span class="account-name">Tài khoản của tôi</span>
                                    <i class="ti-angle-down account-icon" id="account-icon"></i>
                                </div>
                                <div class="menu-account" id="menu-account">
                                    <ul>
                                        <li><a href="/booking"><i style="color: #40A126;" class="ti-bookmark"></i> Đặt chỗ của tôi</a></li>
                                        <li><a href="/comment"><i style="color: #40A126;" class="ti-star"></i> Đánh giá</a></li>
                                        <li><a href="/favourite"><i style="color: #40A126;" class="ti-heart"></i> Ưa thích</a></li>
                                        <li><a href="/messages"><i style="color: #40A126;" class="ti-comments"></i> Tin nhắn</a></li>
                                        <li><a href="/order"><i style="color: #40A126;" class="ti-shopping-cart"></i>Đơn hàng</a></li>
                                        <li><a href="/account"><i style="color: #40A126;" class="ti-user"></i> Trang cá nhân</a></li>
                                        <li><a href="/logout"><i style="color: #40A126;" class="ti-power-off"></i> Đăng xuất</a></li>
                                    </ul>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="heading-login">
            <div><a href="">Home</a> > <a href="">Bảng điều khiển</a></div>
        </div>
        <div id="content-section">
            @yield('content_login')
        </div>
    </div>
</div>

<script src="{{ asset('assets/js/style.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const menuToggle = document.getElementById('menu-toggle');
        const navigationBar = document.querySelector('.nagivation-bar');

        menuToggle.addEventListener('click', function() {
            navigationBar.classList.toggle('active');
            menuToggle.classList.toggle('active');
        });

        // Đóng menu khi nhấp ra ngoài
        document.addEventListener('click', function(event) {
            if (!navigationBar.contains(event.target) && !menuToggle.contains(event.target)) {
                navigationBar.classList.remove('active');
                menuToggle.classList.remove('active');
            }
        });

        // Toggle menu tài khoản
        const accountInfo = document.getElementById('account-info');
        const menuAccount = document.getElementById('menu-account');
        if (accountInfo && menuAccount) {
            accountInfo.addEventListener('click', function() {
                menuAccount.style.display = menuAccount.style.display === 'block' ? 'none' : 'block';
            });

            document.addEventListener('click', function(event) {
                if (!accountInfo.contains(event.target) && !menuAccount.contains(event.target)) {
                    menuAccount.style.display = 'none';
                }
            });
        }
    });
</script>
</body>
</html>