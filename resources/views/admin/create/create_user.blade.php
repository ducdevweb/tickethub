@extends('layout_admin')

@section('title_admin', 'Thêm Người Dùng - Quản Lý Người Dùng')

@section('css_admin')
    <link rel="stylesheet" href="{{ asset('assets/admin_css/create/create_user.css') }}">
@endsection

@section('content_admin')
    <div class="content">
        <h2>Thêm Người Dùng</h2>

        <!-- Form thêm người dùng -->
        <form action="/admin/user/store" method="POST" enctype="multipart/form-data">
            @csrf <!-- Token CSRF cho Laravel -->

            <div class="form-group">
                <label for="name">Họ và Tên</label>
                <input type="text" name="name" id="name" placeholder="Nhập họ và tên" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Nhập email" required>
            </div>

            <div class="form-group">
                <label for="phone">Số Điện Thoại</label>
                <input type="text" name="phone" id="phone" placeholder="Nhập số điện thoại" required>
            </div>

            <div class="form-group">
                <label for="role">Vai Trò</label>
                <select name="role" id="role" required>
                    <option value="">-- Chọn vai trò --</option>
                    <option value="admin">Admin</option>
                    <option value="user">Người dùng</option>
                </select>
            </div>

            <div class="form-group">
                <label for="password">Mật Khẩu</label>
                <input type="password" name="password" id="password" placeholder="Nhập mật khẩu" required>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Xác Nhận Mật Khẩu</label>
                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Xác nhận mật khẩu" required>
            </div>

            <div class="form-group">
                <label for="avatar">Hình Ảnh Đại Diện</label>
                <input type="file" name="avatar" id="avatar" accept="image/*">
            </div>

            <div class="form-group">
                <label for="status">Trạng Thái</label>
                <select name="status" id="status" required>
                    <option value="active">Hoạt động</option>
                    <option value="inactive">Không hoạt động</option>
                    <option value="banned">Bị cấm</option>
                </select>
            </div>

            <div class="action-bar">
                <button type="submit" class="btn btn-success">Lưu Người Dùng</button>
                <a href="/admin/user" class="btn">Quay Lại</a>
            </div>
        </form>
    </div>
@endsection