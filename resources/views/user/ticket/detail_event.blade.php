@extends('layout')
@section('title')
    Chi tiết {{ $event->name_event }}
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/detail_event.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/ticket_workshop.css') }}">
@endsection
@section('content')

<div id="detail-event">
    <div class="banner-detail">
        <div class="location-detail">
            <div class="logo-detail">
                <img src="/assets/img/logo.png" alt="Tickethub">
            </div>
            <div class="address-detail">
                <h2>Tickethub</h2>
                <p><i class="fa-solid fa-location-dot"></i> Hà Nội, Việt Nam</p>
                <p><i class="fa-solid fa-phone"></i> <span class="phone">0899934886</span></p>
                <p><i class="fa-solid fa-envelope"></i> office@tickethub.vn</p>
                <p class="no-rating">Chưa có đánh giá!</p>
            </div>
        </div>
        <div class="banner-mini">
            <img src="/assets/img/trend3.jpg" alt="Event Banner">
        </div>
    </div>

    <div class="detail-product">
        <div class="infor-detail">
            <div class="detail-img">
                <img src="{{ asset($event->event_img) }}" id="main-image" alt="{{ $event->name_event }}">
            </div>
            <div class="detail-text">
                <h1 class="name-detail">{{ $event->name_event }}</h1>
                <hr style="margin-bottom: 20px;">
                <p class="detail-content">{{ $event->description_event ?? 'Chưa có mô tả sự kiện.' }}</p>
                <div class="detail-location">
                    <b style="color: #40A216;">Địa điểm:</b> {{ $event->location }}
                </div>
                <div class="detail-time">
                    <b style="color: #40A216;">Thời gian:</b> 
                    Từ {{\Carbon\Carbon::parse($event->date_start)->format('d/m/Y') }} đến {{ \Carbon\Carbon::parse($event->date_end)->format('d/m/Y') }}
                </div>
                <div class="detail-tickets">
                    <b style="color: #40A216;">Vé:</b> 
                    Đã bán {{ $event->sold_ticket }} / {{ $event->max_ticket }} vé
                    @if ($event->sold_ticket >= $event->max_ticket)
                        <span style="color: red;"> (Hết vé)</span>
                    @endif
                </div>
                <div id="map" style="height: 500px;"></div>
                <div id="weather" style="margin-top: 10px; font-size: 18px;"></div>
                @if (!empty($event->tickets))
                    <div class="event-tickets">
                        <b style="color: #40A216;">Danh sách vé:</b>
                        <ul>
                            @foreach ($event->tickets as $ticket)
                                <li>
                                    <a href="{{ route('ticket.detail', $ticket->id_ticket) }}">{{ $ticket->name_ticket }}</a> - 
                                    Giá: {{ number_format($ticket->sale_ticket > 0 ? $ticket->sale_ticket : $ticket->price_ticket) }}đ
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>

        <div class="sidebar">
            <h2 style="font-size: 22px; margin-bottom: 25px; font-weight: 500;">Bạn tìm gì hôm nay?</h2>
            <form action="{{ route('search') }}" method="GET" class="sidebar-form">
                <input type="text" name="search" class="sidebar-search" placeholder="Tìm sản phẩm...">
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>
            <h2 style="font-size: 22px; margin-bottom: 25px; font-weight: 500;">Danh mục sản phẩm</h2>
            <form action="" method="GET" class="sidebar-form2">
                <div class="dropdown">
                    <div class="dropdown-toggle">
                        Chọn loại vé
                        <span>▼</span>
                    </div>
                    <ul class="dropdown-menu">
                        <li><a style="text-decoration: none; color: #333333;" href="/ticket/music">Âm nhạc</a></li>
                        <li><a style="text-decoration: none; color: #333333;" href="/ticket/workshop">Hội thảo</a></li>
                        <li><a style="text-decoration: none; color: #333333;" href="/ticket/tour">Tham quan</a></li>
                    </ul>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    window.onload = function() {
        var location = "{{ $event->location }}";
        var weatherApiKey = "6b837da8a583463c970172126252503";  // 🔑 Đặt API Key của bạn tại đây

        // 📍 Lấy tọa độ từ Nominatim
        function getCoordinates(location) {
            const apiURL = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(location)}`;
            
            fetch(apiURL)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        let lat = data[0].lat;
                        let lon = data[0].lon;
                        initMap(lat, lon);
                        getWeather(lat, lon);
                    } else {
                        console.error("Không tìm thấy tọa độ cho địa điểm này.");
                    }
                })
                .catch(err => console.error("Lỗi khi gọi API:", err));
        }

        // 🏙️ Hiển thị bản đồ
        function initMap(lat, lng) {
            if (typeof L === 'undefined') {
                console.error("Leaflet.js chưa được tải!");
                return;
            }

            var map = L.map('map').setView([lat, lng], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);
            
            L.marker([lat, lng]).addTo(map)
                .bindPopup("📍 {{ $event->name_event }} - " + location)
                .openPopup();
        }

        // 🌤️ Lấy dữ liệu thời tiết từ WeatherAPI
        function getWeather(lat, lon) {
            const weatherURL = `https://api.weatherapi.com/v1/current.json?key=${weatherApiKey}&q=${lat},${lon}&lang=vi`;

            fetch(weatherURL)
                .then(response => response.json())
                .then(data => {
                    if (data.current) {
                        const temp = data.current.temp_c;
                        const condition = data.current.condition.text;
                        const icon = data.current.condition.icon;
                        const humidity = data.current.humidity;
                        const wind = data.current.wind_kph;

                        document.getElementById('weather').innerHTML = `
                            <strong>🌤️ Thời Tiết Tại ${location}:</strong><br>
                            <img src="${icon}" alt="Weather Icon" style="vertical-align: middle;"> 
                            - Nhiệt độ: ${temp}°C<br>
                            - Trạng thái: ${condition}<br>
                            - Độ ẩm: ${humidity}%<br>
                            - Gió: ${wind} km/h
                        `;
                    } else {
                        console.error("Lỗi lấy dữ liệu thời tiết:", data.error.message);
                    }
                })
                .catch(err => console.error("Lỗi khi gọi API thời tiết:", err));
        }

        // ⚙️ Bắt đầu gọi hàm
        getCoordinates(location);
    };
</script>
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
@endsection