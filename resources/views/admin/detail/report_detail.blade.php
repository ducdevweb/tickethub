@extends('layout_admin')

@section('title_admin', 'Chi Tiết Giao Dịch')

@section('css_admin')
    <link rel="stylesheet" href="{{ asset('assets/admin_css/detail/report.css') }}">
@endsection

@section('content_admin')
<div class="content">
    <h2>Chi Tiết Giao Dịch</h2>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>ID Giao Dịch</th>
                    <th>Sự Kiện</th>
                    <th>Khách Hàng</th>
                    <th>Loại Vé</th>
                    <th>Seri Vé</th>
                    <th>Số Lượng</th>
                    <th>Tổng Tiền</th>
                    <th>Ngày Giao Dịch</th>
                    <th>Trạng Thái</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data['report'] as $item)
                <tr>
                    <td>{{ $item->id_detail }}</td>
                    <td>{{ $item->event->name_event ?? 'Không xác định' }}</td>
                    <td>{{ $item->order->user->name ?? 'Ẩn danh' }}</td>
                    <td>{{ $item->ticket->type_ticket ?? 'N/A' }}</td>
                    <td>{{ $item->seri_ticket ?? 'N/A' }}</td>
                    <td>{{ $item->quantity ?? 0 }}</td>
                    <td>{{ number_format($item->total, 0, ',', '.') }} VNĐ</td>
                    <td>{{$item->created_at }}</td>
                    <td>{{ $item->order->status }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center">Không có giao dịch nào!</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="action-buttons">
        <a href="{{ route('export.file', ['type' => 'order', 'id' => $item->order->id_order, 'fileType' => 'excel']) }}" class="btn btn-success">Xuất Excel</a>
        <a href="{{ route('export.file', ['type' => 'order', 'id' => $item->order->id_order, 'fileType' => 'pdf']) }}" class="btn btn-warning">Xuất PDF</a>
        <a href="/admin/revenue" class="btn btn-secondary">Quay lại</a>
    </div>
</div>
@endsection
