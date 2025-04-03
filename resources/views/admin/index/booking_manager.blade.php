@extends('layout_admin')

@section('title_admin', 'Quản Lý Đặt Chỗ')

@section('css_admin')
    <link rel="stylesheet" href="{{ asset('assets/admin_css/booking.css') }}">
@endsection

@section('content_admin')
    <div class="content">
        <h2>Quản Lý Đặt Chỗ</h2>
        <div class="filter-form">
            <select name="status">
                <option value="">-- Chọn trạng thái --</option>
                <option value="pending">Chờ xác nhận</option>
                <option value="confirmed">Đã xác nhận</option>
                <option value="cancelled">Đã hủy</option>
            </select>
            <input type="text" name="search" placeholder="Tìm kiếm mã đặt chỗ hoặc khách hàng...">
            <select name="event">
                <option value="">-- Chọn sự kiện --</option>
                <option value="hoa_nhac_mua_thu">Hòa Nhạc Mùa Thu</option>
                <option value="le_hoi_am_nhac">Lễ Hội Âm Nhạc</option>
                <option value="kich_ngay_xua">Kịch "Ngày Xưa"</option>
            </select>
            <button type="submit" class="btn">Tìm kiếm</button>
        </div>

        <div class="action-bar">
            <span>Tổng cộng: 15 đặt chỗ</span>
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Mã đặt chỗ</th>
                        <th>Khách hàng</th>
                        <th>Sự kiện</th>
                        <th>Số lượng vé</th>
                        <th>Tổng tiền</th>
                        <th>Ngày đặt</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>BK001245</td>
                        <td>Nguyễn Văn A</td>
                        <td>Hòa Nhạc Mùa Thu</td>
                        <td>2</td>
                        <td>3,000,000 VNĐ</td>
                        <td>14/03/2025 10:30</td>
                        <td>Chờ xác nhận</td>
                        <td>
                            <a href="#" class="btn btn-success">Xác nhận</a>
                            <a href="#" class="btn btn-danger" onclick="return confirm('Hủy đặt chỗ này?')">Hủy</a>
                            <a href="#" class="btn">Xem</a>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>BK001246</td>
                        <td>Trần Thị B</td>
                        <td>Lễ Hội Âm Nhạc</td>
                        <td>3</td>
                        <td>1,200,000 VNĐ</td>
                        <td>13/03/2025 15:45</td>
                        <td>Đã xác nhận</td>
                        <td>
                            <a href="#" class="btn">Xem</a>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>BK001247</td>
                        <td>Phạm Văn C</td>
                        <td>Kịch "Ngày Xưa"</td>
                        <td>1</td>
                        <td>200,000 VNĐ</td>
                        <td>12/03/2025 09:15</td>
                        <td>Đã hủy</td>
                        <td>
                            <a href="#" class="btn">Xem</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection