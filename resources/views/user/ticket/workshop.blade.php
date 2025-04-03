@extends('layout')

@section('title')
Vé âm nhạc
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/ticket_workshop.css') }}">
@endsection
@section('content')
<div id="main-workshop">
    <div class="heading">
        <h1>Giỏ hàng</h1>
        <h4>TicketHub > Sản phẩm > Vé {{ $type }}</h4>
    </div>

    <div class="workshop-content">
        <div class="workshop-ticket">
            <div class="workshop-product">
                @foreach ($workshop_ticket as $ticket)
                <div class="workshop-product-img">
                    @php
                    $sale = (int) (($ticket->price_ticket - $ticket->sale_ticket) / $ticket->price_ticket * 100);
                    @endphp
                    @if ($ticket->sale_ticket > 0)
                    <div class="sale">Giảm giá {{ $sale }}%</div>
                    @endif
                    <a href="{{ route('ticket.detail', $ticket->id_ticket) }}" style="width: 100%;">
                        <img src="{{ asset($ticket->img_ticket) }}" alt="{{ $ticket->name_ticket }}">
                    </a>
                    <p class="name-ticket">{{ $ticket->name_ticket }}</p>
                    <p class="price-ticket">
                        @if ($ticket->sale_ticket > 0)
                        <del>{{ number_format($ticket->price_ticket) }} ₫</del>
                        <span class="sale-price">{{ number_format($ticket->sale_ticket) }} ₫</span>
                        @else
                        {{ number_format($ticket->price_ticket) }} ₫
                        @endif
                    </p>

                    <a href="/addCart/{{ $ticket->id_ticket }}" class="btn-ticket">
                        <h4><i class="fa fa-shopping-cart"></i> Thêm vào giỏ hàng</h4>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        <div class="sidebar">
            <h2 style="font-size: 22px; margin-bottom: 25px; font-weight: 500;">Bạn tìm gì hôm nay?</h2>
            <form action="{{ route('search') }}" method="GET" class="sidebar-form">
                <input type="text" name="search" class="sidebar-search" placeholder="Tìm sản phẩm...">
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>
            <h2 style="font-size: 22px; margin-bottom: 25px; font-weight: 500;">Danh mục sản phẩm</h2>
            <form action="" method="GET" class="sidebar-form2">
                <div class="dropdown">
                    <div class="dropdown-toggle">
                        Chọn loại vé
                        <span>▼</span>
                    </div>
                    <ul class="dropdown-menu">
                        <li><a style="text-decoration: none; color: #333333;" href="/ticket/music">Âm nhạc</a></li>
                        <li><a style="text-decoration: none; color: #333333;" href="/ticket/workshop">Hội thảo</a></li>
                        <li><a style="text-decoration: none; color: #333333;" href="/ticket/tour">Tham quan</a></li>
                    </ul>

                </div>
            </form>
            <h2 style="font-size: 22px; margin: 85px 0 20px 0; font-weight: 500;">Có thể bạn quan tâm?</h2>
            <div class="care-about">
                <ul class="care-about-list">
                    @foreach ($siderBar as $sd)
                    <li>
                        <a href="/ticket/{{ $sd->id_ticket }}">
                            <img src="{{ $sd->img_ticket }}" alt="">
                        </a>
                        <div class="infor-care">
                            <div class="name-care">{{ $sd->name_ticket }}</div>
                            <div class="price-care">
                                @if ($sd->sale_ticket > 0)
                                <del>{{ number_format($sd->price_ticket) }} ₫</del>
                                <span class="sale-price">{{ number_format($sd->sale_ticket) }} ₫</span>
                                @else
                                {{ number_format($sd->price_ticket) }} ₫
                                @endif
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
<script src="/assets/js/ticket.js"></script>
@endsection