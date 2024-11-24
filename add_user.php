<?php
// Include the database connection file
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Check if passwords match
    if ($password === $confirmPassword) {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare SQL query to insert the new admin
        $query = "INSERT INTO admins (username, password) VALUES (:username, :password)";
        $stmt = $conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);

        // Execute the query
        if ($stmt->execute()) {
            $message = "User added successfully!";
        } else {
            $message = "Error adding user.";
        }
    } else {
        $message = "Passwords do not match.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Admin</title>
</head>
<body>
    <h2>Add New Admin User</h2>

    <form method="POST" action="add_user.php">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>
        <br>

        <input type="submit" value="Add User">
    </form>

    <?php
    // Display message if set
    if (isset($message)) {
        echo "<p>$message</p>";
    }
    ?>
</body>
</html>
