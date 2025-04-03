@extends('layout_admin')

@section('title_admin', 'Chi Tiết Người Dùng - ' . $data['user']->name)

@section('css_admin')
<link rel="stylesheet" href="{{ asset('assets/admin_css/detail/user.css') }}">
@endsection

@section('content_admin')
<div class="content">
    <h2>Chi Tiết Người Dùng - {{ $data['user']->name }}</h2>

    <div class="user-details">
        <div class="user-avatar">
            <img src="{{ $data['user']->img ?? 'https://via.placeholder.com/150' }}" alt="Avatar người dùng">
        </div>
        <div class="user-info">
            <div class="info-item">
                <label>Họ và tên:</label>
                <span>{{ $data['user']->name }}</span>
            </div>
            <div class="info-item">
                <label>Email:</label>
                <span>{{ $data['user']->email }}</span>
            </div>
            <div class="info-item">
                <label>Số điện thoại:</label>
                <span>{{ $data['user']->phone }}</span>
            </div>
            <div class="info-item">
                <label>Vai trò:</label>
                <span>{{ $data['user']->role == 0 ? 'Quản trị viên' : 'Người dùng' }}</span>
            </div>
            <div class="info-item">
                <label>Trạng thái:</label>
                <span class="status">
                    {{ $data['user']->status == 0 ? 'Hoạt động' : 'Bị khóa' }}
                </span>
            </div>
            <div class="info-item">
                <label>Ngày đăng ký:</label>
                <span>{{ $data['user']->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <div class="info-item">
                <label>Số vé đã mua:</label>
                <span>{{ $data['details']->sum('quantity') }}</span>
            </div>
        </div>
    </div>

    <div class="user-tickets">
        <h3>Lịch sử đơn hàng</h3>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>Ngày mua</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data['orders'] as $order)
                    <tr>
                        <td>{{ $order->id_order }}</td>
                        <td>{{ $order->created_at->format('d/m/Y') }}</td>
                        <td>{{ number_format($order->detailOrders->sum('total'), 0, ',', '.') }} VNĐ</td>
                        <td>{{ $order->status }}</td>
                        <td>
                            <a href="{{ route('admin.detail.report',$order->id_order) }}" class="btn btn-primary" id="detail">Xem chi tiết</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">Người dùng chưa có đơn hàng nào.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="action-buttons">
        <a href="/admin/update_user/{{ $data['user']->id }}" class="btn btn-warning">
            {{ $data['user']->status == 0 ? 'Cấm hoạt động' : 'Mở hoạt động' }}
        </a>

        <a href="#" class="btn btn-danger" onclick="return confirm('Xóa người dùng này?')">Xóa người dùng</a>
        <a href="/admin/user" class="btn">Quay lại</a>
    </div>
</div>


@endsection