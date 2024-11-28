// JavaScript for checkout logic
document.addEventListener("DOMContentLoaded", function () {
    const basket = <?= json_encode($cart) ?>; // Import PHP cart data
    const totalPriceSpan = document.getElementById("total-price");

    // Calculate total price
    const calculateTotal = () => {
        let total = 0;
        basket.forEach(item => {
            total += item.price * item.quantity;
        });
        totalPriceSpan.textContent = total.toFixed(2);
    };

    calculateTotal(); // Run on page load
});
