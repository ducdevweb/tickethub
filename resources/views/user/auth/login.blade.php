@extends('layout')
@section('title')
Đăng nhập
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
@endsection
@section('content')
<div id="login">
        <div class="login-head">
            <h3>ĐĂNG NHẬP</h3>
            <div class="bg-icon">
            <img src="/assets/img/logo.png" alt="">
        </div>
        </div>
        <div class="bnt-log">
            <a href="/pageLogin" class="btn-login"><span class="text-login">Đăng nhập</span></a>
            <a href="/register" class="btn-out"><span class="">Đăng ký</span></a>
        </div>
        <div class="write-infor write-login">
            <form action="{{ route('checkLogin') }}" method="post">
                @csrf
                <div class="form-input">
                    <i class="ti-user icon-uslogin"></i><input type="text" class="input-login user-login" name="email" id="" placeholder="Email của bạn" required>
                </div>
                
                <div class="form-input">
                    <i class="ti-lock icon-uslogin"></i></i><input type="password" class="input-login user-login" name="password" id="" placeholder="Vui lòng nhập mật khẩu" required>
                </div>
                <button type="submit">Đăng nhập</button>
            </form>
        </div>
        <div class="social-login">
                <p>Hoặc đăng nhập bằng:</p>
                <a href="{{ route('auth.google') }}" class="btn-google">
                    <i class="fab fa-google"></i> Google
                </a>
            </div>
    </div>
@endsection