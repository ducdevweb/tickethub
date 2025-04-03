    @extends('layout_admin')

    @section('title_admin', 'Quản Lý Doanh Thu')
    @section('css_admin')
    <link rel="stylesheet" href="{{ asset('assets/admin_css/revenue.css') }}">
    @endsection

    @section('content_admin')
        <div class="content">
            <h2>Quản Lý Doanh Thu</h2>

            <form class="filter-form">
                <select name="event">
                    <option value=""> -- Lọc sự kiện --</option>
                    <option value="desc">Bán nhiều vé nhất</option>
                    <option value="asc">Ít vé nhất</option>
                    <option value="near">Bán ngày gần nhất</option>
                    <option value="distant">Ngày xa nhất</option>
                </select>
                <input type="date" name="start_date" placeholder="Từ ngày">
                <input type="date" name="end_date" placeholder="Đến ngày">
                <input type="text" name="search" placeholder="Tìm kiếm theo tên sự kiện...">
                <button type="submit" class="btn">Lọc</button>
            </form>

            <div class="revenue-summary">
                <div class="summary-card">
                    <h3>Tổng doanh thu</h3>
                    <p class="number">{{ number_format($data['revenue'], 0, ',', '.') }} VNĐ</p>
                </div>
                <div class="summary-card">
                    <h3>Số vé đã bán</h3>
                    <p class="number">{{ $data['ticket_sold'] }}</p>
                </div>
                <div class="summary-card">
                    <h3>Doanh thu trung bình/vé</h3>
                    <p class="number">{{ number_format($data['average_revenue'], 0, ',', '.') }} VNĐ</p>
                </div>
            </div>

            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Sự kiện</th>
                            <th>Ngày diễn ra</th>
                            <th>Số vé bán</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['events'] as $event)
                            <tr>
                                <td>{{ $event->id_event }}</td>
                                <td>{{ $event->name_event }}</td>
                                <td>{{ $event->date_start }}</td>
                                <td>{{ $event->sold_ticket ?? 0 }}</td>
                                <td>{{ number_format($event->detailOrder->sum('total') ?? 0, 0, ',', '.') }} VNĐ</td>
                                <td>Hoàn tất</td>
                                <td>
                                    <a href="{{ route('admin.detail.revenue',$event->id_event) }}" class="btn">Xem chi tiết</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="action-buttons">
                <a href="#" class="btn btn-success">Xuất báo cáo</a>
            </div>
        </div>
    @endsection
