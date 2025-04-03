@extends('layout')

@section('title')
Giỏ hàng
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/cart.css') }}">

@endsection
@section('content')
<div id="cart">
    <div class="heading">
        <h1>GIỎ HÀNG</h1>
        <h4>TicketHub > Giỏ hàng</h4>
    </div>
    <div class="wrap-cart">
        <form class="cart-inforItems" id="checkout-form" action="{{ route('checkout') }}" method="GET">
            @csrf
            <table class="table-cart">
                <thead>
                    <tr class="table-head">
                        <th class="checkbox-column"><input type="checkbox" id="select-all" onchange="toggleSelectAll()"> Chọn</th>
                        <th class="product-column">Sản phẩm</th>
                        <th class="total-column">Tổng</th>
                    </tr>
                </thead>
                @if($carts && count($carts) > 0)
                <tbody class="table-body">
                    @foreach ($carts as $cart)
                    <tr data-cart-id="{{ $cart->id_cart }}">
                        <td class="checkbox-column">
                            <input type="checkbox" name="selected_carts[]" value="{{ $cart->id_cart }}" class="cart-checkbox" onchange="updateCartTotal()">
                        </td>
                        <td class="td-img">
                            <div class="product-details">
                                <img src="{{ asset($cart->ticket->img_ticket) }}" alt="{{ $cart->ticket->name_ticket }}">
                                <div class="td-text">
                                    <p class="td-text1">
                                        <a href="/ticket/{{ $cart->ticket->id_ticket }}">{{ $cart->ticket->name_ticket }}</a>
                                    </p>
                                    <div class="price-quantity">
                                        @if ($cart->ticket->sale_ticket > 0)
                                        <span class="price">
                                            {{ number_format($cart->ticket->sale_ticket) }}đ x <span class="quantity_cart">{{ $cart->quantity_cart }}</span>
                                        </span>
                                        @else
                                        <span class="price">
                                            {{ number_format($cart->ticket->price_ticket) }}đ x <span class="quantity_cart">{{ $cart->quantity_cart }}</span>
                                        </span>
                                        @endif
                                        <div class="quantity" data-cart-id="{{ $cart->id_cart }}">
                                            <button type="button" class="btn-minus">-</button>
                                            <input type="number" class="table-input" name="update_cart" value="{{ $cart->quantity_cart }}" min="1">
                                            <button type="button" class="btn-plus">+</button>
                                        </div>
                                    </div>
                                    <p class="td-text2">{{ $cart->ticket->description_ticket }}</p>
                                    <p class="table-btn"><a href="{{ route('cart.del', $cart->id_cart) }}">Xóa sản phẩm</a></p>
                                </div>
                            </div>
                        </td>
                        <td class="td-total" data-total="{{ $cart->total_cart }}">{{ number_format($cart->total_cart) }} đ</td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <hr>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                @else
                <tbody>
                    <tr>
                        <td colspan="3">Giỏ hàng của bạn đang trống!</td>
                    </tr>
                </tbody>
                @endif
            </table>
        </form>

        <div class="cart-totalItem">
            <p class="mt-bt">Cộng giỏ hàng</p>
            <hr>
            <div class="mt-10 provisional">
                <b>Tạm tính</b>
                <p id="provisional-total">{{ number_format($carts->sum('total_cart')) }}đ</p>
            </div>
            <hr>
            <div class="mt-10 cart-total">
                <b>Tổng tiền</b>
                <p id="cart-total">{{ number_format($carts->sum('total_cart')) }}đ</p>
            </div>
            <button type="button" class="btn-checkout">Thanh Toán</button>
        </div>
    </div>
</div>

<script src="/assets/js/cart.js"></script>
@endsection