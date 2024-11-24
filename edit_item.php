<?php
// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'sipngrind');

if (isset($_GET['item_id'])) {
    $itemId = $_GET['item_id'];

    // Fetch item details based on the item_id
    $query = "SELECT * FROM menu_items WHERE item_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $itemId);
    $stmt->execute();
    $result = $stmt->get_result();
    $item = $result->fetch_assoc();

    if (!$item) {
        echo "Item not found!";
        exit;
    }

    // Fetch size details (prices) for the item
    $querySizes = "SELECT * FROM item_sizes WHERE item_id = ?";
    $stmtSizes = $conn->prepare($querySizes);
    $stmtSizes->bind_param("i", $itemId);
    $stmtSizes->execute();
    $sizesResult = $stmtSizes->get_result();
    $sizes = [];
    while ($row = $sizesResult->fetch_assoc()) {
        $sizes[$row['size']] = $row['price'];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form values
    $name = $_POST['name'];
    $description = $_POST['description'];
    $priceSmall = $_POST['price_small'];
    $priceMedium = $_POST['price_medium'];
    $priceLarge = $_POST['price_large'];
    $isPopular = isset($_POST['is_popular']) ? 1 : 0;
    $isNewestDrink = isset($_POST['is_newest_drink']) ? 1 : 0;

    // Handle image upload
    if ($_FILES['image']['name']) {
        $imagePath = 'Images/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
    } else {
        // If no new image is uploaded, keep the old image
        $imagePath = $item['image'];
    }

    // Update the menu item in the menu_items table
    $updateItemQuery = "UPDATE menu_items SET name = ?, description = ?, image = ?, is_popular = ?, is_newest_drink = ? WHERE item_id = ?";
    $stmtUpdateItem = $conn->prepare($updateItemQuery);
    $stmtUpdateItem->bind_param("sssiis", $name, $description, $imagePath, $isPopular, $isNewestDrink, $itemId);
    $stmtUpdateItem->execute();

    // Update the prices in the item_sizes table
    $updatePricesQuery = "UPDATE item_sizes SET price = ? WHERE item_id = ? AND size = ?";
    
    $size = 'Small';  
    $stmtUpdateSmall = $conn->prepare($updatePricesQuery); 
    $stmtUpdateSmall->bind_param("iis", $priceSmall, $itemId, $size);
    $stmtUpdateSmall->execute();
    
    $size = 'Medium';
    $stmtUpdateMedium = $conn->prepare($updatePricesQuery);
    $stmtUpdateMedium->bind_param("iis", $priceMedium, $itemId, $size);
    $stmtUpdateMedium->execute();

    $size = 'Large'; 
    $stmtUpdateLarge = $conn->prepare($updatePricesQuery);
    $stmtUpdateLarge->bind_param("iis", $priceLarge, $itemId, $size);
    $stmtUpdateLarge->execute();

    // Success message and redirect to admin.php
    echo "<script>
            alert('Item updated successfully!');
            window.location.href = 'admin.php'; // Redirect to admin.php after successful update
          </script>";
    exit; // Stop further script execution
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Item</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Menu Item</h2>

        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="item_id" value="<?php echo $item['item_id']; ?>">

            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($item['name']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description:</label>
                <textarea id="description" name="description" class="form-control" rows="3" required><?php echo htmlspecialchars($item['description']); ?></textarea>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Image:</label>
                <input type="file" name="image" class="form-control" accept="image/*">
                <small>Current Image: <?php echo htmlspecialchars($item['image']); ?></small>
            </div>

            <div class="mb-3">
                <label for="price_small" class="form-label">Small Price:</label>
                <input type="number" name="price_small" class="form-control" value="<?php echo htmlspecialchars($sizes['Small']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="price_medium" class="form-label">Medium Price:</label>
                <input type="number" name="price_medium" class="form-control" value="<?php echo htmlspecialchars($sizes['Medium']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="price_large" class="form-label">Large Price:</label>
                <input type="number" name="price_large" class="form-control" value="<?php echo htmlspecialchars($sizes['Large']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="is_newest_drink" class="form-label">Newest Drink</label>
                <button type="button" class="btn btn-info" 
                        onclick="toggleNewestDrink(<?php echo $item['item_id']; ?>)">
                    <?php echo $item['is_newest_drink'] ? 'Newest Drink' : 'Set as Newest'; ?>
                </button>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="is_popular" class="form-check-input" id="is_popular" <?php echo $item['is_popular'] ? 'checked' : ''; ?>>
                <label for="is_popular" class="form-check-label">Mark as Popular</label>
            </div>

            <button type="submit" class="btn btn-success">Update Item</button>
        </form>

        <!-- Cancel Button -->
        <a href="admin.php" class="btn btn-danger mt-3">Cancel</a>
    </div>

    <script>
        // Toggle the 'is_newest_drink' status
        function toggleNewestDrink(itemId) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'edit_item.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status === 200) {
                    alert(xhr.responseText);
                    location.reload(); // Reload to reflect changes
                }
            };
            xhr.send(`item_id=${itemId}&action=toggle_newest`);
        }
    </script>
</body>
</html>

