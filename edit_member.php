<?php
// Include database connection
include 'db_connection.php'; // Adjust this based on your actual file structure

// Check if ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid team member ID.");
}

// Fetch the team member's details
$id = intval($_GET['id']);
$query = "SELECT * FROM team_members WHERE id = :id AND is_deleted = 0";
$stmt = $conn->prepare($query);
$stmt->execute(['id' => $id]);

$member = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$member) {
    die("Team member not found.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input
    $name = htmlspecialchars($_POST['name']);
    $description = htmlspecialchars($_POST['description']);
    $image_url = htmlspecialchars($_POST['image_url']);
    $twitter_link = htmlspecialchars($_POST['twitter_link']);
    $facebook_link = htmlspecialchars($_POST['facebook_link']);
    $instagram_link = htmlspecialchars($_POST['instagram_link']);
    $email_link = htmlspecialchars($_POST['email_link']);

    // Prepare the update query with placeholders
    $update_query = "
        UPDATE team_members 
        SET 
            name = :name, 
            description = :description, 
            image_url = :image_url, 
            twitter_link = :twitter_link, 
            facebook_link = :facebook_link, 
            instagram_link = :instagram_link, 
            email_link = :email_link
        WHERE id = :id";

    $stmt = $conn->prepare($update_query);
    $stmt->execute([
        ':name' => $name,
        ':description' => $description,
        ':image_url' => $image_url,
        ':twitter_link' => $twitter_link,
        ':facebook_link' => $facebook_link,
        ':instagram_link' => $instagram_link,
        ':email_link' => $email_link,
        ':id' => $id
    ]);

    // Check if update was successful
    if ($stmt->rowCount() > 0) {
        header("Location: admin.php?message=Team member updated successfully");
        exit;
    } else {
        $error = "Failed to update team member.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Team Member</title>
</head>
<body>
    <h1>Edit Team Member</h1>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form action="edit_member.php?id=<?php echo $id; ?>" method="post">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($member['name']); ?>" required><br>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required><?php echo htmlspecialchars($member['description']); ?></textarea><br>

        <label for="image_url">Image URL:</label>
        <input type="text" id="image_url" name="image_url" value="<?php echo htmlspecialchars($member['image_url']); ?>"><br>

        <label for="twitter_link">Twitter Link:</label>
        <input type="url" id="twitter_link" name="twitter_link" value="<?php echo htmlspecialchars($member['twitter_link']); ?>"><br>

        <label for="facebook_link">Facebook Link:</label>
        <input type="url" id="facebook_link" name="facebook_link" value="<?php echo htmlspecialchars($member['facebook_link']); ?>"><br>

        <label for="instagram_link">Instagram Link:</label>
        <input type="url" id="instagram_link" name="instagram_link" value="<?php echo htmlspecialchars($member['instagram_link']); ?>"><br>

        <label for="email_link">Email:</label>
        <input type="email" id="email_link" name="email_link" value="<?php echo htmlspecialchars($member['email_link']); ?>"><br>

        <button type="submit">Update Team Member</button>
        <a href="admin.php">Cancel</a>
    </form>
</body>
</html>
