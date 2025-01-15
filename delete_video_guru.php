<?php
header('Content-Type: application/json');

// Include file koneksi database
include('dbconnection.php');

// Cek koneksi database
$conn = dbconnection(); // Menggunakan fungsi dbconnection untuk mendapatkan koneksi

if (!$conn) {
    $response = array('status' => 'error', 'message' => 'Database connection failed: ' . mysqli_connect_error());
    echo json_encode($response);
    exit();
}

// Mengambil data input dari request body
$data = json_decode(file_get_contents("php://input"));

// Validasi input
if (isset($data->id) && is_numeric($data->id)) {
    $videoId = $data->id;

    // Menggunakan prepared statement untuk query
    $stmt = $conn->prepare("DELETE FROM video WHERE id = ?");
    
    if ($stmt === false) {
        $response = array(
            'status' => 'error',
            'message' => 'Failed to prepare the query',
            'error' => $conn->error // Menambahkan detail error jika prepared statement gagal
        );
        echo json_encode($response);
        exit();
    }

    $stmt->bind_param("i", $videoId);

    // Eksekusi query
    if ($stmt->execute()) {
        // Periksa apakah ada baris yang dihapus
        if ($stmt->affected_rows > 0) {
            $response = array('status' => 'success', 'message' => 'Video deleted successfully');
        } else {
            $response = array('status' => 'error', 'message' => 'Video ID not found');
        }
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Failed to execute query',
            'error' => $stmt->error // Menambahkan detail error untuk debugging
        );
    }

    // Menutup statement
    $stmt->close();
} else {
    $response = array('status' => 'error', 'message' => 'Invalid or missing video ID');
}

// Menutup koneksi database
$conn->close();

// Mengembalikan respon dalam format JSON
echo json_encode($response);
?>
