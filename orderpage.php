<?php
include 'db_connection.php';

try {
    // Query to select name, description, size, and price of items
    $stmt = $conn->prepare(
        "SELECT menu_items.name, menu_items.description, item_sizes.size, item_sizes.price
         FROM menu_items
         JOIN item_sizes ON menu_items.item_id = item_sizes.item_id"
    );
    
    // Execute the query
    $stmt->execute();
    
    // Fetch results
    $items = $stmt->fetchAll();
    
} catch (PDOException $e) {
    // Handle any errors
    error_log("Connection failed: " . $e->getMessage());
    echo "Connection failed. Please try again later.";
    exit();
}

$categoryFilter = isset($_GET['category']) ? $_GET['category'] : '';
$sizeFilter = isset($_GET['size']) ? $_GET['size'] : '';

// Start building the query
$sql = "SELECT m.name, m.description, m.image, i.size, i.price
        FROM menu_items m
        INNER JOIN item_sizes i ON m.item_id = i.item_id
        WHERE 1"; // This ensures that we have a base WHERE condition

// Apply filters if any
if ($categoryFilter) {
    $sql .= " AND m.category_id = :category";
}

if ($sizeFilter) {
    $sql .= " AND i.size = :size";
}

$stmt = $conn->prepare($sql);

// Bind parameters if filters are set
if ($categoryFilter) {
    $stmt->bindParam(':category', $categoryFilter, PDO::PARAM_INT);
}

if ($sizeFilter) {
    $stmt->bindParam(':size', $sizeFilter, PDO::PARAM_STR);
}

$stmt->execute();
$items = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_order'])) {
    $item_id = $_POST['item_id'];
    $size_id = $_POST['size_id'];
    $quantity = $_POST['quantity'];

    // Get the price of the selected size
    $stmt = $conn->prepare("SELECT price FROM item_sizes WHERE size_id = :size_id AND item_id = :item_id");
    $stmt->execute(['size_id' => $size_id, 'item_id' => $item_id]);
    $size_price = $stmt->fetchColumn();

    // Calculate the total price for the order
    $total_price = $size_price * $quantity;

    // Insert the order into the orders table
    $stmt = $conn->prepare("INSERT INTO orders (item_id, size_id, quantity, total_price) VALUES (:item_id, :size_id, :quantity, :total_price)");
    $stmt->execute(['item_id' => $item_id, 'size_id' => $size_id, 'quantity' => $quantity, 'total_price' => $total_price]);

    echo "Order added successfully!";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_order'])) {
    $item_id = $_POST['item_id'];
    $size_id = $_POST['size_id'];
    $quantity = $_POST['quantity'];

    // Get the price of the selected size
    $stmt = $conn->prepare("SELECT price FROM item_sizes WHERE size_id = :size_id AND item_id = :item_id");
    $stmt->execute(['size_id' => $size_id, 'item_id' => $item_id]);
    $size_price = $stmt->fetchColumn();

    // Calculate the total price for the order
    $total_price = $size_price * $quantity;

    // Insert the order into the orders table
    $stmt = $conn->prepare("INSERT INTO orders (item_id, size_id, quantity, total_price) VALUES (:item_id, :size_id, :quantity, :total_price)");
    $stmt->execute(['item_id' => $item_id, 'size_id' => $size_id, 'quantity' => $quantity, 'total_price' => $total_price]);

    echo "Order added successfully!";
}

$stmt = $conn->query("SELECT o.order_id, i.name, s.size, o.quantity, o.total_price FROM orders o
                      JOIN menu_items i ON o.item_id = i.item_id
                      JOIN item_sizes s ON o.size_id = s.size_id");
$orders = $stmt->fetchAll();

foreach ($orders as $order) {
    echo "Item: {$order['name']} | Size: {$order['size']} | Quantity: {$order['quantity']} | Total: {$order['total_price']}<br>";
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Page</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<h1>Order Your Favorite Items</h1>

<form action="orderpage.php" method="GET">
    <label for="category">Category:</label>
    <select name="category" id="category">
        <option value="">All Categories</option>
        <!-- Loop through categories and display them -->
        <?php
        // Fetch categories from the database
        $stmt = $conn->prepare("SELECT * FROM menu_categories");
        $stmt->execute();
        $categories = $stmt->fetchAll();
        foreach ($categories as $category) {
            echo "<option value='" . $category['category_id'] . "'>" . $category['category_name'] . "</option>";
        }
        ?>
    </select>

    <label for="size">Size:</label>
    <select name="size" id="size">
        <option value="">All Sizes</option>
        <option value="Small">Small</option>
        <option value="Medium">Medium</option>
        <option value="Large">Large</option>
    </select>

    <button type="submit">Filter</button>
</form>


<?php
if ($items) {
    foreach ($items as $item) {
        echo "<div class='menu-item'>";
        echo "<h3>" . htmlspecialchars($item['name']) . "</h3>";
        echo "<p>" . htmlspecialchars($item['description']) . "</p>";
        echo "<img src='" . htmlspecialchars($item['image']) . "' alt='" . htmlspecialchars($item['name']) . "'>";
        echo "<p>Size: " . htmlspecialchars($item['size']) . " - Price: " . number_format($item['price'], 2) . "</p>";
        echo "</div>";
    }
} else {
    echo "<p>No items found matching your criteria.</p>";
}
?>

<form action="orderpage.php" method="POST">
    <label for="item">Item</label>
    <select name="item_id" required>
        <!-- Populate items dynamically here -->
    </select>

    <label for="size">Size</label>
    <select name="size_id" required>
        <!-- Populate sizes dynamically here -->
    </select>

    <label for="quantity">Quantity</label>
    <input type="number" name="quantity" min="1" value="1" required>

    <button type="submit" name="add_to_order">Add to Order</button>
</form>



</body>
</html>