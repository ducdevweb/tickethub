@extends('layout_login')
@section('title_login')
Đặt chỗ của bạn
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/booking.css') }}">
@endsection
@section('content_login')
<section id="my-booking">
    <div class="wrapper-booking">
        <div class="title-booking">
            <h3 class="name-booking">Đặt chỗ của tôi</h3>
            <div class="btn-booking">
                <input type="date" value="2025-03-16">
                <a href="#">Xem tất cả</a>
            </div>
        </div>
        <div class="content-booking">
            <div class="img-userbooking">
                <img src="/assets/img/user-avatar.jpg" alt="User Avatar">
            </div>
            <div class="infor-booking">
                <p>Khóa "BÍ MẬT VÂN TAY" - Hiểu Về Chính Mình</p>
                <p>Ngày: 16/03/2025</p>
                <p>Số lượng: 1 vé</p>
                <p>Tổng: 790,000 VND</p>
            </div>
            <div class="status">Đã hủy</div>
            <a href="#">Hủy</a>
        </div>
    </div>
</section>
@endsection