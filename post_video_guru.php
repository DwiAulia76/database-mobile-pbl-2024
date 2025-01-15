<?php
header('Content-Type: application/json');
include('dbconnection.php'); // Memasukkan file koneksi

// Membaca data JSON dari request
$data = json_decode(file_get_contents('php://input'), true);

// Validasi input
if (isset($data['title'], $data['video_url'], $data['description'], $data['category'])) {
    $title = $data['title'];
    $description = $data['description'];
    $video_url = $data['video_url'];
    $category = $data['category'];

    // Mendapatkan koneksi
    $conn = dbconnection();

    // Query untuk insert data video
    $stmt = $conn->prepare("INSERT INTO video (title, description, video_url, category) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $title, $description, $video_url, $category);
    
    if ($stmt->execute()) {
        $response = array('status' => 'success', 'message' => 'Video added successfully');
    } else {
        $response = array('status' => 'error', 'message' => 'Failed to add video');
    }

    echo json_encode($response);

    // Menutup statement dan koneksi
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Invalid input'));
}
?>
