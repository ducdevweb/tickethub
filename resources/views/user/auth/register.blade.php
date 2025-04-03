@extends('layout')
@section('title')
Đăng ký
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
@endsection
@section('content')
<div id="register">
    <div class="login-head">
        <h3>ĐĂNG NHẬP</h3>
        <div class="bg-icon">
            <img src="/assets/img/logo.png" alt="">
        </div>
    </div>
    <div class="bnt-log">
        <a href="/pageLogin" class="btn-login"><span>Đăng nhập</span></a>
        <a href="/register" class="btn-out"><span class="text-login">Đăng ký</span></a>
    </div>
    <div class="write-infor">
        <form action="{{ route('checkRegister') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-input">
                <i class="ti-user icon-uslogin"></i>
                <input required type="text" class="input-login user-login" name="name" placeholder="Tên đăng nhập">
            </div>

            <div class="form-input">
                <i class="ti-lock icon-uslogin"></i>
                <input required type="password" class="input-login user-login" name="password" placeholder="Mật khẩu">
            </div>

            <div class="form-input">
                <i class="ti-lock icon-uslogin"></i>
                <input required type="password" class="input-login user-login" name="password_confirmation" placeholder="Nhập lại mật khẩu">
            </div>

            <div class="form-input">
                <i class="ti-email icon-uslogin"></i>
                <input required type="email" class="input-login user-login" name="email" placeholder="Địa chỉ email">
            </div>

            <div class="form-input">
                <i class="ti-pencil icon-uslogin"></i>
                <input required type="text" class="input-login user-login" name="phone" placeholder="Số điện thoại">
            </div>

            <div class="form-input">
                <i class="ti-image icon-uslogin"></i>
                <input type="file" class="input-login user-login" name="img">
            </div>

            <div>
                <input type="checkbox" required> <span class="text-check">Tôi đồng ý với <a href="" style="text-decoration: none;color: #40a126;"> chính sách quyền riêng tư</a></span>
            </div>

            <button type="submit">Đăng ký</button>
        </form>

    </div>
</div>
@endsection