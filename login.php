<?php
session_start();
include 'db_connection.php'; // Include your database connection file

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: admin.php"); // Redirect to admin page if already logged in
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare SQL statement to check if the user exists
    $query = "SELECT * FROM admins WHERE username = :username";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR); // Bind username parameter

    // Execute the query
    $stmt->execute();

    // Check if user exists
    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify password
        if (password_verify($password, $row['password'])) {
            $_SESSION['loggedin'] = true; // Set session variable
            $_SESSION['username'] = $username; // Optional: store username in session
            header("Location: admin.php"); // Redirect to admin page
            exit;
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "Invalid username.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
</head>
<body>
    <h2>Admin Login</h2>
    <form method="POST" action="login.php">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <input type="submit" value="Login">
    </form>
    <?php if (isset($error)) { echo "<p>$error</p>"; } ?>
</body>
</html>
