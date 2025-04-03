@extends('layout_login')
@section('title_login')
Chi tiết đơn hàng
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/detail_order.css') }}">
@endsection
@section('content_login')
<div id="content-section">
    <div class="user-info-container">
 
        <h3 class="user-info-title">Thông tin người dùng</h3>
        <div class="user-info-row">
            <span class="label">Tên:</span>
            <span class="value">{{ $detailOrders->first()->order->name }}</span>
        </div>
        <div class="user-info-row">
            <span class="label">Số điện thoại:</span>
            <span class="value">{{ $detailOrders->first()->order->phone }}</span>
        </div>
        <div class="user-info-row">
            <span class="label">Email:</span>
            <span class="value">{{ $detailOrders->first()->order->email }}</span>
        </div>
        <div class="user-info-row">
            <span class="label">Địa chỉ:</span>
            <span class="value">{{ $detailOrders->first()->order->address }}</span>
        </div>
    </div>
    @foreach ($detailOrders as $detail)
    <div class="order-detail-container">
        <h3 class="order-detail-title">Thông tin chi tiết đơn hàng #{{ $detail->order->id_order }}</h3>
        <div class="order-detail-card">
            <div class="order-detail-row">
                <span class="label">Mã đơn hàng:</span>
                <span class="value">#{{ $detail->id_detail }}</span>
            </div>
            <div class="order-detail-row">
                <span class="label">Số lượng vé:</span>
                <span class="value">{{ $detail->quantity }}</span>
            </div>
            <div class="order-detail-row">
                <span class="label">Seri vé:</span>
                <span class="value">{{ $detail->ticket->seri_ticket }}</span>
            </div>
    
            <div class="order-detail-row">
                <span class="label">Tổng tiền:</span>
                <span class="value">{{ $detail->total }}</span>
            </div>
            <div class="order-detail-row">
                <span class="label">Giá trị voucher:</span>
                <span class="value">{{ $detail->value_voucher??"Không có voucher nào được áp dụng" }}</span>
            </div>
            <div class="order-detail-row">
                <span class="label">Giảm giá:</span>
                <span class="value">{{ $detail->value_down??"Không có voucher nào được áp dụng" }}</span>
            </div>
            <div class="order-detail-row">
                <span class="label">Ngày tạo:</span>
                <span class="value">{{ $detail->created_at->format('d/m/Y') }}</span>
            </div>
        
        </div>
     
    </div>
    
    @endforeach
</div>
@endsection