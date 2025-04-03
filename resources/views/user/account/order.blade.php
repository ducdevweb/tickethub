@extends('layout_login')

@section('title_login')
    Danh Sách Đơn Hàng
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/order.css') }}">
@endsection
@section('content_login')

<div id="my-order">
    <div id="container-order">
        <h3>Danh Sách Đơn Hàng</h3>
        <div class="order-filter">
            <input type="text" placeholder="Tìm kiếm đơn hàng..." id="search-order">
            <select id="status-filter">
                <option value="">Tất cả trạng thái</option>
                <option value="pending">Đang xử lý</option>
                <option value="completed">Hoàn thành</option>
                <option value="cancelled">Đã hủy</option>
            </select>
        </div>
        <table class="order-list">
            <thead>
                <tr>
                    <th>Đơn hàng</th>
                    <th>Ngày</th>
                    <th>Trạng thái</th>
                    <th>Tổng</th>
                    <th>Các thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr class="order-item">
                        <td class="order-id">#{{ $order->id_order }}</td>
                        <td class="order-date">{{ $order->created_at->format('d/m/Y') }}</td>
                        <td>
                            <span class="order-status ">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td class="order-total">
                            {{ number_format($order->detailOrders->sum('total')) }} VND
                        </td>
                        <td class="order-actions">
                            <a href="/order/{{ $order->id_order}}" class="view-btn">Xem</a>
                            @if (($order->status ?? 'Đang xử lý') === 'Đang xử lý')
                                <a class="cancel-btn">Hủy</a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: #666;">Không có đơn hàng nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection