@extends('layout')
@section('title', 'Thanh Toán')
@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/checkout.css') }}">
@endsection
@section('content')
<div id="checkout">
    <div class="heading">
        <h1>THANH TOÁN</h1>
        <h4>TicketHub > Thanh toán</h4>
    </div>

    <div class="content-checkout">
        <form id="payment-form" method="POST" action="{{ route('checkout.process') }}">
            @csrf
            @php
            $user = Auth::user();
            @endphp
            <div class="form-checkout">
                <div class="section">
                    <h2>1. Thông tin liên hệ</h2>
                    <input type="email" id="email" name="email" placeholder="Địa chỉ email" value="{{ old('email', $user->email ?? '') }}" required>
                    @error('email')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="section">
                    <h2>2. Địa chỉ thanh toán</h2>
                    <div class="row">
                        <input type="text" name="first_name" placeholder="Tên" value="{{ old('first_name') }}" required>
                        <input type="text" name="last_name" placeholder="Họ" value="{{ old('last_name') }}" required>
                    </div>
                    <input type="text" name="address" placeholder="Địa chỉ" value="{{ old('address', $user->address ?? '') }}" required>

                    <div class="row">
                        <select id="city" name="city" required>
                            <option value="">Chọn tỉnh/thành phố</option>
                        </select>
                        <select id="district" name="district" required>
                            <option value="">Chọn quận/huyện</option>
                        </select>
                    </div>

                    <input type="text" name="phone" placeholder="Số điện thoại" value="{{ old('phone', $user->phone ?? '') }}" required>
                </div>

                <div class="section">
                    <h2>3. Tùy chọn thanh toán</h2>
                    <div class="payment-method">
                        <input type="radio" name="payment" id="bank" value="bank" class="input-qr" checked>
                        <label for="bank">Chuyển khoản ngân hàng (Quét mã QR)</label>
                        <img src="/assets/img/vnpay-logo_64dc3da9d7a11.jpg" alt="Danh sách ngân hàng">
                    </div>
                </div>
            </div>

            <div class="order-summary">
                <h2 style="font-size: 15px; color: #707070;">Tóm tắt đơn hàng</h2>
                <div class="scroll">
                    @php $total = 0; @endphp
                    @foreach ($checkouts as $checkout)
                    <input type="hidden" name="selected_carts[]" value="{{ $checkout->id_cart }}">
                    <div class="order-item">
                        <div class="order-img">
                            <img src="{{ asset($checkout->ticket->img_ticket) }}" width="48px" height="48px" alt="">
                            <span>{{ $checkout->quantity_cart }}</span>
                        </div>
                        <div class="order-infor">
                            <div style="color: #707070; font-size: 13.125px;">{{ $checkout->ticket->name_ticket }}</div>
                            <p class="order-price">Giá vé:
                                @if ($checkout->ticket->sale_ticket > 0)
                                {{ number_format($checkout->ticket->sale_ticket) }}đ
                                @php $total += $checkout->ticket->sale_ticket * $checkout->quantity_cart; @endphp
                                @else
                                {{ number_format($checkout->ticket->price_ticket) }}đ
                                @php $total += $checkout->ticket->price_ticket * $checkout->quantity_cart; @endphp
                                @endif
                            </p>
                            <p class="order-describe">{{ $checkout->ticket->description_ticket }}</p>
                        </div>
                        <div class="order-provisional">
                            <b style="color: #707070; font-size: 13.125px;">
                                {{ number_format($checkout->total_cart) }}đ
                            </b>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="coupon-container">
                    <input type="text" placeholder="Nhập mã giảm giá" id="coupon" name="coupon">
                    <button type="button" class="coupon-btn">Áp dụng</button>
                </div>
                <hr style="margin-top: 20px;">
                <div class="total" style="margin: 20px 0;">
                    <p><strong>Tổng:</strong> <span id="total-amount">{{ number_format($total) }}đ</span></p>
                </div>
                <hr>
                <button type="submit" class="btn-submit">Đặt Hàng</button>
            </div>
        </form>
    </div>
</div>
<script src="/assets/js/checkout.js"></script>
@endsection