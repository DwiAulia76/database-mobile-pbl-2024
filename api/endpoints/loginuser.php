<?php
include '../dbconnection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Koneksi ke database
    $con = dbconnection();

    // Query untuk mencari user berdasarkan username
    $query = "SELECT * FROM user WHERE username='$username'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        // Ambil data pengguna
        $user = mysqli_fetch_assoc($result);
        $storedPassword = $user['password']; // Password yang disimpan di database
        $roleId = $user['role_id']; // Role ID pengguna

        // Verifikasi password
        if ($password == $storedPassword) {
            // Password cocok, kirim respons berdasarkan role pengguna
            if ($roleId == 1) {
                // Role 1 (Admin), akses ditolak
                echo json_encode(['status' => 'error', 'message' => 'Access denied']);
            } else if ($roleId == 2) {
                // Role 2 (Guru), redirect ke halaman guru
                echo json_encode(['status' => 'success', 'role' => 2, 'message' => 'Guru homepage']);
            } else if ($roleId == 3) {
                // Role 3 (Siswa), redirect ke halaman siswa
                echo json_encode(['status' => 'success', 'role' => 3, 'message' => 'Siswa homepage']);
            } else {
                // Role tidak dikenal
                echo json_encode(['status' => 'error', 'message' => 'Invalid role']);
            }
        } else {
            // Jika password tidak cocok
            echo json_encode(['status' => 'error', 'message' => 'Invalid password']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'User not found']);
    }

    mysqli_close($con);
}
?>
