document.addEventListener("DOMContentLoaded", function () {
    const citySelect = document.getElementById("city");
    const districtSelect = document.getElementById("district");

    // Tải danh sách tỉnh/thành phố
    fetch("https://provinces.open-api.vn/api/p/")
        .then(response => response.json())
        .then(data => {
            data.forEach(city => {
                let option = document.createElement("option");
                option.value = city.name;       // Gán tên vào value thay vì code
                option.textContent = city.name; // Hiển thị tên
                option.setAttribute('data-code', city.code); // Lưu code vào data attribute (nếu cần sau này)
                citySelect.appendChild(option);
            });
        })
        .catch(error => console.error("Lỗi khi tải danh sách tỉnh/thành:", error));

    // Khi chọn tỉnh/thành, tải danh sách quận/huyện
    citySelect.addEventListener("change", function () {
        let selectedOption = this.options[this.selectedIndex];
        let provinceCode = selectedOption.getAttribute('data-code'); // Lấy code từ data attribute
        districtSelect.innerHTML = '<option value="">Chọn quận/huyện</option>'; 

        if (provinceCode) {
            fetch(`https://provinces.open-api.vn/api/p/${provinceCode}?depth=2`)
                .then(response => response.json())
                .then(data => {
                    data.districts.forEach(district => {
                        let option = document.createElement("option");
                        option.value = district.name;       // Gán tên vào value thay vì code
                        option.textContent = district.name; // Hiển thị tên
                        districtSelect.appendChild(option);
                    });
                })
                .catch(error => console.error("Lỗi khi tải danh sách quận/huyện:", error));
        }
    });
});