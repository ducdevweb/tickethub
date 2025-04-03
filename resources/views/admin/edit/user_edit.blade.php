@extends('layout_admin')

@section('title_admin', 'Sửa Người Dùng - Nguyễn Văn A')

@section('css_admin')
    <link rel="stylesheet" href="{{ asset('assets/admin_css/edit/user.css') }}">
@endsection

@section('content_admin')
    <div class="content">
        <h2>Sửa Người Dùng - Nguyễn Văn A</h2>
        <form action="#" method="POST">
            <div class="form-group">
                <label for="name">Họ và Tên</label>
                <input type="text" name="name" id="name" value="Nguyễn Văn A" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="nguyenvana@example.com" required>
            </div>

            <div class="form-group">
                <label for="phone">Số Điện Thoại</label>
                <input type="text" name="phone" id="phone" value="0901234567" required>
            </div>

            <div class="form-group">
                <label for="role">Vai Trò</label>
                <select name="role" id="role" required>
                    <option value="user" selected>Người dùng</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <div class="form-group">
                <label for="password">Mật Khẩu Mới (Để trống nếu không đổi)</label>
                <input type="password" name="password" id="password" placeholder="Nhập mật khẩu mới">
            </div>

            <div class="form-group">
                <label for="password_confirmation">Xác Nhận Mật Khẩu</label>
                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Xác nhận mật khẩu mới">
            </div>

            <div class="form-group">
                <label for="avatar">Hình Ảnh Đại Diện</label>
                <input type="file" name="avatar" id="avatar" accept="image/*">
                <div class="current-avatar">
                    <img src="https://via.placeholder.com/100" alt="Avatar hiện tại">
                    <p>Hình ảnh hiện tại</p>
                </div>
            </div>

            <div class="form-group">
                <label for="status">Trạng Thái</label>
                <select name="status" id="status" required>
                    <option value="active" selected>Hoạt động</option>
                    <option value="inactive">Không hoạt động</option>
                    <option value="banned">Bị cấm</option>
                </select>
            </div>

            <div class="action-buttons">
                <button type="submit" class="btn btn-success">Lưu thay đổi</button>
                <a href="#" class="btn">Quay lại</a>
            </div>
        </form>
    </div>
@endsection