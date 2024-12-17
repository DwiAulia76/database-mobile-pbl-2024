<?php 
// Import koneksi database
include 'dbconnection.php';

// Membuat koneksi
$conn = dbconnection();
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Query untuk mengambil data dari tabel materi_pelajaran dan nama pengunggah
$query = "
    SELECT 
        materi_pelajaran.id, 
        materi_pelajaran.judul, 
        materi_pelajaran.bab, 
        materi_pelajaran.konten, 
        materi_pelajaran.foto_konten, 
        materi_pelajaran.foto_sampul, 
        materi_pelajaran.created_at, 
        materi_pelajaran.user_id, 
        user.nama AS pengunggah_nama
    FROM materi_pelajaran
    INNER JOIN user ON materi_pelajaran.user_id = user.id
";

$result = mysqli_query($conn, $query);
if (!$result) {
    die("Query SQL gagal: " . mysqli_error($conn));
}

// Mengecek apakah data ditemukan
if (mysqli_num_rows($result) > 0) {
    $materi = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $materi[] = [
            'id' => $row['id'],
            'judul' => $row['judul'],
            'bab' => $row['bab'],
            'konten' => $row['konten'],
            'foto_konten' => !empty($row['foto_konten']) ? $row['foto_konten'] : '',
            'foto_sampul' => !empty($row['foto_sampul']) ? $row['foto_sampul'] : '',
            'created_at' => $row['created_at'],
            'user_id' => $row['user_id'],
            'pengunggah_nama' => $row['pengunggah_nama']
        ];
    }

    echo json_encode([
        'status' => 'success',
        'data' => $materi
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'No data found'
    ]);
}

// Menutup koneksi
mysqli_close($conn);
?>
