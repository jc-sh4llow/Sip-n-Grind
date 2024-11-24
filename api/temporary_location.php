<?php
// api/temporary_location.php
include 'database.php'; // Database connection

header('Content-Type: application/json');

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);
$latitude = $data['latitude'] ?? null;
$longitude = $data['longitude'] ?? null;

if ($latitude && $longitude) {
    $stmt = $pdo->prepare("INSERT INTO temporary_locations (latitude, longitude) VALUES (:latitude, :longitude)");
    $stmt->execute(['latitude' => $latitude, 'longitude' => $longitude]);
    echo json_encode(['message' => 'Location saved temporarily.']);
} else {
    echo json_encode(['message' => 'Invalid data.']);
}
?>
