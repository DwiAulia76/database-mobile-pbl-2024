<?php
// Mulai sesi
session_start();

// Cek apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Sederhana: cek username dan password
    if ($username === 'admin' && $password === 'password123') {
        // Login berhasil
        $_SESSION['username'] = $username;
        header('Location: dashboard.php');
        exit;
    } else {
        // Login gagal
        echo "Username atau password salah!";
    }
}
?>
