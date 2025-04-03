@extends('layout_login')
@section('title_login')
Thông tin tài khoản
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/account.css') }}">
@endsection
@section('content_login')
<div id="my-account">
    <div id="account-container">
        <h3>Thông Tin Tài Khoản</h3>
        <img src="{{ Auth::user()->img ? asset( Auth::user()->img) : asset('uploads/default-avatar.jpg') }}" alt="Avatar" id="user-avatar">

        <div id="account-details" class="account-section">
            <p><strong>ID:</strong> <span id="user-id">#{{ Auth::id() }}</span></p>
            <p><strong>Tên:</strong> <span id="user-name">{{ Auth::user()->name }}</span></p>
            <p><strong>Email:</strong> <span id="user-email">{{ Auth::user()->email }}</span></p>
            <p><strong>Ngày đăng ký:</strong> <span id="user-created-at">{{ Auth::user()->created_at->format('d/m/Y') }}</span></p>
            <p><strong>Số Điện Thoại:</strong> <span id="user-phone">{{ Auth::user()->phone ?? 'Chưa cập nhật' }}</span></p>
        </div>

        <form id="edit-form" class="account-section" style="display: none;" action="{{ route('updateUser') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="_method" value="PUT">
            <div class="form-group">
                <label for="name">Tên:</label>
                <input type="text" id="name" name="name" value="{{ Auth::user()->name }}" required>
                @error('name')
                <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="{{ Auth::user()->email }}" required readonly>
                @error('email')
                <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="phone">Số Điện Thoại:</label>
                <input type="text" id="phone" name="phone" value="{{ Auth::user()->phone ?? '' }}">
                @error('phone')
                <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu mới (để trống nếu không đổi):</label>
                <input type="password" id="password" name="password">
                @error('password')
                <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="password_confirmation">Xác nhận mật khẩu:</label>
                <input type="password" id="password_confirmation" name="password_confirmation">
            </div>

            <div class="form-group">
                <label for="img">Ảnh đại diện:</label>
                <input type="file" id="img" name="img" accept="image/*">
                @error('img')
                <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-actions">
                <button type="submit" class="save-btn">Lưu</button>
                <button type="button" id="cancel-edit" class="cancel-btn">Hủy</button>
            </div>
        </form>

        <button id="edit-account">Chỉnh sửa</button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editBtn = document.getElementById('edit-account');
        const editForm = document.getElementById('edit-form');
        const accountDetails = document.getElementById('account-details');
        const cancelBtn = document.getElementById('cancel-edit');

        editBtn.addEventListener('click', function() {
            accountDetails.style.display = 'none';
            editForm.style.display = 'block';
            editBtn.style.display = 'none';
        });

        cancelBtn.addEventListener('click', function() {
            editForm.style.display = 'none';
            accountDetails.style.display = 'block';
            editBtn.style.display = 'block';
        });
    });
</script>
@endsection