@extends('layout_admin')

@section('title_admin', 'Quản Lý Người Dùng')

@section('css_admin')
<link rel="stylesheet" href="{{ asset('assets/admin_css/user.css') }}">
@endsection

@section('content_admin')
<div class="content">
    <h2>Quản Lý Người Dùng</h2>

    <form class="filter-form">
        <select name="role">
            <option value="">-- Chọn vai trò --</option>
            <option value="0">Admin</option>
            <option value="1">Người dùng</option>
        </select>
        <select name="status">
            <option value="">-- Chọn trạng thái --</option>
            <option value="0">Hoạt động</option>
            <option value="1">Bị cấm</option>
        </select>
        <input type="text" name="search" placeholder="Tìm kiếm tên, email, số điện thoại...">
        <button type="submit" class="btn">Tìm kiếm</button>
    </form>
    <div class="action-bar">
        <span>Tổng cộng: {{ $getData->total() }} người dùng</span>
        <a href="/admin/create_user" class="btn btn-success">Thêm người dùng</a>
    </div>
    <div class="pagination-info">
        Hiển thị từ {{ $getData->firstItem() }} đến {{ $getData->lastItem() }} trong tổng số {{ $getData->total() }} người dùng
        <span class="page-current">
            (Trang {{ $getData->currentPage() }} / {{ $getData->lastPage() }})
        </span>
    </div>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Email</th>
                    <th>Hình ảnh</th>
                    <th>Vai trò</th>
                    <th>Số điện thoại</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach($getData as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <img src="{{ $user->img ? asset($user->img) : asset('/assets/img/default-avatar.png') }}"
                            alt="Avatar" width="50" height="50">
                    </td>
                    <td>{{ $user->role ?? 'Người dùng' }}</td>
                    <td>{{ $user->phone ?? 'Chưa cập nhật' }}</td>
                    <td>
                        @if($user->status === 0)
                        <span class="status active">Hoạt động</span>
                        @else
                        <span class="status banned">Bị cấm</span>
                        @endif
                    </td>
                    <td style="display: flex;">
                        <a href="{{ route('admin.detail.user',$user->id) }}" class="btn">Xem</a>
                        <form action="{{ route('admin.delete.user', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Xóa người dùng này ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination">
            <span class="prev {{ $getData->onFirstPage() ? 'disabled' : '' }}">
                <a href="{{ $getData->previousPageUrl() }}" rel="prev">« Prev</a>
            </span>
            @foreach ($getData->getUrlRange(1, $getData->lastPage()) as $page => $url)
            <span class="page {{ $getData->currentPage() == $page ? 'current' : '' }}">
                <a href="{{ $url }}">{{ $page }}</a>
            </span>
            @endforeach
            <span class="next {{ $getData->hasMorePages() ? '' : 'disabled' }}">
                <a href="{{ $getData->nextPageUrl() }}" rel="next">Next »</a>
            </span>
        </div>
    </div>
</div>
@endsection