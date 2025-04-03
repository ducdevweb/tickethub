var banner1 = document.getElementById('banner1');
var banner2 = document.getElementById('banner2');

function changeBanner() {
    if (banner1.style.display === 'block') {
        banner1.style.display = 'none';
        banner2.style.display = 'block';
    } else {
        banner1.style.display = 'block';
        banner2.style.display = 'none';
    }
    setTimeout(changeBanner, 2000);
}

banner1.style.display = 'block';
banner2.style.display = 'none';
setTimeout(changeBanner, 3000);
var texts = ["Dịch Vụ", "Sự Kiện", "Điểm Đến"];
var index = 0;
var charIndex = 0;
var currentText = "";
var typingSpeed = 300;

var textElement = document.getElementById("text-1");

function typeEffect() {
    if (charIndex < texts[index].length) {
        currentText += texts[index][charIndex];
        textElement.innerHTML = currentText;
        charIndex++;
        setTimeout(typeEffect, typingSpeed);
    } else {
        setTimeout(eraseEffect, 1000);
    }
}

function eraseEffect() {
    if (charIndex > 0) {
        currentText = currentText.slice(0, -1);
        textElement.innerHTML = currentText;
        charIndex--;
        setTimeout(eraseEffect, 50);
    } else {
        index = (index + 1) % texts.length;
        setTimeout(typeEffect, 500);
    }
}

typeEffect();
document.addEventListener("DOMContentLoaded", function () {
    const tabs = document.querySelectorAll(".tab-text");

    tabs.forEach(tab => {
        tab.addEventListener("click", function (e) {
            e.preventDefault();
            tabs.forEach(item => item.classList.remove("active"));
            this.classList.add("active");
        });
    });
});
document.addEventListener("DOMContentLoaded", function () {
    const location = document.querySelectorAll('text-lc');
    location.forEach(loc => {
        loc.addEventListener("click", function (e) {
            e.preventDefault();
            location.forEach(item => item.classList.remove('location-active'));
            this.classList.add('location-active')

        })
    })
})
document.addEventListener("DOMContentLoaded", function () {
    const proposeContent = document.querySelector(".propose-content");
    const dots = document.querySelectorAll(".dot");

    let currentPage = 0;
    const totalPages = dots.length;

    function updateSlider() {
        proposeContent.style.transform = `translateX(-${currentPage * 100}%)`;

        dots.forEach(dot => dot.classList.remove("active"));
        dots[currentPage].classList.add("active");
    }

    dots.forEach(dot => {
        dot.addEventListener("click", function () {
            currentPage = parseInt(this.dataset.page);
            updateSlider();
        });
    });

    updateSlider();
});
document.addEventListener('DOMContentLoaded', function() {
    const proposeImgs = document.querySelectorAll('.propose-img');

    function isTouchDevice() {
        return 'ontouchstart' in window || navigator.maxTouchPoints > 0 || navigator.msMaxTouchPoints > 0;
    }

    proposeImgs.forEach(img => {
        if (isTouchDevice()) {
            let isActive = false;

            img.addEventListener('click', function(e) {
                e.preventDefault();
                isActive = !isActive;
                proposeImgs.forEach(otherImg => {
                    if (otherImg !== img) {
                        otherImg.classList.remove('active');
                    }
                });
                if (isActive) {
                    img.classList.add('active');
                } else {
                    img.classList.remove('active');
                }
            });

            document.addEventListener('click', function(e) {
                if (!img.contains(e.target)) {
                    img.classList.remove('active');
                    isActive = false;
                }
            });
        }
    });
});