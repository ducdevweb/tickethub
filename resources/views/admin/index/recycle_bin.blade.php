@extends('layout_admin')

@section('title_admin', 'Thùng Rác')

@section('css_admin')
    <link rel="stylesheet" href="{{ asset('assets/admin_css/recycle_bin.css') }}">
@endsection

@section('content_admin')
    <div class="content">
        <h2>Thùng Rác</h2>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($data['events']->isEmpty() && $data['tickets']->isEmpty() && $data['users']->isEmpty())
            <p class="text-muted">Không có gì trong thùng rác.</p>
        @else
            @if ($data['events']->isNotEmpty())
                <h3>Sự Kiện</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên</th>
                            <th>Ngày Xóa</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['events'] as $event)
                            <tr>
                                <td>{{ $event->id_event }}</td>
                                <td>{{ $event->name_event }}</td>
                                <td>{{ $event->deleted_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <form action="{{ route('admin.restore.event', $event->id_event) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-primary btn-sm">Khôi Phục</button>
                                    </form>
                                    <form action="{{ route('admin.force-delete.event', $event->id_event) }}" method="POST" style="display:inline;" onsubmit="return confirm('Xóa vĩnh viễn?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Xóa Hẳn</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            @if ($data['tickets']->isNotEmpty())
                <h3>Vé</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên</th>
                            <th>Ngày Xóa</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['tickets'] as $ticket)
                            <tr>
                                <td>{{ $ticket->id_ticket }}</td>
                                <td>{{ $ticket->name_ticket }}</td>
                                <td>{{ $ticket->deleted_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <form action="{{ route('admin.restore.ticket', $ticket->id_ticket) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-primary btn-sm">Khôi Phục</button>
                                    </form>
                                    <form action="{{ route('admin.force-delete.ticket', $ticket->id_ticket) }}" method="POST" style="display:inline;" onsubmit="return confirm('Xóa vĩnh viễn?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Xóa Hẳn</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            @if ($data['users']->isNotEmpty())
                <h3>Người Dùng</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên</th>
                            <th>Ngày Xóa</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['users'] as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->deleted_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <form action="{{ route('admin.restore.user', $user->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-primary btn-sm">Khôi Phục</button>
                                    </form>
                                    <form action="{{ route('admin.force-delete.user', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Xóa vĩnh viễn?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Xóa Hẳn</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        @endif

        <div class="action-buttons">
            <a href="{{ route('admin.index.event') }}" class="btn">Quay Lại</a>
        </div>
    </div>
@endsection