@extends('layout_admin')

@section('title_admin', 'Sửa Vé - ' . $data['ticket']->id_ticket)

@section('css_admin')
<link rel="stylesheet" href="{{ asset('assets/admin_css/edit/ticket.css') }}">
@endsection

@section('content_admin')
<div class="content">
    <h2>Sửa Vé - {{ $data['ticket']->name_ticket }}</h2>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <form action="{{ route('admin.update.ticket', $data['ticket']->id_ticket) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="event">Sự Kiện</label>
            <select name="id_event" id="event">
                <option value="">-- Chọn sự kiện --</option>
                @foreach ($data['event'] as $event)
                <option value="{{ $event->id_event }}" {{ old('id_event', $data['ticket']->id_event) == $event->id_event ? 'selected' : '' }}>
                    {{ $event->name_event }}
                </option>
                @endforeach
            </select>
            @error('id_event')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="id_cate">Danh Mục Vé</label>
            <select name="id_cate" id="id_cate">
                <option value="">-- Chọn danh mục --</option>
                @foreach ($data['cate'] as $cate)
                <option value="{{ $cate->id_cate }}" {{ old('id_cate', $data['ticket']->id_cate) == $cate->id_cate ? 'selected' : '' }}>
                    {{ $cate->name_cate }}
                </option>
                @endforeach
            </select>
            @error('id_cate')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="name_ticket">Tên Vé</label>
            <input type="text" name="name_ticket" id="name_ticket" value="{{ old('name_ticket', $data['ticket']->name_ticket) }}">
            @error('name_ticket')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="price_ticket">Giá Vé (VNĐ)</label>
            <input type="number" name="price_ticket" id="price_ticket" value="{{ old('price_ticket', $data['ticket']->price_ticket) }}" min="0">
            @error('price_ticket')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="sale_ticket">Giá Khuyến Mãi (VNĐ)</label>
            <input type="number" name="sale_ticket" id="sale_ticket" value="{{ old('sale_ticket', $data['ticket']->sale_ticket ?? 0) }}" min="0">
            @error('sale_ticket')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="quantity_ticket">Số Lượng Vé</label>
            <input type="number" name="quantity_ticket" id="quantity_ticket" value="{{ old('quantity_ticket', $data['ticket']->quantity_ticket) }}" min="1">
            @error('quantity_ticket')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="type_ticket">Đã bán</label>
            <input type="text" id="" value="{{ old('bought',$data['ticket']->bought) }}" readonly>
            @error('type_ticket')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="type_ticket">Loại Vé</label>
            <input type="text" name="type_ticket" id="" value="{{ old('type_ticket',$data['ticket']->type_ticket) }}">
            @error('type_ticket')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="description_ticket">Mô Tả Vé</label>
            <textarea name="description_ticket" id="description_ticket" rows="5">{{ old('description_ticket', $data['ticket']->description_ticket ?? '') }}</textarea>
            @error('description_ticket')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="img_ticket">Hình Ảnh Vé</label>
            <input type="file" name="img_ticket" id="img_ticket" accept="image/*">
            @if ($data['ticket']->img_ticket)
            <div class="current-image">
                <img src="{{ asset($data['ticket']->img_ticket) }}" alt="{{ $data['ticket']->name_ticket }}">
                <p>Hình ảnh hiện tại</p>
            </div>
            @endif
            @error('img_ticket')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="hidden_ticket">Ẩn Vé</label>
            <select name="hidden_ticket" id="hidden_ticket">
                <option value="0" {{ old('hidden_ticket', $data['ticket']->hidden_ticket) == 0 ? 'selected' : '' }}>Hiển thị</option>
                <option value="1" {{ old('hidden_ticket', $data['ticket']->hidden_ticket) == 1 ? 'selected' : '' }}>Ẩn</option>
            </select>
            @error('hidden_ticket')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="action-buttons">
            <button type="submit" class="btn btn-success">Lưu Thay Đổi</button>
            <a href="{{ route('admin.detail.ticket', $data['ticket']->id_ticket) }}" class="btn">Quay Lại</a>
        </div>
    </form>
</div>
@endsection