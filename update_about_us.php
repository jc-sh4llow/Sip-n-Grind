<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'sipngrind');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission for updating About Us section
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the new About Us text
    $newAboutText = $_POST['about_text'];

    // Handle image upload (if a new image is uploaded)
    if (isset($_FILES['about_image']) && $_FILES['about_image']['error'] === UPLOAD_ERR_OK) {
        $imageDir = './images/';  // Make sure this directory is writeable
        $imageName = $_FILES['about_image']['name'];
        $imagePath = $imageDir . basename($imageName);
        
        // Move uploaded image to the appropriate directory
        move_uploaded_file($_FILES['about_image']['tmp_name'], $imagePath);
    } else {
        // Use the existing image if no new one is uploaded
        $imagePath = $existingImageUrl;  // Keep the previous image if no new upload
    }

    // Update the database with the new text and image
    $updateQuery = "UPDATE about_us SET about_text = ?, image_url = ? WHERE id = 1";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("ss", $newAboutText, $imagePath);
    $stmt->execute();

    // Redirect back to the admin page or display a success message
    header("Location: admin.php");
    exit();
}
?>
