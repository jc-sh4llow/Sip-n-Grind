<?php
// Connect to the database
$pdo = new PDO('mysql:host=localhost;dbname=sipngrind', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Fetch categories from the database
$stmt = $pdo->prepare("SELECT * FROM menu_categories");
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle form submissions for adding new menu item
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_new_item'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $category = $_POST['category']; // Fetch the selected category ID
    $imagePath = 'Images/' . basename($_FILES['image']['name']);
    $priceSmall = $_POST['price_small'];
    $priceMedium = $_POST['price_medium'];
    $priceLarge = $_POST['price_large'];
    $isNewestDrink = isset($_POST['is_newest_drink']) ? 1 : 0; // Check if checkbox is selected

    // If the user marked this item as the newest drink, unset the previous one
    if ($isNewestDrink) {
        // Unset the previous newest drink
        $stmt = $pdo->prepare("UPDATE menu_items SET is_newest_drink = 0 WHERE is_newest_drink = 1");
        $stmt->execute();
    }

    // Move uploaded image to the uploads directory
    if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
        // Insert new item into `menu_items`
        $stmt = $pdo->prepare("INSERT INTO menu_items (name, description, category_id, image, is_newest_drink) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $description, $category, $imagePath, $isNewestDrink]);
        $itemId = $pdo->lastInsertId();

        // Insert prices into `item_sizes`
        if ($isOneSizeOnly) {
            // Only Small price
            $stmt = $pdo->prepare("INSERT INTO item_sizes (item_id, size, price) VALUES (?, 'Small', ?)");
            $stmt->execute([$itemId, $priceSmall]);
        } else {
            // Add prices for Small, Medium, Large
            $stmt = $pdo->prepare("INSERT INTO item_sizes (item_id, size, price) VALUES 
                                   (?, 'Small', ?), (?, 'Medium', ?), (?, 'Large', ?)");
            $stmt->execute([$itemId, $priceSmall, $itemId, $priceMedium, $itemId, $priceLarge]);
        }

        // Add a container for the new item
        $stmt = $pdo->prepare("INSERT INTO containers (item_id) VALUES (?)");
        $stmt->execute([$itemId]);

        // Display JavaScript alert on success
        echo "<script>
                alert('New menu item and container added successfully! Press OK to return to the admin page.');
                window.location.href = 'admin.php';
              </script>";
    } else {
        echo "Failed to upload image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Menu Item</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function togglePriceFields() {
            const isOneSize = document.getElementById('is_one_size_only').checked;
            document.getElementById('price_medium').disabled = isOneSize;
            document.getElementById('price_large').disabled = isOneSize;
            document.getElementById('price_medium').required = !isOneSize;
            document.getElementById('price_large').required = !isOneSize;
        }
    </script>
</head>
<body>
    <div class="container mt-5">
        <h2>Add New Menu Item</h2>
        <form method="POST" action="add_menu_item.php" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" id="name" name="name" class="form-control" required><br>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description:</label>
                <textarea id="description" name="description" rows="3" class="form-control" required></textarea><br>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image:</label>
                <input type="file" id="image" name="image" accept="image/*" class="form-control" required><br>
            </div>
            
            <!-- Category Dropdown -->
            <div class="mb-3">
                <label for="category" class="form-label">Category:</label>
                <select id="category" name="category" class="form-control" required>
                    <option value="" disabled selected>Select Category</option>
                    <?php
                    // Loop through categories to display them in the dropdown
                    foreach ($categories as $category) {
                        echo "<option value='" . $category['category_id'] . "'>" . htmlspecialchars($category['category_name']) . "</option>";
                    }
                    ?>
                </select><br>
            </div>
            
            <!-- Price section for item sizes -->
            <div class="mb-3">
                <label for="size_price" class="form-label">Prices (Small, Medium, Large):</label><br>
                <input type="number" name="price_small" placeholder="Small Price" class="form-control mb-2" required>
                <input type="number" id="price_medium" name="price_medium" placeholder="Medium Price" class="form-control mb-2" required>
                <input type="number" id="price_large" name="price_large" placeholder="Large Price" class="form-control mb-2" required><br>
            </div>

            <!-- "One Size Only" Checkbox -->
            <div class="mb-3">
                <label for="is_one_size_only" class="form-label">One Size Only</label>
                <input type="checkbox" id="is_one_size_only" name="is_one_size_only" class="form-check-input" onclick="togglePriceFields()">
            </div>

            <!-- Newest Drink Checkbox -->
            <div class="mb-3">
                <label for="is_newest_drink" class="form-label">Set as Newest Drink?</label>
                <input type="checkbox" id="is_newest_drink" name="is_newest_drink" value="1" class="form-check-input">
            </div>

            <button type="submit" name="add_new_item" class="btn btn-success">Add New Item</button>
            <a href="admin.php" class="btn btn-danger ms-2">Cancel</a>
        </form>
    </div>
</body>
</html>
