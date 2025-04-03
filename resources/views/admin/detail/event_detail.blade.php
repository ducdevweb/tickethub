@extends('layout_admin')

@section('title_admin', 'Chi Tiết Sự Kiện - ' . $data->name_event)
@php
use Carbon\Carbon;
@endphp
@section('css_admin')
    <link rel="stylesheet" href="{{ asset('assets/admin_css/detail/event.css') }}">
@endsection

@section('content_admin')
    <div class="content">
        <h2>Chi Tiết Sự Kiện - {{ $data->name_event }}</h2>

        <div class="event-details">
            <div class="event-image">
                <img src="{{ $data->event_img}}" alt="Hình ảnh sự kiện">
            </div>
            <div class="event-info">
                <div class="info-item">
                    <label>Tên sự kiện:</label>
                    <span>{{ $data->name_event }}</span>
                </div>
                <div class="info-item">
                    <label>Địa điểm:</label>
                    <span>{{ $data->location }}</span>
                </div>
                <div class="info-item">
                    <label>Ngày bắt đầu:</label>
                    <span>{{ date('d/m/Y H:i', strtotime($data->date_start)) }}</span>
                </div>
                <div class="info-item">
                    <label>Ngày kết thúc:</label>
                    <span>{{ date('d/m/Y H:i', strtotime($data->date_end)) }}</span>
                </div>
                <div class="info-item">
                    <label>Số vé tối đa:</label>
                    <span>{{ number_format($data->max_ticket) }}</span>
                </div>
                <div class="info-item">
                    <label>Số vé đã bán:</label>
                    <span>{{ number_format($data->sold_ticket) }}</span>
                </div>
                <div class="info-item">
                    <label>Trạng thái:</label>
                    <span class="status">
                    @if(Carbon::parse($data->date_start)->gt(Carbon::now()))
                        Chưa bắt đầu
                        @elseif(Carbon::now()->between(Carbon::parse($data->date_start), Carbon::parse($data->date_end)))
                        Đang diễn ra
                        @else
                        Đã kết thúc
                        @endif
                    </span>
                </div>
                <div class="info-item full-width">
                    <label>Mô tả sự kiện:</label>
                    <p>{{ $data->description_event }}</p>
                </div>
            </div>
        </div>

        <div class="action-buttons">
            <a href="/admin/edit_event/{{ $data->id_event }}" class="btn btn-warning">Sửa sự kiện</a>
            <a href="#" class="btn btn-danger" onclick="return confirm('Xóa sự kiện này?')">Xóa sự kiện</a>
            <a href="{{ url('/admin/event') }}" class="btn">Quay lại</a>
        </div>
    </div>
@endsection