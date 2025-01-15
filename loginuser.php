<?php
include 'dbconnection.php';

// Mengatur header untuk JSON response
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil input JSON
    $inputData = json_decode(file_get_contents('php://input'), true);

    // Validasi jika data username dan password ada
    if (isset($inputData['username']) && isset($inputData['password'])) {
        $username = $inputData['username'];
        $password = $inputData['password'];

        // Koneksi ke database
        $con = dbconnection();

        // Query untuk mencari user berdasarkan username
        $query = "SELECT * FROM user WHERE username=?";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, 's', $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

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
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Access denied'
                    ]);
                } else if ($roleId == 2) {
                    // Role 2 (Guru), kirimkan NUPTK
                    echo json_encode([
                        'status' => 'success',
                        'role' => 2,
                        'message' => 'Guru homepage',
                        'name' => $user['nama'],
                        'username' => $user['username'],
                        'nuptk' => $user['nuptk'] // NUPTK untuk guru
                    ]);
                } else if ($roleId == 3) {
                    // Role 3 (Siswa), kirimkan NIS
                    echo json_encode([
                        'status' => 'success',
                        'role' => 3,
                        'message' => 'Siswa homepage',
                        'name' => $user['nama'],
                        'username' => $user['username'],
                        'nis' => $user['nis'] // NIS untuk siswa
                    ]);
                } else {
                    // Role tidak dikenal
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Invalid role'
                    ]);
                }
            } else {
                // Jika password tidak cocok
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Invalid password'
                ]);
            }
        } else {
            // Jika user tidak ditemukan
            echo json_encode([
                'status' => 'error',
                'message' => 'User not found'
            ]);
        }

        // Menutup koneksi
        mysqli_close($con);
    } else {
        // Jika username atau password tidak ada dalam request
        echo json_encode([
            'status' => 'error',
            'message' => 'Username and password are required'
        ]);
    }
}
?>
