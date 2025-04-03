document.addEventListener("DOMContentLoaded", function () {
    const accountInfo = document.getElementById("account-info");
    const menuAccount = document.getElementById("menu-account");

    accountInfo.addEventListener("click", function (event) {
        event.stopPropagation();
        menuAccount.classList.toggle("show");
    });

    document.addEventListener("click", function (event) {
        if (!menuAccount.contains(event.target) && !accountInfo.contains(event.target)) {
            menuAccount.classList.remove("show");
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const transition = document.getElementById("page-transition");
    const links = document.querySelectorAll("a[href]");
    
    links.forEach(link => {
        link.addEventListener("click", function (e) {
            const href = this.getAttribute("href");
            if (href && href !== "#" && href !== "" && this.target !== "_blank" && !this.hasAttribute("download")) {
                e.preventDefault();
                transition.classList.add("active");
                setTimeout(() => {
                    window.location.href = href;
                }, 1000);
            }
        });
    });

    const forms = document.querySelectorAll("form:not(#chat-form)"); 
    forms.forEach(form => {
        form.addEventListener("submit", function (e) {
            if (form.target === "_blank") return;
            e.preventDefault();
            transition.classList.add("active");
            setTimeout(() => {
                form.submit();
            }, 1000);
        });
    });

    window.addEventListener("load", function () {
        setTimeout(() => {
            transition.classList.remove("active");
        }, 1000);
    });

    window.addEventListener("pageshow", function (event) {
        if (event.persisted) { 
            transition.classList.remove("active");
        }
    });
});
document.addEventListener('DOMContentLoaded', function () {
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileNav = document.getElementById('mobile-nav');
    const mobileNavClose = document.getElementById('mobile-nav-close');
    const overlay = document.getElementById('overlay');
    const mobileCartIcon = document.getElementById('mobile-cart-icon');
    const mobileMiniCart = document.getElementById('mobile-mini-cart');
    const mobileAccountInfo = document.getElementById('mobile-account-info');
    const mobileMenuAccount = document.getElementById('mobile-menu-account');

    if (mobileMenuToggle && mobileNav && mobileNavClose && overlay) {
        mobileMenuToggle.addEventListener('click', function () {
            mobileNav.classList.toggle('active');
            overlay.classList.toggle('active');
            document.body.classList.toggle('no-scroll');
            mobileMenuToggle.classList.toggle('active');
        });

        mobileNavClose.addEventListener('click', function () {
            mobileNav.classList.remove('active');
            overlay.classList.remove('active');
            document.body.classList.remove('no-scroll');
            mobileMenuToggle.classList.remove('active');
        });

        overlay.addEventListener('click', function () {
            mobileNav.classList.remove('active');
            overlay.classList.remove('active');
            document.body.classList.remove('no-scroll');
            mobileMenuToggle.classList.remove('active');
            if (mobileMiniCart) mobileMiniCart.style.display = 'none';
            if (mobileCartIcon) mobileCartIcon.classList.remove('active');
            if (mobileMenuAccount) mobileMenuAccount.style.display = 'none';
            if (mobileAccountInfo) mobileAccountInfo.classList.remove('active');
        });
    }

    if (mobileCartIcon && mobileMiniCart) {
        mobileCartIcon.addEventListener('click', function () {
            mobileCartIcon.classList.toggle('active');
            mobileMiniCart.style.display = mobileMiniCart.style.display === 'block' ? 'none' : 'block';
        });
    }

    if (mobileAccountInfo && mobileMenuAccount) {
        mobileAccountInfo.addEventListener('click', function (event) {
            event.stopPropagation();
            mobileAccountInfo.classList.toggle('active');
            mobileMenuAccount.style.display = mobileMenuAccount.style.display === 'block' ? 'none' : 'block';
        });
    }

    document.addEventListener('click', function (event) {
        if (mobileAccountInfo && mobileMenuAccount && !mobileAccountInfo.contains(event.target)) {
            mobileMenuAccount.style.display = 'none';
            mobileAccountInfo.classList.remove('active');
        }
        if (mobileCartIcon && mobileMiniCart && !mobileCartIcon.contains(event.target)) {
            mobileMiniCart.style.display = 'none';
            mobileCartIcon.classList.remove('active');
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    let cartIcon = document.querySelector(".cart-icon");
    let miniCart = document.querySelector(".mini-cart");

    cartIcon.addEventListener("mouseenter", function () {
        miniCart.style.display = "block";
    });

    cartIcon.addEventListener("mouseleave", function () {
        setTimeout(() => {
            if (!miniCart.matches(":hover")) {
                miniCart.style.display = "none";
            }
        }, 300);
    });

    miniCart.addEventListener("mouseleave", function () {
        miniCart.style.display = "none";
    });

    miniCart.addEventListener("mouseenter", function () {
        miniCart.style.display = "block";
    });
});
