@extends('layout_login')
@section('title_login')
    Bình luận
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/comment.css') }}">
@endsection
@section('content_login')
<div id="my-comment">
    <h3 style="margin: 15px 0;">Đánh Giá Của Bạn</h3>
    <hr style="margin: 15px 0;">
    <div class="border-comment">
        @forelse($comments as $comment)
        <a href="/ticket/{{ $comment->id_ticket }}" style="text-decoration: none;">
            <div class="product">
                <img src="{{ $comment->ticket->img_ticket ?? '/assets/img/care-about.png' }}" alt="{{ $comment->ticket->name_ticket ?? 'Sản phẩm' }}">
                <div class="product-info">
                    <h3>{{ $comment->ticket->name_ticket ?? 'Khóa học "Bí mật vân tay"' }}</h3>
                    <div class="rating">
                        @for ($i = 1; $i <= 5; $i++)
                            <span class="star {{ $i <= $comment->star ? 'filled' : '' }}">★</span>
                        @endfor
                    </div>
                    <p class="comment">Bình luận của bạn: <span>"{{ $comment->text ?? 'Khóa học rất hay và bổ ích!' }}"</span></p>
                    <p class="date">Bình luận vào: {{ $comment->created_at->format('d/m/Y') ?? '20/02/2025' }}</p>
                </div>
            </div>
            </a>
        @empty
            <p style="text-align: center; width: 100%; color: #888;">Bạn chưa có bình luận nào.</p>
        @endforelse
    </div>
</div>
@endsection