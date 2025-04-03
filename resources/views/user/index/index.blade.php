@extends('layout')

@section('title')
Trang chủ Tickethub
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/index.css') }}">
@endsection
@section('content')
<div id="banner">
    <div class="banner-main">
        <img id="banner1" class="banner-img" src="/assets/img/how_to_promote_live_events_blog_2022_1.jpg" alt="Banner 1">
        <img id="banner2" class="banner-img" src="/assets/img/large_image_4e2c08167b.png" alt="Banner 2" style="display: none;">
        <div class="banner-bottom">
            <div class="banner-tab">
                <ul class="tab-list">
                    <li id="all-tab" class="tab active">
                        <a href="#">
                            <p class="tab-text active">Tất cả</p>
                        </a>
                    </li>
                    <li id="service-tab" class="tab">
                        <a href="#">
                            <p class="tab-text">Dịch vụ</p>
                        </a>
                    </li>
                    <li id="tab-hotel" class="tab">
                        <a href="#">
                            <p class="tab-text">Khách sạn</p>
                        </a>
                    </li>
                    <li id="tab-event" class="tab">
                        <a href="#">
                            <p class="tab-text">Sự kiện</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="banner-content">
            <div class="text-banner">
                <p>Dễ Dàng Tìm Kiếm<span id="text-1" class="mt-l" style="border-right: 2px solid white;"></span></p>
            </div>
            <p class="text-banner2">Khám phá vô vàn các hoạt động thú vị mà bạn chưa từng biết!</p>
            <a class="banner-search" href="">Xem tất cả các vé</a>
            <div class="banner-categoty">
                <div class="category-label">Hoặc xem các danh mục nổi bật:</div>
                <ul class="cate-list">
                    <li class="cate-filter"><i class="fas fa-american-sign-language-interpreting icon-cate"></i>Dịch vụ</li>
                    <li class="cate-filter"><i class="fas fa-music icon-cate"></i>Sự kiện</li>
                    <li class="cate-filter"><i class="fas fa-paper-plane icon-cate"></i>Tham quan</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div id="filter">
    <div class="filter-product">
        <form action="" class="form-filter">
            <input class="input-filter" type="text" placeholder="Bạn đang tìm kiếm?">
            <span class="divider">|</span>
            <select class="input-filter">
                <option value="">Tất cả vị trí</option>
                <option value="dalat">Đà Lạt</option>
                <option value="nhatrang">Nha Trang</option>
            </select>
            <span class="divider">|</span>
            <select class="input-filter">
                <option>Tất Cả Danh Mục</option>
                <option>Ăn uống</option>
                <option>Khách sạn</option>
            </select>
            <span class="divider">|</span>
            <button type="submit" class="button-filter">Tìm kiếm</button>
        </form>
    </div>
</div>

<div id="trend">
    <div class="trend-head">Xu Hướng</div>
    <div class="underline"></div>
    <div class="trend-content">
        <a href="" class="trend-list trend-food"><i class="fas fa-glass-martini"></i>
            <p class="trend-text">Ăn Uống</p>
        </a>
        <a href="" class="trend-list trend-service"><i class="fas fa-american-sign-language-interpreting"></i>
            <p class="trend-text">Dịch Vụ</p>
        </a>
        <a href="" class="trend-list trend-event"><i class="fas fa-music"></i>
            <p class="trend-text">Sự Kiện</p>
        </a>
        <a href="" class="trend-list trend-tour"><i class="fas fa-paper-plane"></i>
            <p class="trend-text">Tham Quan</p>
        </a>
    </div>
</div>

