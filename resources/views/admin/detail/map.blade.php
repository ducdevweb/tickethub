@extends('layout_admin')

@section('title_admin', 'Bản Đồ & Thời Tiết Sự Kiện')

@section('content_admin')
<div class="content">
    <h2>Bản Đồ Sự Kiện: {{ $event->name_event }}</h2>
    <div id="map" style="height: 500px;"></div>
    <div id="weather" style="margin-top: 10px; font-size: 18px;"></div>
</div>

<script>
    window.onload = function() {
        var location = "{{ $event->location }}";
        var weatherApiKey = "6b837da8a583463c970172126252503";  // 🔑 Đặt API Key của bạn tại đây
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
                        alert('Không tìm thấy tọa độ cho địa điểm này.Vui lòng cập nhật lại');
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
