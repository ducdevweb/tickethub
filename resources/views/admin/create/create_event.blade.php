@extends('layout_admin')

@section('title_admin', 'Thêm Sự Kiện Mới')

@section('css_admin')
    <link rel="stylesheet" href="{{ asset('assets/admin_css/create/create_event.css') }}">
@endsection

@section('content_admin')
    <div class="content">
        <h2>Thêm Sự Kiện Mới</h2>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.create.event') }}" method="POST" enctype="multipart/form-data" class="edit-form">
            @csrf

            <div class="form-group">
                <label for="name_event">Tên sự kiện:</label>
                <input type="text" id="name_event" name="name_event" value="{{ old('name_event') }}" required>
                @error('name_event')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="location">Địa điểm:</label>
                <input type="text" id="location" name="location" value="{{ old('location') }}" required>
                @error('location')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="date_start">Ngày bắt đầu:</label>
                <input type="datetime-local" id="date_start" name="date_start" value="{{ old('date_start') }}" required>
                @error('date_start')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="date_end">Ngày kết thúc:</label>
                <input type="datetime-local" id="date_end" name="date_end" value="{{ old('date_end') }}" required>
                @error('date_end')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="max_ticket">Số lượng vé tối đa:</label>
                <input type="number" id="max_ticket" name="max_ticket" value="{{ old('max_ticket') }}" min="1" required>
                @error('max_ticket')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="event_img">Hình ảnh sự kiện:</label>
                <input type="file" id="event_img" name="event_img" accept="image/*">
                @error('event_img')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="description_event">Mô tả sự kiện:</label>
                <textarea id="description_event" name="description_event" rows="5">{{ old('description_event') }}</textarea>
                @error('description_event')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="action-buttons">
                <button type="submit" class="btn btn-success">Thêm Sự Kiện</button>
                <a href="/admin/event" class="btn">Quay Lại</a>
            </div>
        </form>
    </div>
@endsection