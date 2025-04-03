@extends('layout_admin')

@section('title_admin', 'Chi Tiết Doanh Thu')

@section('css_admin')
<link rel="stylesheet" href="{{ asset('assets/admin_css/detail/revenue.css') }}">
@endsection

@section('content_admin')
<div class="content">
    <div class="content-header">
        <h2>Chi Tiết Doanh Thu - {{ $data['event']->name_event }}</h2>
        <a href="" class="btn btn-back"><i class="fas fa-arrow-left"></i> Quay lại</a>
    </div>

    <div class="revenue-summary">
        <div class="summary-card">
            <h3>Tổng doanh thu</h3>
            <p class="number">{{number_format($data['revenue'],0,'.',',') }} VNĐ</p>
        </div>
        <div class="summary-card">
            <h3>Số vé đã bán</h3>
            <p class="number">{{ $data['event']->sold_ticket }}</p>
        </div>
        <div class="summary-card">
            <h3>Doanh thu trung bình/vé</h3>
            <p class="number">{{ number_format($data['avg'] ?? 0, 0, ',', '.') }} VNĐ</p>
        </div>
        <div class="summary-card">
            <h3>Ngày diễn ra</h3>
            <p class="number">{{ \Carbon\Carbon::parse($data['event']->date_start)->format('d/m/y') }}</p>
        </div>
    </div>

    <!-- Form lọc -->
    <div class="filter-form">
        <select name="ticket_type">
            <option value="">-- Loại vé --</option>
            <option value="vip">VIP</option>
            <option value="standard">Tiêu chuẩn</option>
            <option value="economy">Phổ thông</option>
        </select>
        <input type="text" name="search" placeholder="Tìm kiếm mã vé, khách hàng...">
        <button type="submit" class="btn btn-search"><i class="fas fa-search"></i> Lọc</button>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Seri vé</th>
                    <th>Loại vé</th>
                    <th>Khách hàng</th>
                    <th>Ngày đặt</th>
                    <th>Giá vé</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data['detail_event'] as $dt)
                <tr>
                    <td>{{ $dt->seri_ticket }}</td>
                    <td>{{ $dt->ticket->type_ticket}}</td>
                    <td>{{ $dt->order->user->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($dt->created_at)->format('d/m/y') }}</td>
                    <td>{{number_format($dt->total,0,'.',',') }} VNĐ</td>
                    <td><span class="status status-paid">Đã thanh toán</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="action-buttons">
        <a href="{{ route('export.file', ['type' => 'revenue', 'id' => $data['event']->id_event, 'fileType' => 'pdf']) }}" class="btn btn-success">Xuất PDF</a>

        <a href="{{ route('export.file', ['type' => 'revenue', 'id' => $data['event']->id_event, 'fileType' => 'excel']) }}" class="btn btn-info">Xuất Excel</a>

    </div>

</div>
@endsection