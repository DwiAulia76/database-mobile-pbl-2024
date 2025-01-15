<?php

// Include database connection
include 'dbconnection.php';

// Mendapatkan koneksi database dengan memanggil fungsi dbconnection
$conn = dbconnection();

// Pastikan koneksi berhasil
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query untuk mendapatkan semua video
$sql = "SELECT * FROM video";
$result = $conn->query($sql);

// Cek jika ada video yang ditemukan
if ($result->num_rows > 0) {
    // Membuat response JSON
    $response = array();
    while($row = $result->fetch_assoc()) {
        $response[] = array(
            "id" => $row["id"],
            "title" => $row["title"],
            "description" => $row["description"],
            "thumbnail" => $row["thumbnail"] ?: '', // Jika thumbnail kosong, gunakan string kosong
            "video_url" => $row["video_url"],
            "category" => $row["category"],
            "created_at" => $row["created_at"]
        );
    }
    echo json_encode($response);
} else {
    echo json_encode(array("message" => "No videos found"));
}

// Menutup koneksi
$conn->close();
?>
