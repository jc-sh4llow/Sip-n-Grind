<?php
session_start();

// Check if cart data exists in session
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    // Redirect to Order Now page if cart is empty
    header('Location: order_now.php');
    exit();
}

$cart = $_SESSION['cart']; // Retrieve cart data from session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
</head>
<body>

<h1>Your Cart</h1>

<div id="checkout-cart">
    <?php
    // Loop through the cart and display items
    foreach ($cart as $itemKey => $item) {
        echo "<div class='cart-item'>";
        echo "<p>Name: " . $item['name'] . "</p>";
        echo "<p>Size: " . $item['size'] . "</p>";
        echo "<p>Price: ₱" . number_format($item['price'], 2) . "</p>";
        echo "<p>Quantity: " . $item['quantity'] . "</p>";
        echo "<hr>";
        echo "</div>";
    }
    ?>
</div>


<!-- Optional: Collect customer info -->
<form action="process_order.php" method="POST">
    <h3>Customer Information</h3>
    <label for="customer_name">Name:</label>
    <input type="text" id="customer_name" name="customer_name" required><br>

    <label for="customer_address">Address:</label>
    <textarea id="customer_address" name="customer_address" required></textarea><br>

    <label for="customer_phone">Phone Number:</label>
    <input type="text" id="customer_phone" name="customer_phone" required><br>

    <button type="submit">Submit Order</button>
</form>

</body>
</html>
