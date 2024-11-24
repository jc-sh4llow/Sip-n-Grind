<?php
// process_order.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Database connection
    $host = "localhost";
    $db = "sipngrind";
    $user = "root";
    $pass = "";

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Begin transaction
        $pdo->beginTransaction();

        foreach ($_POST as $key => $value) {
            // Handle size selection (size_123)
            if (strpos($key, 'size_') === 0) {
                $itemId = str_replace('size_', '', $key); // Extract item ID
                $sizeId = (int)$value; // Selected size ID
                $quantity = $_POST["quantity_$itemId"]; // Get quantity for the item
                $price = $_POST["price_$itemId"]; // Price for the item

                // Insert order into the database
                $stmt = $pdo->prepare("INSERT INTO orders (item_id, size_id, quantity, total_price) 
                                       VALUES (?, ?, ?, ?)");
                $totalPrice = $quantity * $price;
                $stmt->execute([$itemId, $sizeId, $quantity, $totalPrice]);
            }
        }

        // Commit transaction
        $pdo->commit();
        echo json_encode(["success" => true, "message" => "Order processed successfully."]);
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }
}
?>
