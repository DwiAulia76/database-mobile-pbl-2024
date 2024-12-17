<?php
include 'dbconnection.php';

$conn = dbconnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil input JSON mentah
    $rawInput = file_get_contents('php://input');
    error_log("Raw Input: " . $rawInput); // Log raw input untuk debug

    // Decode JSON
    $input = json_decode($rawInput, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log("JSON Decode Error: " . json_last_error_msg());
        echo json_encode(['status' => 'error', 'message' => 'Invalid JSON']);
        exit;
    }

    // Ambil nilai dari JSON
    $current_user_id = $input['user_id'] ?? null;
    $materi_id = $input['materi_id'] ?? null;
    $progres = (int)($input['progres'] ?? 0); // Pastikan progres adalah integer
    $last_read = $input['last_read'] ?? date('Y-m-d H:i:s'); // Gunakan format timestamp
    $is_favorite = (int)($input['is_favorite'] ?? 0); // Pastikan is_favorite adalah integer (0 atau 1)

    // Debug data yang diterima
    error_log("Received Data: " . print_r($input, true));

    if ($current_user_id && $materi_id) {
        // Cek apakah progres sudah ada
        $query = "SELECT * FROM materi_progress WHERE user_id = ? AND materi_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ii', $current_user_id, $materi_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Update progres
            $updateQuery = "UPDATE materi_progress SET progres = ?, last_read = ?, is_favorite = ? WHERE user_id = ? AND materi_id = ?";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param('dsiii', $progres, $last_read, $is_favorite, $current_user_id, $materi_id);
            $updateStmt->execute();
            echo json_encode(['status' => 'success', 'message' => 'Progress updated successfully']);
        } else {
            // Insert progres baru
            $insertQuery = "INSERT INTO materi_progress (user_id, materi_id, progres, last_read, is_favorite) VALUES (?, ?, ?, ?, ?)";
            $insertStmt = $conn->prepare($insertQuery);
            $insertStmt->bind_param('iiisi', $current_user_id, $materi_id, $progres, $last_read, $is_favorite);
            $insertStmt->execute();
            echo json_encode(['status' => 'success', 'message' => 'Progress created successfully']);
        }
    } else {
        error_log("Missing Data: user_id or materi_id is null");
        echo json_encode(['status' => 'error', 'message' => 'Missing data']);
    }
}

$conn->close();
