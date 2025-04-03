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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
    @yield('css')
    <title>@yield('title')</title>
</head>
<body>
    <div id="page-transition">
        <img src="/assets/img/logo.png" alt="Loading Logo" class="transition-logo">
        <div class="loading-bar"></div>
        <p class="loading-text">Đang tải...</p>
    </div>

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
    <div id="header">
        <div class="header-content">
            <div class="header-left">
                <a href="/">
                    <img class="logo" src="/assets/img/logo.png" alt="Logo">
                    <img class="logo-mobile" src="/assets/img/logo.png" alt="Logo Mobile">
                </a>
            </div>

            <div class="header-nav" id="header-nav">
                <a href="/ticket/music"><span class="text-nav">Vé âm nhạc</span></a>
                <a href="/ticket/workshop"><span class="text-nav">Vé hội thảo</span></a>
                <a href="/ticket/tour"><span class="text-nav">Vé tham quan</span></a>
            </div>

            <div class="header-right">
                <button class="mobile-menu-toggle" id="mobile-menu-toggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <div class="header-widget">
                    @if(Auth::check())
                    <div class="cart-icon">
                        <i class="fa fa-shopping-cart"></i>
                        <span class="cart-number">{{ $quantity }}</span>
                        @if(isset($carts) && count($carts) > 0)
                            <div class="mini-cart">
                                @foreach ($carts as $mini_cart)
                                <a class="product-mini">
                                    <img src="{{ $mini_cart->ticket->img_ticket }}" alt="Ticket">
                                    <div class="wrap-mini">
                                        <div class="name-mini">{{ $mini_cart->ticket->name_ticket }}</div>
                                        <p class="quantity-mini">
                                            @if ($mini_cart->ticket->sale_ticket > 0)
                                            {{ number_format($mini_cart->ticket->sale_ticket) }}đ x {{ number_format($mini_cart->quantity_cart) }}
                                            @else
                                            {{ number_format($mini_cart->ticket->price_ticket) }}đ x {{ number_format($mini_cart->quantity_cart) }}
                                            @endif
                                        </p>
                                    </div>
                                </a>
                                @endforeach
                                <hr>
                                <p class="total-mini"><b style="color: #444444;">Tổng:</b> {{ number_format($total) }}đ</p>
                                <div class="mini-action">
                                    <a href="/cart" class="mini-see">Xem giỏ hàng</a>
                                    <a href="/cart" class="mini-checkout">Thanh toán</a>
                                </div>
                            </div>
                        @else
                            <div class="mini-cart">
                                Chưa có sản phẩm
                            </div>
                        @endif
                    </div>
                    <div class="account-menu">
                        <div class="account-info" id="account-info">
                            <img src="{{ asset($user->img) }}" alt="Avatar" class="account-avatar">
                            <span class="account-name">Tài khoản của tôi</span>
                            <i class="ti-angle-down account-icon" id="account-icon"></i>
                        </div>
                        <div class="menu-account" id="menu-account">
                            <ul>
                                <a class="li-navb" href="/booking"><i style="color: #40A126;" class="ti-bookmark"></i> Đặt chỗ của tôi</a>
                                <a class="li-navb" href="/comment"><i style="color: #40A126;" class="ti-star"></i> Đánh giá</a>
                                <a class="li-navb" href="/favourite"><i style="color: #40A126;" class="ti-heart"></i> Ưa thích</a>
                                <a class="li-navb" href="/messages"><i style="color: #40A126;" class="ti-comments"></i> Tin nhắn</a>
                                <a class="li-navb" href="/order"><i style="color: #40A126;" class="ti-shopping-cart"></i> Đơn hàng</a>
                                <a class="li-navb" href="/account"><i style="color: #40A126;" class="ti-user"></i> Trang cá nhân</a>
                                <a class="li-navb" href="/logout"><i style="color: #40A126;" class="ti-power-off"></i> Đăng xuất</a>
                            </ul> 
                        </div>
                    </div>
                    @else
                    <div class="login">
                        <a href="/pageLogin"><i class="icon-login"></i>Đăng nhập</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="mobile-nav" id="mobile-nav">
        <button class="mobile-nav-close" id="mobile-nav-close">×</button>
        <ul>
            <li><a href="/ticket/music"><span class="text-nav">Vé âm nhạc</span></a></li>
            <li><a href="/ticket/workshop"><span class="text-nav">Vé hội thảo</span></a></li>
            <li><a href="/ticket/tour"><span class="text-nav">Vé tham quan</span></a></li>
        </ul>
        @if(Auth::check())
        <div class="mobile-account-menu">
            <div class="mobile-account-info" id="mobile-account-info">
                <img src="{{ asset($user->img) }}" alt="Avatar" class="account-avatar">
                <span class="account-name">Tài khoản</span>
                <i class="ti-angle-down account-icon"></i>
            </div>
            <div class="menu-account" id="mobile-menu-account">
                <ul>
                    <a class="li-navb" href="/booking"><i style="color: #40A126;" class="ti-bookmark"></i> Đặt chỗ của tôi</a>
                    <a class="li-navb" href="/comment"><i style="color: #40A126;" class="ti-star"></i> Đánh giá</a>
                    <a class="li-navb" href="/favourite"><i style="color: #40A126;" class="ti-heart"></i> Ưa thích</a>
                    <a class="li-navb" href="/messages"><i style="color: #40A126;" class="ti-comments"></i> Tin nhắn</a>
                    <a class="li-navb" href="/order"><i style="color: #40A126;" class="ti-shopping-cart"></i> Đơn hàng</a>
                    <a class="li-navb" href="/account"><i style="color: #40A126;" class="ti-user"></i> Trang cá nhân</a>
                    <a class="li-navb" href="/logout"><i style="color: #40A126;" class="ti-power-off"></i> Đăng xuất</a>
                </ul>
            </div>
        </div>
        <div class="mobile-cart-icon" id="mobile-cart-icon">
            <i class="fa fa-shopping-cart"></i>
            <span class="cart-number">{{ $quantity }}</span>
            @if(isset($carts) && count($carts) > 0)
                <div class="mini-cart" id="mobile-mini-cart">
                    @foreach ($carts as $mini_cart)
                    <a class="product-mini">
                        <img src="{{ $mini_cart->ticket->img_ticket }}" alt="Ticket">
                        <div class="wrap-mini">
                            <div class="name-mini">{{ $mini_cart->ticket->name_ticket }}</div>
                            <p class="quantity-mini">
                                @if ($mini_cart->ticket->sale_ticket > 0)
                                {{ number_format($mini_cart->ticket->sale_ticket) }}đ x {{ number_format($mini_cart->quantity_cart) }}
                                @else
                                {{ number_format($mini_cart->ticket->price_ticket) }}đ x {{ number_format($mini_cart->quantity_cart) }}
                                @endif
                            </p>
                        </div>
                    </a>
                    @endforeach
                    <hr>
                    <p class="total-mini"><b style="color: #444444;">Tổng:</b> {{ number_format($total) }}đ</p>
                    <div class="mini-action">
                        <a href="/cart" class="mini-see">Xem giỏ hàng</a>
                        <a href="/checkout" class="mini-checkout">Thanh toán</a>
                    </div>
                </div>
            @else
                <div class="mini-cart" id="mobile-mini-cart">
                    Chưa có sản phẩm
                </div>
            @endif
        </div>
        @endif
    </div>
    <div class="overlay" id="overlay"></div>

    @yield('content')

    <!-- Footer -->
    <div id="footer">
        <div class="footer-ticket">
            <img src="/assets/img/logo.png" alt="Logo">
            <p>Dễ dàng tìm kiếm và mua vé sự kiện âm nhạc, kịch nói, phim rạp, thể thao, voucher & tour du lịch, khách sạn.</p>
        </div>
        <div class="about-me">
            <h3>Về chúng tôi</h3>
            <p>> Chính sách, Điều kiện, Điều khoản – FAQ</p>
            <p>> Phương thức thanh toán</p>
            <p>> Cơ chế giải quyết tranh chấp, khiếu nại</p>
            <p>> Chính sách kiểm hàng, đổi trả và hoàn tiền</p>
            <p>> Chính sách bảo mật thông tin</p>
            <p>> Điều kiện vận chuyển và giao nhận</p>
        </div>
        <div class="for-company">
            <h3>Công ty TNHH Tickethub</h3>
            <p>📞 Phone: 0899934886</p>
            <p>📧 E-Mail: office@tickethub.vn</p>
            <p>📜 Giấy chứng nhận đăng ký doanh nghiệp số: 0601275351, cấp lần đầu ngày 19/12/2024 bởi Sở Kế hoạch và Đầu tư tỉnh Nam Định.</p>
            <p>🏠 Đại diện theo pháp luật: Trần Văn Cương. Địa chỉ: Nghĩa Trung, Nghĩa Hưng, Nam Định.</p>
        </div>
    </div>

    <script src="{{ asset('assets/js/style.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
</body>
</html>