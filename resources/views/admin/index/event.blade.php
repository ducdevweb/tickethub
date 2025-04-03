@extends('layout_admin')
@php
use Carbon\Carbon;
@endphp
@section('title_admin', 'Quản Lý Sự Kiện')

@section('css_admin')
<link rel="stylesheet" href="{{ asset('assets/admin_css/event.css') }}">
@endsection

@section('content_admin')
<div class="content">
    <h2>Quản Lý Sự Kiện</h2>
    <form class="filter-form">
        <select name="status">
            <option value="">-- Chọn trạng thái --</option>
            <option value="Chưa bắt đầu">Sắp diễn ra</option>
            <option value="Đang diễn ra">Đang diễn ra</option>
            <option value="Đã kết thúc">Đã kết thúc</option>
        </select>
        <input type="text" name="search" placeholder="Tìm kiếm tên sự kiện...">
        <input type="date" name="date_start">
        <input type="date" name="date_end">
        <button type="submit" class="btn">Tìm kiếm</button>
    </form>
    <div class="action-bar">
        <span>Tổng cộng: {{ $data['count_event'] }} sự kiện</span>
        <a href="/admin/create_event" class="btn btn-success">Thêm sự kiện</a>
    </div>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên sự kiện</th>
                    <th>Ngày diễn ra</th>
                    <th>Ngày kết thúc</th>
                    <th>Địa điểm</th>
                    <th>Số vé tối đa</th>
                    <th>Số vé đã bán</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data['event'] as $ev)
                <tr>
                    <td>{{ $ev->id_event}}</td>
                    <td>{{ $ev->name_event}}</td>
                    <td>{{ Carbon::parse($ev->date_start)->format('d/m/y')}}</td>
                    <td>{{ Carbon::parse($ev->date_end)->format('d/m/y')}}</td>
                    <td>{{ $ev->location}}</td>
                    <td>{{ $ev->max_ticket}}</td>
                    <td>{{ $ev->sold_ticket}}</td>
                    <td>

                        @if(Carbon::parse($ev->date_start)->gt(Carbon::now()))
                        Chưa bắt đầu
                        @elseif(Carbon::now()->between(Carbon::parse($ev->date_start), Carbon::parse($ev->date_end)))
                        Đang diễn ra
                        @else
                        Đã kết thúc
                        @endif
                    </td>
                    <td style="display: flex;">
                        <a href="{{ route('admin.detail.event',$ev->id_event) }}" class="btn">Xem</a>
                        <form action="{{ route('admin.delete.event', $ev->id_event) }}" method="POST" style="display:inline;" onsubmit="return confirm('Xóa sự kiện này ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                        </form>
                        <a href="{{ route('admin.events.map', $ev->id_event) }}" class="btn btn-info">Map</a>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>

@endsection