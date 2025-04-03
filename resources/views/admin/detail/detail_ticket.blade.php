@extends('layout_admin')

@section('title_admin', 'Chi Tiết Vé')

@section('css_admin')
<link rel="stylesheet" href="{{ asset('assets/admin_css/ticket.css') }}">
@endsection

@section('content_admin')
<div class="content">
    <h2>Chi Tiết Vé</h2>

    <div class="ticket-detail">
        <h3>{{ $ticket->name_ticket }}</h3>
        <div class="ticket-info">
            <table>
                <tr>
                    <th>Tên Vé</th>
                    <td>{{ $ticket->name_ticket }}</td>
                </tr>
                <tr>
                    <th>Sự Kiện</th>
                    <td>{{ $ticket->event->name_event }}</td>
                </tr>
                <tr>
                    <th>Danh Mục</th>
                    <td>{{ $ticket->cate->name_cate }}</td>
                </tr>
                <tr>
                    <th>Giá Gốc (VNĐ)</th>
                    <td>{{ number_format($ticket->price_ticket) }}</td>
                </tr>
                <tr>
                    <th>Giá Khuyến Mãi (VNĐ)</th>
                    <td>{{ $ticket->sale_ticket > 0 ? number_format($ticket->sale_ticket) : 'Không có' }}</td>
                </tr>
                <tr>
                    <th>Đã bán</th>
                    <td>{{ $ticket->bought }}</td>
                </tr>
                <tr>
                    <th>Số Lượng</th>
                    <td>{{ $ticket->quantity_ticket }}</td>
                </tr>
                <tr>
                    <th>Loại vé</th>
                    <td>{{ $ticket->type_ticket }}</td>
                </tr>
                <tr>
                    <th>Mô Tả</th>
                    <td>{{ $ticket->description_ticket ?? 'Chưa có mô tả' }}</td>
                </tr>
                <tr>
                    <th>Hình Ảnh</th>
                    <td>
                        @if ($ticket->img_ticket)
                            <img src="{{ asset($ticket->img_ticket) }}" alt="{{ $ticket->name_ticket }}" width="400px" height="200px">
                        @else
                            Không có hình ảnh
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Trạng Thái</th>
                    <td>
                        <span class="status {{ $ticket->hidden_ticket == 0 ? 'yes' : 'no' }}">
                            {{ $ticket->hidden_ticket == 0 ? 'Hiện' : 'Ẩn' }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Ngày Tạo</th>
                    <td>{{ \Carbon\Carbon::parse($ticket->created_at)->format('d/m/Y H:i') }}</td>
                </tr>
                <tr>
                    <th>Ngày Cập Nhật</th>
                    <td>{{ \Carbon\Carbon::parse($ticket->updated_at)->format('d/m/Y H:i') }}</td>
                </tr>
            </table>
        </div>

        <div class="action-buttons">
            <a href="/admin/edit_ticket/{{ $ticket->id_ticket }}" class="btn btn-edit">Chỉnh Sửa</a>
           
            <a href="" class="btn btn-back">Quay Lại</a>
        </div>
    </div>
</div>
@endsection