<?php
// update_video.php
header('Content-Type: application/json');
include('dbconnection.php'); // File koneksi database

$data = json_decode(file_get_contents("php://input"));

// Ambil data dari body
$video_id = $data->id;
$title = $data->title;
$description = $data->description;
$video_url = $data->video_url;
$category = $data->category;

// Query update
$query = "UPDATE video SET title='$title', description='$description', 
          video_url='$video_url', category='$category' WHERE id=$video_id";

if (mysqli_query($conn, $query)) {
    echo json_encode(["message" => "Video updated successfully"]);
} else {
    echo json_encode(["message" => "Error updating video"]);
}

mysqli_close($conn);
?>
