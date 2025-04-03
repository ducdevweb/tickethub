@extends('layout_admin')

@section('title_admin', 'Quản Lý Vé')

@section('css_admin')
<link rel="stylesheet" href="{{ asset('assets/admin_css/ticket.css') }}">
@endsection

@section('content_admin')
<style>
    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 15px;
        gap: 10px;
    }

    .pagination .page-item {
        list-style: none;
    }

    .pagination .page-link {
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 5px;
        text-decoration: none;
        color: #333;
        transition: 0.2s;
    }

    .pagination .page-link:hover {
        background-color: #f0f0f0;
    }

    .pagination .active .page-link {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
    }

    .pagination .disabled .page-link {
        color: #aaa;
        pointer-events: none;
    }

    @media (max-width: 768px) {
        .pagination {
            flex-wrap: wrap;
        }

        .pagination .page-link {
            padding: 6px 10px;
            font-size: 14px;
        }
    }
</style>
<div class="content">
    <h2>Quản Lý Vé</h2>

    <form class="filter-form">
        <input type="text" name="search" placeholder="Tìm kiếm theo tên vé...">
        <select name="id_event">
            <option value="">-- Chọn sự kiện --</option>
            @foreach($event as $ev)
            <option value="{{ $ev->id_event }}">{{ $ev->name_event }}</option>
            @endforeach
        </select>

        <select name="id_cate">
            <option value="">-- Chọn danh mục --</option>
            @foreach($cate as $ct)
            <option value="{{ $ct->id_cate }}">{{ $ct->name_cate }}</option>
            @endforeach
        </select>

        <select name="quantity">
            <option value="">-- Lọc số lượng --</option>
            <option value="asc">Ít nhất</option>
            <option value="desc">Nhiều nhất</option>
        </select>

        <select name="price">
            <option value="">-- Lọc giá tiền --</option>
            <option value="asc">Giá thấp nhất</option>
            <option value="desc">Giá cao nhất</option>
        </select>

        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
        <button type="button" class="btn btn-secondary" onclick="resetForm()">Xóa Lọc</button>
    </form>

    <div class="action-bar">
        <a href="/admin/create_ticket" class="btn btn-success">Thêm vé mới</a>
    </div>



    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Tên Vé</th>
                    <th>Sự Kiện</th>
                    <th>Danh Mục</th>   
                    <th>Giá (VNĐ)</th>
                    <th>Số Lượng</th>
                    <th>Ẩn/Hiện</th>
                    <th>Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tickets as $tk)
                <tr>
                    <td>{{ $tk->name_ticket }}</td>
                    <td>{{ $tk->event->name_event }}</td>
                    <td>{{ $tk->cate->name_cate }}</td>
                    <td>{{ $tk->sale_ticket>0?$tk->sale_ticket:$tk->price_ticket }}</td>
                    <td>{{ $tk->quantity_ticket }}</td>
                    <td><span class="status">{{ $tk->hidden_ticket==0?'Hiện':'Ẩn' }}</span></td>
                    <td>
                        <a href="{{ route('admin.detail.ticket',$tk->id_ticket) }}" class="btn">Xem</a>
                        <form action="{{ route('admin.delete.ticket', $tk->id_ticket) }}" method="POST" style="display:inline;" onsubmit="return confirm('Xóa vé này ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="pagination-info">
            Hiển thị từ {{ $tickets->firstItem() ?? 0 }} đến {{ $tickets->lastItem() ?? 0 }} trong tổng số {{ $tickets->total() }} vé
            <span class="page-current">(Trang {{ $tickets->currentPage() }} / {{ $tickets->lastPage() }})</span>
        </div>

        <div class="pagination">
            {{ $tickets->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>

    </div>
</div>

<script>
    function resetForm() {
        const form = document.querySelector('.filter-form');
        form.reset();
        form.submit();
    }
</script>
@endsection