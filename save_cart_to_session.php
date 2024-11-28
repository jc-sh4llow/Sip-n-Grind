<?php
session_start();

// Get the cart data from the POST request
$cartData = json_decode(file_get_contents('php://input'), true);

// Store the cart data in the session
if (!empty($cartData)) {
    $_SESSION['cart'] = $cartData;
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>