<div id="propose">
    <div class="propose-head">Được Đề Xuất</div>
    <div class="propose-line"></div>
    <div class="head-sec">Bình Chọn Bởi Người Dùng</div>
    <div class="propose-wrapper">
        <div class="propose-content">
            <a href="" class="propose-img">
                <img src="/assets/img/hanoi.jpg" alt="Hà Nội">
                <div class="title-propose">
                    <h3>Hà Nội</h3>
                    <p>Thủ đô ngàn năm văn hiến</p>
                </div>
            </a>
            <a href="" class="propose-img">
                <img src="/assets/img/dalat1.jpg" alt="Đà Lạt">
                <div class="title-propose">
                    <h3>Đà Lạt</h3>
                    <p>Thành phố mộng mơ của các cặp đôi</p>
                </div>
            </a>
            <a href="" class="propose-img">
                <img src="/assets/img/sapa.jpg" alt="Sapa">
                <div class="title-propose">
                    <h3>Sapa</h3>
                    <p>Thiên đường săn mây tuyệt đẹp</p>
                </div>
            </a>
            <a href="" class="propose-img">
                <img src="/assets/img/nhatrang.jpg" alt="Nha Trang">
                <div class="title-propose">
                    <h3>Nha Trang</h3>
                    <p>Thiên đường biển xanh cát trắng</p>
                </div>
            </a>
            <a href="" class="propose-img">
                <img src="/assets/img/hue.jpg" alt="Huế">
                <div class="title-propose">
                    <h3>Huế</h3>
                    <p>Cố đô mang vẻ đẹp hoài cổ</p>
                </div>
            </a>
            <a href="" class="propose-img">
                <img src="/assets/img/hoian.jpg" alt="Hội An">
                <div class="title-propose">
                    <h3>Hội An</h3>
                    <p>Phố cổ lung linh đèn lồng</p>
                </div>
            </a>
        </div>
    </div>
    <div class="dots">
        <span class="dot active" data-page="0"></span>
        <span class="dot" data-page="1"></span>
    </div>
</div>

<div class="background-ticket">
    <div class="background-content">
        <p class="background-content1">An toàn khi mua vé</p>
        <p class="background-content2">Nhanh chóng tìm kiếm đối tác bán vé sự kiện uy tín và thanh toán dễ dàng tại Tickethub.</p>
        <button class="background-content3">Tìm Vé</button>
    </div>
</div>

<div id="location">
    <div class="location-content">
        <div class="location-text">
            <h2>Tìm Quanh Đây</h2>
            <h4>Vô vàn hoạt động thú vị ở gần bạn, không <br> lo về khoảng cách nữa.</h4>
            <button>Khám Phá Ngay</button>
        </div>
        <div class="location-img">
            <a href=""><img src="/assets/img/dalat3.jpeg" alt="Đà Lạt"></a>
            <a href=""><img src="/assets/img/danang.jpg" alt="Đà Nẵng"></a>
            <a href=""><img src="/assets/img/hanoi.jpg" alt="Hà Nội"></a>
            <a href=""><img src="/assets/img/hcm.jpg" alt="Hồ Chí Minh"></a>
        </div>
    </div>
</div>

<div id="introduce">
    <div class="introduce-content">
        <div class="introduce-text">
            <h3>Tickethub hoạt động như thế nào?</h3>
            <div class="widget">
                <div class="feature">
                    <div class="icon-introduce">
                        <img src="/assets/img/footer-icon3.png" alt="Xác thực người dùng">
                    </div>
                    <div class="feature-text">
                        <h4>Xác Thực Người Dùng</h4>
                        <p>Nhà tổ chức sự kiện và Người bán luôn được xác thực danh tính.</p>
                    </div>
                </div>
                <div class="feature">
                    <div class="icon-introduce">
                        <img src="/assets/img/Calendar.png" alt="Giao Dịch An Toàn">
                    </div>
                    <div class="feature-text">
                        <h4>Giao Dịch An Toàn</h4>
                        <p>Tất cả giao dịch đều được đảm bảo bởi Tickethub.</p>
                    </div>
                </div>
                <div class="feature">
                    <div class="icon-introduce">
                        <img src="/assets/img/Calendar.png" alt="Mua bán vé dễ dàng">
                    </div>
                    <div class="feature-text">
                        <h4>Mua bán vé dễ dàng</h4>
                        <p>Nhà tổ chức sự kiện sẽ được Tickethub đồng hành với các chương trình quảng cáo tối ưu.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="introduce-img">
            <img src="/assets/img/introduce-img.svg" alt="Minh họa">
        </div>
    </div>
</div>
<script src="/assets/js/index.js"></script>
@endsection