<?php
session_start();

// Check if the cart session exists
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header('Location: order_now.php');
    exit();
}

$cart = $_SESSION['cart'];
$customer_name = $_POST['customer_name'];
$customer_address = $_POST['customer_address'];
$customer_phone = $_POST['customer_phone'];

// Connect to your database
$pdo = new PDO('mysql:host=localhost;dbname=your_db', 'username', 'password');

// Insert order into the orders table
$stmt = $pdo->prepare("INSERT INTO orders (customer_name, customer_address, customer_phone, total_price, created_at) VALUES (?, ?, ?, ?, NOW())");
$stmt->execute([$customer_name, $customer_address, $customer_phone, calculateTotalPrice($cart)]);

$order_id = $pdo->lastInsertId(); // Get the last inserted order ID

// Insert each cart item into the order_items table
foreach ($cart as $item) {
    $stmt = $pdo->prepare("INSERT INTO order_items (order_id, item_id, size_id, quantity, customizations, item_price) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$order_id, $item['item_id'], $item['size_id'], $item['quantity'], json_encode($item['customizations']), $item['price']]);
}

// Clear the cart session after order submission
unset($_SESSION['cart']);

// Redirect to a confirmation page or thank you page
header('Location: thank_you.php');
exit();

// Calculate total price of cart
function calculateTotalPrice($cart) {
    $total = 0;
    foreach ($cart as $item) {
        $total += $item['price'] * $item['quantity'];
    }
    return $total;
}
?>
