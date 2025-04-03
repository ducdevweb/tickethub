@extends('layout_admin')

@section('title_admin', 'Thêm Vé - Quản Lý Vé')

@section('css_admin')
<link rel="stylesheet" href="{{ asset('assets/admin_css/create/create_ticket.css') }}">
@endsection

@section('content_admin')
<div class="content">
    <h2>Thêm Vé</h2>

    <form action="{{ route('admin.create.ticket') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="id_event">Sự Kiện</label>
            <select name="id_event" id="id_event" required>
                <option value="">-- Chọn sự kiện --</option>
                @foreach ($event as $ev)
                <option value="{{ $ev->id_event }}" data-max="{{ $ev->max_ticket }}">{{ $ev->name_event }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="id_cate">Danh mục</label>
            <select name="id_cate" id="id_cate" required>
                @foreach ($cate as $ct)
                <option value="{{ $ct->id_cate }}">{{ $ct->name_cate }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="name_ticket">Tên Vé</label>
            <input type="text" name="name_ticket" id="name_ticket" placeholder="Nhập tên vé" required>
        </div>

        <div class="form-group">
            <label for="price_ticket">Giá Vé (VNĐ)</label>
            <input type="number" name="price_ticket" id="price_ticket" placeholder="Nhập giá vé" min="0" required>
        </div>

        <div class="form-group">
            <label for="sale_ticket">Giảm Giá</label>
            <input type="number" name="sale_ticket" id="sale_ticket" placeholder="Nhập phần trăm giảm giá" min="0" max="100" value="0">
        </div>

        <div class="form-group">
            <label for="quantity_ticket">Số Lượng Vé</label>
            <input type="number" name="quantity_ticket" id="quantity_ticket" readonly>
        </div>
        <div class="form-group">
            <label for="type_ticket">Loại vé</label>
            <input type="text" name="type_ticket" id="type_ticket" >
        </div>
        <div class="form-group">
            <label for="description_ticket">Mô Tả Vé</label>
            <textarea name="description_ticket" id="description_ticket" placeholder="Nhập mô tả vé" rows="4"></textarea>
        </div>

        <div class="form-group">
            <label for="img_ticket">Hình Ảnh Vé</label>
            <input type="file" name="img_ticket" id="img_ticket" accept="image/*">
        </div>

        <div class="form-group">
            <label for="status">Trạng Thái</label>
            <select name="status" id="status" required>
                <option value="active">Hoạt động</option>
                <option value="inactive">Không hoạt động</option>
            </select>
        </div>

        <div class="form-group">
            <label for="hidden_ticket">Ẩn Vé</label>
            <select name="hidden_ticket" id="hidden_ticket" required>
                <option value="0">Hiển thị</option>
                <option value="1">Ẩn</option>
            </select>
        </div>

        <div class="action-bar">
            <button type="submit" class="btn btn-success">Lưu Vé</button>
            <a href="/admin/ticket" class="btn">Quay Lại</a>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const eventSelect = document.getElementById('id_event');
        const quantityInput = document.getElementById('quantity_ticket');

        eventSelect.addEventListener('change', function() {
            const selectedOption = eventSelect.options[eventSelect.selectedIndex];
            const maxTicket = selectedOption.getAttribute('data-max');
            quantityInput.value = maxTicket || '';
        });
    });
</script>
@endsection
