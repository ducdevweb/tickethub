<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Xác nhận đơn hàng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 8px;
        }

        .header {
            background: #28a745;
            color: white;
            padding: 15px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }

        .content {
            padding: 20px;
            background: white;
            border-radius: 0 0 8px 8px;
        }

        .content table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .content table th,
        .content table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        .content table th {
            background: #f1f1f1;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #888;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Xác nhận đơn hàng #{{ $order->id_order }}</h2>

        </div>
        <div class="content">
            <p>Kính gửi {{ $order->name }},</p>
            <p>Cảm ơn bạn đã đặt hàng! Dưới đây là chi tiết đơn hàng của bạn:</p>

            <h3>Thông tin đơn hàng</h3>
            <p><strong>Email:</strong> {{ $order->email }}</p>
            <p><strong>Địa chỉ:</strong> {{ $order->address }}</p>
            <p><strong>Số điện thoại:</strong> {{ $order->phone }}</p>
            <p><strong>Trạng thái:</strong> {{ $order->status }}</p>

            <h3>Chi tiết sản phẩm</h3>
            <table>
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Trang thái</th>
                        <th>Tổng</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($checkouts as $checkout)
                    @php
                    $price = $checkout->ticket->sale_ticket > 0 ? $checkout->ticket->sale_ticket : $checkout->ticket->price_ticket;
                    $total = $price * $checkout->quantity_cart;
                    @endphp
                    <tr>
                        <td>{{ $checkout->ticket->name_ticket }}</td>
                        <td>{{ $checkout->quantity_cart }}</td>
                        <td>{{ number_format($price, 0, ',', '.') }} VND</td>
                        <td>{{ $checkout->status }}</td>
                        <td>{{ number_format($total, 0, ',', '.') }} VND</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <h3>Tổng cộng: {{ number_format($checkouts->sum('total_cart'), 0, ',', '.') }} VND</h3>
        </div>

        @if($order->status == 'Chờ thanh toán')
        <div style="text-align: center; margin-top: 20px;">
            <a href="{{ $vnpayUrl }}" class="btn" style="background: #ff5722; padding: 10px 20px; color: white; text-decoration: none; border-radius: 5px;">
                Thanh toán ngay
            </a>
        </div>
        @endif
        <div class="footer">
            <p>Trân trọng,<br>{{ config('app.name') }}</p>
        </div>
    </div>
</body>

</html>