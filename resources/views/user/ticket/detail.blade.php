@extends('layout')
@section('title')
Chi tiết {{ $ticket->name_ticket }}
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/detail_ticket.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/ticket_workshop.css') }}">
@endsection
@section('content')

<div id="detail-ticket">
    <div class="banner-detail">
        <div class="location-detail">
            <div class="logo-detail">
                <img src="/assets/img/logo.png" alt="Tickethub">
            </div>
            <div class="address-detail">
                <h2>Tickethub</h2>
                <p><i class="fa-solid fa-location-dot"></i> Hà Nội, Việt Nam</p>
                <p><i class="fa-solid fa-phone"></i> <span class="phone">0899934886</span></p>
                <p><i class="fa-solid fa-envelope"></i> office@tickethub.vn</p>
                <p class="no-rating">Chưa có đánh giá!</p>
            </div>
        </div>
        <div class="banner-mini">
            <img src="/assets/img/trend3.jpg" alt="Concert">
        </div>
    </div>
    <div class="detail-product">
        <div class="infor-detail">
            <div class="detail-img">
                <img src="{{ $ticket->img_ticket }}" id="main-image" alt="">
            </div>
            <div class="detail-text">
                <h1 class="name-detail">{{ $ticket->name_ticket }}</h1>
                <div class="price-detail">
                    @if ($ticket->sale_ticket > 0)
                    <del style="color: red; margin-right: 10px">{{ number_format($ticket->price_ticket) }}đ</del>
                    <span>{{ number_format($ticket->sale_ticket) }}đ</span>
                    @else
                    <span>{{ number_format($ticket->price_ticket) }}đ</span>
                    @endif
                </div>
                <hr style="margin-bottom: 20px;">
                <p class="detail-content">{{ $ticket->description_ticket }}</p>
                <form action="{{ route('addCart', $ticket->id_ticket) }}" method="post">
                    @csrf
                    <div class="detail-action">
                        <div class="detail-input">
                            <button class="detail-minus">-</button>
                            <input type="number" class="table-input" name="quantity_detail" value="1" min="1">
                            <button class="detail-plus">+</button>
                        </div>
                        <div class="addcart">
                            <button type="submit">Thêm vào giỏ hàng</button>
                        </div>
                    </div>
                </form>
                <div class="detail-cate">
                    <div class="detail-cate-text">
                        <b style="color: #40A216;">Danh mục:</b> {{ $cate->name_cate ?? "Không có danh mục" }}
                    </div>
                    <div class="detail-fvr">
                        <a href="/favourite/{{$ticket->id_ticket }}"><i class="fas fa-heart icon"></i></a>
                    </div>
                </div>
                @if ($ticket->id_event && $ticket->event)
                <div class="detail-event">
                    <b style="color: #40A216;">Sự kiện:</b>
                    <a href="/event_detail/{{ $ticket->id_event }}" title="Xem chi tiết sự kiện">{{ $ticket->event->name_event }}</a>
                </div>
                @endif
                <div class="detail-quantity">
                    <b style="color: #40A216;">Số lượng còn:</b>
                    @if ($ticket->quantity_ticket > 0)
                    {{ $ticket->quantity_ticket }} vé
                    @else
                    <span style="color: red;">Hết vé</span>
                    @endif
                </div>
                <div class="detail-status">
                    <b style="color: #40A216;">Trạng thái:</b>
                    @if ($ticket->hidden_ticket)
                    Đã ẩn
                    @else
                    Đang bán
                    @endif
                </div>

                <div class="detail-created">
                    <b style="color: #40A216;">Ngày tạo:</b> {{ $ticket->created_at->format('d/m/Y H:i') }}
                </div>
                <div class="detail-updated">
                    <b style="color: #40A216;">Cập nhật lần cuối:</b> {{ $ticket->updated_at->format('d/m/Y H:i') }}
                </div>
            </div>
            <div class="content-detail">
                <div class="describe-detail">
                    <div class="list-describe">
                        <a style="cursor: pointer;" onclick="showContent(event, 'describe')">Mô tả</a>
                        <a style="cursor: pointer;" onclick="showContent(event, 'comment')">Đánh giá</a>
                        <a style="cursor: pointer;" onclick="showContent(event, 'relate')">Liên quan</a>
                    </div>

                    <div class="spilit" style="border: 2px solid #d0d0d0;">
                        <div class="split-child">
                            <div class="content-describe" id="describe" style="display: none;">
                                <h3>Mô tả</h3>
                                {{ $event->description_event ?? "Không có mô tả sự kiện" }}
                            </div>
                        </div>
                        <div class="split-child">
                            <div class="comment-detail" id="comment" style="display: none;">
                                <h2>Bình luận</h2>
                                <button id="openReviewModal" class="btn-review">Viết đánh giá</button>

                                @if($comments->isEmpty())
                                <p>Chưa có bình luận nào.</p>
                                @else
                                @foreach($comments as $comment)
                                <div class="comment">
                                    <div class="comment-img">
                                        <img src="{{ $comment->user->img ?? '/assets/img/default-user.png' }}" alt="Ảnh người dùng">
                                    </div>
                                    <div class="comment-content" style="width: 276px;">
                                        <div class="comment-name">{{ $comment->user->name ?? 'Người dùng ẩn danh' }}</div>
                                        <div class="comment-date">{{ $comment->created_at->format('d/m/Y') }}</div>
                                        <div class="comment-text">{{ $comment->text }}</div>
                                    </div>
                                    <div class="comment-star">
                                        <div class="rating">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <span class="star">{{ $i <= $comment->star ? '⭐' : '☆' }}</span>
                                                @endfor
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>
                            <div id="reviewModal" class="modal">
                                <div class="modal-content">
                                    <span class="close">×</span>
                                    <h2>Viết đánh giá</h2>
                                    <form id="reviewForm" action="{{ route('addComment', $ticket->id_ticket) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id_user" value="{{ Auth::id() ?? '' }}">
                                        <input type="hidden" name="id_ticket" value="{{ $ticket->id_ticket }}">
                                        <label for="star">Xếp hạng của bạn:</label>
                                        <div class="star-rating">
                                            <span class="star" data-value="1">★</span>
                                            <span class="star" data-value="2">★</span>
                                            <span class="star" data-value="3">★</span>
                                            <span class="star" data-value="4">★</span>
                                            <span class="star" data-value="5">★</span>
                                            <input type="hidden" name="star" id="ratingValue" required>
                                        </div>
                                        @error('star')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <label for="text">Đánh giá của bạn:</label>
                                        <textarea id="reviewText" name="text" required></textarea>
                                        @error('text')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <button type="submit" class="btn-submit">Gửi</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="split-child">
                            <div class="relate-detail" id="relate" style="display: block;">

                                @foreach ($ticket_relate as $relate)

                                <div class="product-relate">
                                    <div class="img-relate">
                                        <a href="/ticket/{{ $relate->id_ticket }}">
                                            <img src="{{ asset($relate->img_ticket) }}" alt="Ảnh của {{ $relate->name_ticket }}">
                                        </a>
                                    </div>
                                    <p class="name-relate">{{ $relate->name_ticket }}</p>
                                    <p class="price-relate">
                                        @if ($relate->sale_ticket > 0)
                                        <del style="color: red; margin-right: 10px">{{ number_format($relate->price_ticket) }}đ</del>
                                        <span>{{ number_format($relate->sale_ticket) }}đ</span>
                                        @else
                                        <span>{{ number_format($relate->price_ticket) }}đ</span>
                                        @endif
                                    </p>
                                    <a href="{{ route('getAddCarts', $relate->id_ticket) }}" class="btn-relate" style="width: 100%;display: block; padding: 15px 0;">
                                        <p><i class="fa fa-shopping-cart"></i> Thêm vào giỏ hàng</p>
                                    </a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
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

<script src="/assets/js/detail.js"></script>
@endsection