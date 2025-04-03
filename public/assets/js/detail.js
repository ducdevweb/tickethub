document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".detail-input").forEach(function (quantityDiv) {
        let minusButton = quantityDiv.querySelector(".detail-minus");
        let plusButton = quantityDiv.querySelector(".detail-plus");
        let input = quantityDiv.querySelector(".table-input");

        minusButton.addEventListener("click", function (e) {
            e.preventDefault()
            let value = parseInt(input.value) || 1;
            let minValue = parseInt(input.min) || 1;

            if (value > minValue) {
                input.value = value - 1;
            }
        });

        plusButton.addEventListener("click", function (e) {
            e.preventDefault()
            let value = parseInt(input.value) || 1;
            input.value = value + 1;
        });
    });
});
document.addEventListener("DOMContentLoaded", function () {
    const dropdown = document.querySelector(".dropdown");
    const toggle = document.querySelector(".dropdown-toggle");

    toggle.addEventListener("click", function () {
        dropdown.classList.toggle("active");
    });

    document.addEventListener("click", function (e) {
        if (!dropdown.contains(e.target)) {
            dropdown.classList.remove("active");
        }
    });
});
const image = document.getElementById("main-image");

image.addEventListener("mousemove", (event) => {
    const { left, top, width, height } = image.getBoundingClientRect();
    const xPercent = ((event.clientX - left) / width) * 100;
    const yPercent = ((event.clientY - top) / height) * 100;

    image.style.transformOrigin = `${xPercent}% ${yPercent}%`;
    image.style.transform = "scale(2)";
});

image.addEventListener("mouseleave", () => {
    image.style.transform = "scale(1)";
});

function showContent(event, type) {
    event.preventDefault();

    var describe = document.getElementById("describe");
    var comment = document.getElementById("comment");

    if (type === "describe") {
        describe.style.display = "block";
        comment.style.display = "none";
        relate.style.display = 'none'
    } else if (type === "comment") {
        describe.style.display = "none";
        comment.style.display = "block";
        relate.style.display = 'none'
    } else if (type === "relate") {
        describe.style.display = "none";
        comment.style.display = "none";
        relate.style.display = 'block'
    }


}
document.addEventListener("DOMContentLoaded", function () {
    var modal = document.getElementById("reviewModal");
    var btn = document.getElementById("openReviewForm");
    var closeBtn = document.querySelector(".close");

    if (btn) {
        btn.onclick = function () {
            modal.style.display = "block";
        };
    }

    if (closeBtn) {
        closeBtn.onclick = function () {
            modal.style.display = "none";
        };
    }

    window.onclick = function (event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    };

    // Xử lý chọn sao
    var stars = document.querySelectorAll(".star");
    var ratingValue = document.getElementById("ratingValue");

    if (stars.length > 0 && ratingValue) {
        stars.forEach(star => {
            star.addEventListener("click", function () {
                var value = parseInt(this.getAttribute("data-value"), 10); 
                ratingValue.value = value;
                stars.forEach(s => s.classList.remove("selected"));
                for (var i = 0; i < value; i++) {
                    stars[i].classList.add("selected");
                }
            });
        });
    }
});


document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("reviewModal");
    const btnOpen = document.getElementById("openReviewModal");
    const btnClose = document.querySelector(".close");

    btnOpen.addEventListener("click", function () {
        modal.style.display = "block";
    });

    btnClose.addEventListener("click", function () {
        modal.style.display = "none";
    });

    window.addEventListener("click", function (event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });
});
