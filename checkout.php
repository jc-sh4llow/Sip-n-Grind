<?php
// checkout.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the raw JSON POST data
    $jsonData = file_get_contents("php://input");
    $basket = json_decode($jsonData, true); // Decode the basket data

    if (empty($basket)) {
        echo json_encode(["success" => false, "message" => "Basket is empty"]);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
</head>
<body>
    <h1>Checkout</h1>

    <form action="process_order.php" method="POST" id="checkout-form">
        <div id="basket-items">
            <?php
            foreach ($basket as $itemId => $item) {
                echo "
                <div class='checkout-item'>
                    <img src='{$item['imgSrc']}' alt='{$item['name']}'>
                    <p>{$item['name']} - ₱{$item['price']}</p>
                    <p>Quantity: {$item['quantity']}</p>

                    <!-- Size selector -->
                    <label for='size_{$itemId}'>Select Size</label>
                    <select name='size_{$itemId}' id='size_{$itemId}' required>
                        <option value='1'>Small</option>
                        <option value='2'>Medium</option>
                        <option value='3'>Large</option>
                    </select>
                </div>
                ";
            }
            ?>
        </div>

        <button type="submit">Submit Order</button>
    </form>
</body>
</html>
