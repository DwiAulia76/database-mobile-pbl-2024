<?php
header('Content-Type: application/json');
include('dbconnection.php'); // Memasukkan file koneksi

// Mendapatkan koneksi
$conn = dbconnection();

// Query untuk mengambil data video
$sql = "SELECT * FROM video";
$result = $conn->query($sql);

$videos = array();
while ($row = $result->fetch_assoc()) {
    $videos[] = $row;
}

// Menampilkan data dalam format JSON
echo json_encode($videos);

// Menutup koneksi
$conn->close();
?>
