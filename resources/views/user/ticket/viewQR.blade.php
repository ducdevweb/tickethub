<!DOCTYPE html>
<html>
<head>
    <title>Thông tin vé</title>
</head>
<body>
    <h1>Thông tin vé</h1>
    <p><strong>Tên vé:</strong> {{ $ticket->name_ticket }}</p>
    <p><strong>Giá:</strong> {{ number_format($ticket->price_ticket, 0, ',', '.') }} VND</p>
    <p><strong>Mô tả:</strong> {{ $ticket->description }}</p>
</body>
</html>
