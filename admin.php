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
    $action = $_POST['action'];

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
        $memberId = $_POST['id'];
        // Soft delete the team member
        $conn->query("UPDATE team_members SET is_deleted = 1 WHERE id = $memberId");
        echo "Team member deleted successfully!";
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
        // AJAX function to handle updates
        function updateItem(action, itemId) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status === 200) {
                    alert(xhr.responseText);
                    location.reload();
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
                            Homepage
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
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Newest Drink</th>
                    <th>Popular</th>
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
                                onclick="updateItem('set_newest', <?php echo $item['item_id']; ?>)"
                                <?php if ($item['is_newest_drink']) echo 'disabled'; ?>
                            >
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
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="container mt-5" id="about-us-functions">
        <h2>About Us Section</h2>
        <form method="POST" action="update_about_us.php" enctype="multipart/form-data">
            <label for="about_text">About Us Text:</label>
            <textarea name="about_text" id="about_text" rows="10" style="width: 100%;"><?php echo htmlspecialchars($existingAboutText); ?></textarea><br>
            <label for="about_image">About Us Image:</label>
            <input type="file" name="about_image" id="about_image">
            <br>
            <img src="<?php echo $existingImageUrl; ?>" alt="Current Image" style="width: 100px; height: auto;">
            <br>
            <button type="submit">Update About Us</button>
        </form>
    </div>

    <div class="container mt-5" id="team-functions">
        <h1>Manage Team Members</h1>
        <table>
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
                            <a href="edit_member.php?id=<?php echo $member['id']; ?>">Edit</a> |
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $member['id']; ?>">
                                <button type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="add-new-admins mt-5 container">
        <button>
            <a href="add_user.php">Add New Admin</a>
        </button>
    </div>
</body>
</html>
