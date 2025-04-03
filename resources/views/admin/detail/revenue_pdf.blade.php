<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Doanh Thu</title>
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
            color: #333;
        }
        h2 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f4;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        p {
            margin: 5px 0;
        }
        .summary {
            text-align: right;
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<h2>Chi Tiết Doanh Thu - {{ $event->name_event }}</h2>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Seri Vé</th>
            <th>Loại Vé</th>
            <th>Khách Hàng</th>
            <th>Ngày Đặt</th>
            <th>Giá Vé</th>
        </tr>
    </thead>
    <tbody>
        @foreach($detail_event as $index => $detail)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $detail->seri_ticket }}</td>
            <td>{{ $detail->ticket->cate->name_cate }}</td>
            <td>{{ $detail->order->user->name }}</td>
            <td>{{ $detail->created_at->format('d/m/Y') }}</td>
            <td>{{ number_format($detail->total, 0, ',', '.') }} VNĐ</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="summary">
    <p><strong>Tổng Doanh Thu:</strong> {{ number_format($revenue, 0, ',', '.') }} VNĐ</p>
    <p><strong>Số Vé Đã Bán:</strong> {{ $ticket_sold }}</p>
    <p><strong>Doanh Thu Trung Bình/Vé:</strong> {{ number_format($avg ?? 0, 0, ',', '.') }} VNĐ</p>
</div>

</body>
</html>
