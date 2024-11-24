<?php
// Connect to your database
$conn = new mysqli('localhost', 'root', '', 'sipngrind');

try {
  $pdo = new PDO('mysql:host=localhost;dbname=sipngrind', 'root', '');
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

// Handle form submissions (AJAX-like behavior)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = isset($_POST['action']) ? $_POST['action'] : null;

    if ($action === 'set_newest') {
        $itemId = $_POST['item_id'];
        // Unset all other newest drinks
        $conn->query("UPDATE menu_items SET is_newest_drink = 0");
        // Set the current item as newest
        $conn->query("UPDATE menu_items SET is_newest_drink = 1 WHERE item_id = $itemId");
        echo "Newest drink updated successfully!";
        exit;
    } elseif ($action === 'toggle_popular') {
        $itemId = $_POST['item_id'];
        // Toggle popular status
        $conn->query("UPDATE menu_items SET is_popular = NOT is_popular WHERE item_id = $itemId");
        echo "Popular status toggled successfully!";
        exit;
    } elseif ($action === 'delete') {
        $itemId = $_POST['item_id'];

        // Step 1: Delete related row from item_sizes
        $stmtSizes = $pdo->prepare("DELETE FROM item_sizes WHERE item_id = ?");
        if ($stmtSizes->execute([$itemId])) {

            // Step 2: Delete the item from menu_items
            $stmtItem = $pdo->prepare("DELETE FROM menu_items WHERE item_id = ?");
            if ($stmtItem->execute([$itemId])) {

                // Step 3: Optionally delete related container entry
                $stmtContainer = $pdo->prepare("DELETE FROM containers WHERE item_id = ?");
                $stmtContainer->execute([$itemId]);

                echo "Item and its container deleted successfully!";
            } else {
                echo "Failed to delete item from menu_items.";
            }
        } else {
            echo "Failed to delete item from item_sizes.";
        }

        exit;
    } elseif (isset($_POST['add_new_item'])) { // Handle "Add New Item" submissions
        $name = $_POST['name'];
        $description = $_POST['description'];
        $imagePath = 'Images/' . basename($_FILES['image']['name']);
        $priceSmall = $_POST['price_small'];
        $priceMedium = $_POST['price_medium'];
        $priceLarge = $_POST['price_large'];

        // Move uploaded image to the uploads directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
            // Insert new item into `menu_items`
            $stmt = $pdo->prepare("INSERT INTO menu_items (name, description, image) VALUES (?, ?, ?)");
            $stmt->execute([$name, $description, $imagePath]);
            $itemId = $pdo->lastInsertId();

            // Add prices to `item_sizes`
            $stmt = $pdo->prepare("INSERT INTO item_sizes (item_id, size, price) VALUES 
                                   (?, 'Small', ?), (?, 'Medium', ?), (?, 'Large', ?)");
            $stmt->execute([$itemId, $priceSmall, $itemId, $priceMedium, $itemId, $priceLarge]);

            // Add a container for the new item
            $stmt = $pdo->prepare("INSERT INTO containers (item_id) VALUES (?)");
            $stmt->execute([$itemId]);

            echo "New menu item and container added successfully!";
        } else {
            echo "Failed to upload image.";
        }
        exit;
    } else {
        echo "Invalid action.";
        exit;
    }
}

// Fetch menu items
$query_items = "SELECT item_id, name, description, image, is_newest_drink, is_popular FROM menu_items";
$result_items = $conn->query($query_items);

$menuItems = $result_items && $result_items->num_rows > 0
    ? $result_items->fetch_all(MYSQLI_ASSOC)
    : [];

// Fetch about us details
$aboutQuery = "SELECT * FROM about_us WHERE id = 1";
$aboutResult = $conn->query($aboutQuery);
$aboutData = $aboutResult ? $aboutResult->fetch_assoc() : [];
$existingAboutText = $aboutData['about_text'] ?? '';
$existingImageUrl = $aboutData['image_url'] ?? '';

// Fetch team members from the database for display
$query_members = "SELECT * FROM team_members WHERE is_deleted = 0";
$result_members = $conn->query($query_members);

$teamMembers = $result_members && $result_members->num_rows > 0
    ? $result_members->fetch_all(MYSQLI_ASSOC)
    : [];

