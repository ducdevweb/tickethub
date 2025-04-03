@extends('layout_login')
@section('title_login')
Ưa Thích
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/favouritefavourite.css') }}">
@endsection
@section('content_login')
<div id="favourite" class="favourite-container">
    <h3>Niêm Yết Đã Đánh Dấu Ưa Thích</h3>
    @forelse ($favourites as $favourite)
    <a href="/ticket/{{ $favourite->id_ticket }}" style="text-decoration: none;">
    <div class="list-favourite">
        <div class="img-fvr">
            <img src="{{ $favourite->ticket->img_ticket }}" alt="">
            <div class="describe">
                <div class="name-fvr">
                    {{ $favourite->ticket->name_ticket }}
                </div>
                <div class="text-fvr">
                    {{ $favourite->ticket->description_ticket }}
                </div>
            </div>
        </div>
        <a href="/favourite/{{ $favourite->id_ticket }}" class="remove-btn" data-id="{{ $favourite->id_ticket }}">❌ Xóa bỏ</a>
    </div>
    </a>
    @empty
    <p style="text-align: center; color: #888; padding: 20px;">Bạn chưa có mục yêu thích nào.</p>
    @endforelse
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.remove-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const ticketId = this.getAttribute('data-id');
                const url = this.href;

                Swal.fire({
                    title: 'Xác nhận xóa',
                    text: 'Bạn có chắc muốn xóa mục này khỏi danh sách ưa thích?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e74c3c',
                    cancelButtonColor: '#7f8c8d',
                    confirmButtonText: 'Xóa',
                    cancelButtonText: 'Hủy'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            });
        });
    });
</script>
@endsection