<?php
// db_connection.php

$host = 'localhost'; // or the address of your database server
$dbname = 'sipngrind';
$username = 'root'; // your MySQL username
$password = ''; // your MySQL password

// Optionally, you can use getenv() for environment variables if you prefer
// $password = getenv('DB_PASSWORD');

try {
    // Create a PDO instance
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Optionally: You can set the default fetch mode for better readability
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Log the error instead of showing it directly to users (for production)
    error_log("Connection failed: " . $e->getMessage()); // logs the error in the PHP error log
    echo "Connection failed. Please try again later."; // generic message for users
    exit();
}
?>