$query = "SELECT c.container_id, m.name, m.description, m.image
FROM containers c
JOIN menu_items m ON c.item_id = m.item_id
ORDER BY c.container_id";
$result = $pdo->query($query);
$containers = $result->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        button {
            padding: 5px 10px;
            cursor: pointer;
        }
        .checkbox {
            width: 20px;
            height: 20px;
        }
    </style>
    <script>
        // Modify the deleteItem function to include a page refresh after deletion
function deleteItem(itemId) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (xhr.status === 200) {
            alert(xhr.responseText + ' Press OK to refresh the page.');
            // Refresh the page after the deletion
            location.reload(); // Refresh the page after success
        } else {
            alert('Something went wrong!');
        }
    };
    xhr.send(`action=delete&item_id=${itemId}`);
}

function updateItem(action, itemId) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (xhr.status === 200) {
            alert(xhr.responseText); // Optional: Display success message
            location.reload(); // Reload the page to reflect changes
        } else {
            alert('Something went wrong!');
        }
    };
    xhr.send(`action=${action}&item_id=${itemId}`);
}

    </script>
</head>
<body>
    <?php
    session_start();
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header("Location: login.php");
        exit;
    }
    ?>
    <nav class="navbar navbar-expand-lg bg-dark fixed-top" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Welcome, <?php echo $_SESSION['username']; ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#homepage-functions">
                            Products
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about-us-functions">
                            About Us
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#team-functions">
                            Team Management
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Main Website
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="index.php">Home</a></li>
                            <li><a class="dropdown-item" href="menu.php">Menu</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="aboutus.php">About Us</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <button type="button" class="btn btn-danger">
                            <a class="nav-link" href="logout.php">
                                Logout
                            </a>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5" id="homepage-functions">
        <h1>Homepage Functions</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Newest Drink</th>
                    <th>Popular</th>
                    <th>Assigned Container</th>
                    <th>Edit Item</th>
                    <th>Delete Item</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($menuItems as $item): ?>
                    <tr>
                        <td><img src="<?php echo $item['image']; ?>" alt="" style="width: 50px; height: 50px;"></td>
                        <td><?php echo $item['name']; ?></td>
                        <td><?php echo $item['description']; ?></td>
                        <td>
                            <button 
                                class="btn btn-sm <?php echo $item['is_newest_drink'] ? 'btn-success' : 'btn-warning'; ?>"
                                onclick="updateItem('set_newest', <?php echo $item['item_id']; ?>)"
                                <?php if ($item['is_newest_drink']) echo 'disabled'; ?>>
                                <?php echo $item['is_newest_drink'] ? 'Newest Drink' : 'Set as Newest'; ?>
                            </button>
                        </td>
                        <td>
                            <input 
                                type="checkbox" 
                                class="checkbox" 
                                onclick="updateItem('toggle_popular', <?php echo $item['item_id']; ?>)"
                                <?php if ($item['is_popular']) echo 'checked'; ?>
                            >
                        </td>
                        <td></td>
                        <td>
                            <a href="edit_item.php?item_id=<?php echo $item['item_id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm" onclick="deleteItem(<?php echo $item['item_id']; ?>)">
                                Delete
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="text-center">
            <a href="add_menu_item.php" class="btn btn-success">Add New Menu Item</a>
        </div>
    </div>

    

    <div class="container mt-5" id="about-us-functions">
        <h2>About Us Section</h2>
        <form method="POST" action="update_about_us.php" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="about_text" class="form-label">About Us Text:</label>
                <textarea name="about_text" id="about_text" rows="10" class="form-control" style="width: 100%;"><?php echo htmlspecialchars($existingAboutText); ?></textarea><br>
            </div>
            <div class="mb-3">
                <label for="about_image" class="form-label">About Us Image:</label>
                <input type="file" name="about_image" id="about_image" class="form-control">
            </div>
            <div class="mb-3">
                <img src="<?php echo $existingImageUrl; ?>" alt="Current Image" style="width: 100px; height: auto;">
            </div>
            <button type="submit" class="btn btn-primary">Update About Us</button>
        </form>
    </div>

    <div class="container mt-5" id="team-functions">
        <h1>Manage Team Members</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($teamMembers as $member): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($member['name']); ?></td>
                        <td><?php echo htmlspecialchars($member['description']); ?></td>
                        <td>
                            <a href="edit_member.php?id=<?php echo $member['id']; ?>" class="btn btn-info btn-sm">Edit</a> |
                            <form method="POST" style="display:inline;" class="d-inline">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $member['id']; ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="add-new-admins mt-5 container">
        <a href="add_user.php" class="btn btn-warning">Add New Admin</a>
    </div>
</body>
</html>

