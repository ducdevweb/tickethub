@extends('layout_admin')

@section('title_admin', 'Sửa Sự Kiện - ' . $event->name_event)

@section('css_admin')
    <link rel="stylesheet" href="{{ asset('assets/admin_css/edit/event.css') }}">
@endsection

@section('content_admin')
    <div class="content">
        <h2>Sửa Sự Kiện - {{ $event->name_event }}</h2>

        <form action="{{ route('admin.update.event', $event->id_event) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name_event">Tên Sự Kiện</label>
                <input type="text" name="name_event" id="name_event" value="{{ $event->name_event }}" required>
            </div>

            <div class="form-group">
                <label for="location">Địa Điểm</label>
                <input type="text" name="location" id="location" value="{{ $event->location }}" required>
            </div>

            <div class="form-group">
                <label for="img_event">Hình Ảnh Sự Kiện</label>
                <input type="file" name="img_event" id="img_event" accept="image/*">
                
                <div class="current-image">
                        <img src="{{ $event->event_img}}" alt="Hình ảnh hiện tại" width="200">
                  
                    <p>Hình ảnh hiện tại</p>
                </div>
            </div>

            <div class="form-group">
                <label for="max_ticket">Số Vé Tối Đa</label>
                <input type="number" name="max_ticket" id="max_ticket" value="{{ $event->max_ticket }}" min="1" required>
            </div>

            <div class="form-group">
                <label for="sold_ticket">Số Vé Đã Bán</label>
                <input type="number" name="sold_ticket" id="sold_ticket" value="{{ $event->sold_ticket }}" min="0" readonly>
            </div>

            <div class="form-group">
                <label for="date_start">Ngày Bắt Đầu</label>
                <input type="datetime-local" name="date_start" id="date_start" 
                       value="{{ date('Y-m-d\TH:i', strtotime($event->date_start)) }}" required>
            </div>

            <div class="form-group">
                <label for="date_end">Ngày Kết Thúc</label>
                <input type="datetime-local" name="date_end" id="date_end" 
                       value="{{ date('Y-m-d\TH:i', strtotime($event->date_end)) }}" required>
            </div>

            <div class="form-group">
                <label for="description_event">Mô Tả Sự Kiện</label>
                <textarea name="description_event" id="description_event" rows="5">{{ $event->description_event }}</textarea>
            </div>

            <div class="action-buttons">
                <button type="submit" class="btn btn-success">Lưu thay đổi</button>
                <a href="/admin/event_detail/{{ $event->id_event }}" class="btn">Quay lại</a>
            </div>
        </form>
    </div>
@endsection
