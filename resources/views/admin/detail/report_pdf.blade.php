<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Giao Dịch</title>
    <style>
        @font-face {
            font-family: "DejaVu Sans";
            font-style: normal;
            font-weight: normal;
            src: url("{{ storage_path('fonts/DejaVuSans.ttf') }}") format("truetype");
        }

        * {
            font-family: "DejaVu Sans", sans-serif;
        }

        body {
            padding: 20px;
            font-size: 14px;
            line-height: 1.5;
        }

        h2 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

        .summary {
            margin-top: 20px;
            font-weight: bold;
            text-align: right;
        }
    </style>
</head>

<body>

    <h2>Chi Tiết Giao Dịch</h2>

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
            @foreach ($report as  $item)
            <tr>
                <td>{{ $item->id_detail }}</td>
                <td>{{ $item->event->name_event ?? 'Không xác định' }}</td>
                <td>{{ $item->order->user->name ?? 'Ẩn danh' }}</td>
                <td>{{ $item->ticket->type_ticket ?? 'N/A' }}</td>
                <td>{{ $item->seri_ticket ?? 'N/A' }}</td>
                <td>{{ $item->quantity ?? 0 }}</td>
                <td>{{ number_format($item->total, 0, ',', '.') }} VNĐ</td>
                <td>{{ date('d/m/Y H:i', strtotime($item->created_at)) }}</td>
                <td>{{ $item->order->status }} </td>
            </tr>
            @endforeach

        </tbody>
    </table>

</body>

</html>