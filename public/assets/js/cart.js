// Hàm định dạng giá tiền
function formatPrice(price) {
    return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
}

// Hàm chọn/bỏ chọn tất cả
function toggleSelectAll() {
    const selectAll = document.getElementById('select-all');
    const checkboxes = document.querySelectorAll('.cart-checkbox');
    checkboxes.forEach(checkbox => checkbox.checked = selectAll.checked);
    updateCartTotal();
}

// Hàm cập nhật tổng tiền
function updateCartTotal() {
    let total = 0;
    document.querySelectorAll('.cart-checkbox:checked').forEach(checkbox => {
        const cartId = checkbox.value;
        const totalElement = document.querySelector(`tr[data-cart-id="${cartId}"] .td-total`);
        if (totalElement && totalElement.dataset.total) {
            total += parseFloat(totalElement.dataset.total) || 0;
        }
    });
    document.getElementById('provisional-total').textContent = formatPrice(total) + 'đ';
    document.getElementById('cart-total').textContent = formatPrice(total) + 'đ';
}

function proceedToCheckout() {
    const selectedCarts = document.querySelectorAll('.cart-checkbox:checked');

    if (selectedCarts.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Cảnh báo',
            text: 'Vui lòng chọn ít nhất một sản phẩm để thanh toán!',
            confirmButtonColor: '#40A126'
        });
        return;
    }
    let cartIds = [];
    selectedCarts.forEach(checkbox => cartIds.push(checkbox.value));
    window.location.href = `/checkout?selected_carts=${cartIds.join(',')}`;
}


document.addEventListener('DOMContentLoaded', function () {
    document.querySelector('.btn-checkout').addEventListener('click', proceedToCheckout);
});

document.addEventListener('DOMContentLoaded', function () {
    const cartContainer = document.querySelector('.cart-inforItems');
    if (!cartContainer) return;

    cartContainer.addEventListener('click', function (event) {
        const button = event.target;
        if (!button.classList.contains('btn-minus') && !button.classList.contains('btn-plus')) return;

        event.preventDefault();
        const quantityContainer = button.closest('.quantity');
        const cartId = quantityContainer.getAttribute('data-cart-id');
        const input = quantityContainer.querySelector('.table-input');
        let quantity = parseInt(input.value) || 1;

        if (button.classList.contains('btn-minus') && quantity > 1) quantity -= 1;
        else if (button.classList.contains('btn-plus')) quantity += 1;

        input.value = quantity;
        updateCart(cartId, quantity);
    });

    cartContainer.addEventListener('input', function (event) {
        const input = event.target;
        if (!input.classList.contains('table-input')) return;

        const quantityContainer = input.closest('.quantity');
        const cartId = quantityContainer.getAttribute('data-cart-id');
        let quantity = parseInt(input.value) || 1;

        if (quantity < 1) {
            quantity = 1;
            input.value = 1;
        }

        updateCart(cartId, quantity);
    });

    function updateCart(cartId, quantity) {
        fetch(`/cart/update/${cartId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ update_cart: quantity })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Cập nhật tổng tiền sản phẩm
                const totalElement = document.querySelector(`tr[data-cart-id="${cartId}"] .td-total`);
                if (totalElement) {
                    totalElement.textContent = data.new_total; // Chuỗi định dạng từ server (VD: "1,000,000 đ")
                    totalElement.dataset.total = data.raw_total; // Giá trị số để tính tổng
                }
    
                // Cập nhật số lượng hiển thị
                const quantityElement = document.querySelector(`tr[data-cart-id="${cartId}"] .quantity_cart`);
                if (quantityElement) {
                    quantityElement.textContent = data.new_quantity; // Số lượng mới từ server
                }
    
                // Cập nhật tổng tiền chung
                updateCartTotal();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: data.message || 'Số lượng vé không đủ!',
                    confirmButtonColor: '#40A126'
                });
            }
        })
        .catch(error => {
            console.error('Update cart error:', error);
        });
    }
    
});
