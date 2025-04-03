@extends('layout_admin')

@section('title_admin', 'Báo Cáo Chi Tiết')

@section('css_admin')
<link rel="stylesheet" href="{{ asset('assets/admin_css/report.css') }}">
@endsection

@section('content_admin')
<div class="content">
    <h2>Báo Cáo Chi Tiết</h2>
    <for, class="filter-form">
        <select name="report_type">
            <option value="">-- Chọn loại báo cáo --</option>
            <option value="ticket_sales">Doanh thu bán vé</option>
            <option value="event_performance">Hiệu suất sự kiện</option>
            <option value="user_activity">Hoạt động người dùng</option>
        </select>
        <input type="date" name="start_date" placeholder="Từ ngày">
        <input type="date" name="end_date" placeholder="Đến ngày">
        <select name="event">
            <option value="">-- Chọn sự kiện --</option>
            <option value="hoa_nhac_mua_thu">Hòa Nhạc Mùa Thu</option>
            <option value="le_hoi_am_nhac">Lễ Hội Âm Nhạc</option>
            <option value="kich_ngay_xua">Kịch "Ngày Xưa"</option>
        </select>
        <button type="submit" class="btn">Tạo báo cáo</button>
    </for,>

    <div class="report-summary">
        <div class="summary-card">
            <h3>Tổng giao dịch</h3>
            <p class="number">{{ $data['order_count'] }}</p>
        </div>
        <div class="summary-card">
            <h3>Doanh thu tổng</h3>
            <p class="number">{{$data['order_count']}} VNĐ</p>
        </div>
        <div class="summary-card">
            <h3>Sự kiện được xem nhiều</h3>
            <p class="number">{{ $data['most_event']->name_event }}</p>
        </div>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ngày giao dịch</th>
                    <th>Khách hàng</th>
                    <th>Số điện thoại</th>
                    <th>Email</th>
                    <th>Địa chỉ</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data['order'] as $dt)
                <tr>
                    <td>{{$dt->id_order }}</td>
                    <td>{{ $dt->created_at }}</td>
                    <td>{{ $dt->user->name }}</td>
                    <td>{{ $dt->phone}}</td>
                    <td>{{ $dt->email }}</td>
                    <td>{{ $dt->address }}</td>
                    <td>{{ $dt->status }}</td>
                    <td>
                        <a href="{{ route('admin.detail.report',$dt->id_order) }}" class="btn">Xem</a>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>

  
</div>
@endsection