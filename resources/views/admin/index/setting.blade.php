@extends('layout_admin')

@section('title_admin', 'Cài Đặt Hệ Thống')

@section('css_admin')
    <link rel="stylesheet" href="{{ asset('assets/admin_css/settings.css') }}">
@endsection

@section('content_admin')
    <div class="content">
        <h2>Cài Đặt Hệ Thống</h2>
        <div class="settings-tabs">
            <button class="tab-button active" data-tab="general">Thông tin chung</button>
            <button class="tab-button" data-tab="ticket">Cấu hình vé</button>
            <button class="tab-button" data-tab="notifications">Thông báo</button>
        </div>
        <div class="tab-content">
            <div class="tab-pane active" id="general">
                <h3>Thông tin chung</h3>
                <form class="settings-form">
                    <div class="form-group">
                        <label for="system_name">Tên hệ thống:</label>
                        <input type="text" id="system_name" name="system_name" value="Hệ Thống Quản Lý Bán Vé" placeholder="Nhập tên hệ thống">
                    </div>
                    <div class="form-group">
                        <label for="system_email">Email hệ thống:</label>
                        <input type="email" id="system_email" name="system_email" value="support@ticket.com" placeholder="Nhập email hệ thống">
                    </div>
                    <div class="form-group">
                        <label for="system_logo">Logo hệ thống:</label>
                        <input type="file" id="system_logo" name="system_logo" accept="image/*">
                        <img src="https://via.placeholder.com/100" alt="Logo hiện tại" class="current-logo">
                    </div>
                    <button type="submit" class="btn btn-success">Lưu thay đổi</button>
                </form>
            </div>

            <div class="tab-pane" id="ticket">
                <h3>Cấu hình vé</h3>
                <form class="settings-form">
                    <div class="form-group">
                        <label for="default_price">Giá vé mặc định (VNĐ):</label>
                        <input type="number" id="default_price" name="default_price" value="500000" min="0" step="1000">
                    </div>
                    <div class="form-group">
                        <label for="max_tickets">Số vé tối đa mỗi lần đặt:</label>
                        <input type="number" id="max_tickets" name="max_tickets" value="10" min="1">
                    </div>
                    <div class="form-group">
                        <label for="booking_timeout">Thời gian giữ chỗ (phút):</label>
                        <input type="number" id="booking_timeout" name="booking_timeout" value="15" min="5">
                    </div>
                    <button type="submit" class="btn btn-success">Lưu thay đổi</button>
                </form>
            </div>

            <!-- Tab Thông báo -->
            <div class="tab-pane" id="notifications">
                <h3>Cấu hình thông báo</h3>
                <form class="settings-form">
                    <div class="form-group">
                        <label for="email_notifications">Gửi thông báo qua email:</label>
                        <input type="checkbox" id="email_notifications" name="email_notifications" checked>
                    </div>
                    <div class="form-group">
                        <label for="sms_notifications">Gửi thông báo qua SMS:</label>
                        <input type="checkbox" id="sms_notifications" name="sms_notifications">
                    </div>
                    <div class="form-group">
                        <label for="notification_email">Email gửi thông báo:</label>
                        <input type="email" id="notification_email" name="notification_email" value="notify@ticket.com" placeholder="Nhập email">
                    </div>
                    <button type="submit" class="btn btn-success">Lưu thay đổi</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.tab-button').forEach(button => {
            button.addEventListener('click', () => {
                document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
                document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('active'));
                
                button.classList.add('active');
                document.getElementById(button.getAttribute('data-tab')).classList.add('active');
            });
        });
    </script>
@endsection