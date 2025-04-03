@extends('layout_admin')

@section('title_admin')
Trang Chính
@endsection

@section('css_admin')
<link rel="stylesheet" href="{{ asset('assets/admin_css/index.css') }}">
@endsection

@section('content_admin')
<div class="content">
    <h2>Bảng Điều Khiển Admin</h2>

    <div class="dashboard-cards">
        <div class="card">
            <h3>Tổng số vé đã bán</h3>
            <div class="number">{{ number_format($getData['count_order']) }}</div>
        </div>
        <div class="card">
            <h3>Tổng doanh thu</h3>
            <div class="number">{{ number_format($getData['revenue_order']) }} VNĐ</div>
        </div>
        <div class="card">
            <h3>Sự kiện đang diễn ra</h3>
            <div class="number">{{ number_format($getData['count_event']) }}</div>
        </div>
        <div class="card">
            <h3>Tài khoản người dùng</h3>
            <div class="number">{{ number_format($getData['count_user']) }}</div>
        </div>
    </div>

    <h3>Danh sách vé gần đây</h3>
    <div class="search-form">
        <input type="text" placeholder="Tìm kiếm vé theo mã, khách hàng...">
        <button>Tìm kiếm</button>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Mã vé</th>
                    <th>Sự kiện</th>
                    <th>Loại vé</th>
                    <th>Khách hàng</th>
                    <th>Ngày đặt</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($getData['new_ticket'] as $ticket)
                <tr>
                    <td>#{{ $ticket->id }}</td>
                    <td>{{ $ticket->ticket->event->name_event ?? 'Không xác định' }}</td>
                    <td>{{ $ticket->ticket->name_ticket ?? 'N/A' }}</td>
                    <td>{{ $ticket->order->name ?? 'N/A' }}</td>
                    <td>{{ $ticket->created_at->format('d/m/Y') }}</td>
                    <td>{{ $ticket->order->status ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('admin.detail.ticket', $ticket->id_ticket) }}" class="btn">Xem chi tiết</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Chưa có đơn hàng nào gần đây</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
