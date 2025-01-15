<?php
// Memulai sesi PHP
session_start();

// Include konfigurasi database
include 'dbconnection.php';

try {
    // Membuat koneksi menggunakan fungsi dbconnection
    $con = dbconnection();

    // Periksa koneksi
    if (mysqli_connect_errno()) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Gagal terhubung ke database: ' . mysqli_connect_error(),
        ]);
        exit;
    }

    // Periksa apakah pengguna sudah login
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['role_id'])) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Anda belum login.',
        ]);
        exit;
    }

    // Ambil role_id dari sesi
    $role_id = $_SESSION['role_id'];

    // Query berdasarkan role_id
    if ($role_id === 2) {
        // Role 2: Tampilkan data dengan NUPTK
        $query = "SELECT id, username, nama, nuptk, email, jenis_kelamin, role_id FROM user WHERE role_id = ?";
    } elseif ($role_id === 3) {
        // Role 3: Tampilkan data dengan NIS
        $query = "SELECT id, username, nama, nis, email, jenis_kelamin, kelas, role_id FROM user WHERE role_id = ?";
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Role tidak dikenali.',
        ]);
        exit;
    }

    // Menyiapkan dan menjalankan statement
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, 'i', $role_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Periksa hasil query
    if (!$result) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Query gagal dijalankan: ' . mysqli_error($con),
        ]);
        exit;
    }

    // Mengambil data hasil query
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    // Mengembalikan hasil dalam format JSON
    echo json_encode([
        'status' => 'success',
        'data' => $data,
    ]);

    // Menutup koneksi
    mysqli_close($con);
} catch (Exception $e) {
    // Menangani error lainnya
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage(),
    ]);
}
