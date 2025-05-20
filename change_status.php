<?php
// Mulai sesi di awal file sebelum kirim output apapun
session_start();
include 'connection_db.php';

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error_message'] = "Anda harus login terlebih dahulu.";
    header("Location: login.php");
    exit();
}

// Periksa apakah parameter id_lowongan dan action ada
if (!isset($_GET['id_lowongan']) || !isset($_GET['action'])) {
    $_SESSION['error_message'] = "Parameter tidak lengkap.";
    header("Location: index_poster.php");
    exit();
}

$id_lowongan = $_GET['id_lowongan'];
$action = $_GET['action'];

// Validasi action yang diizinkan
$allowed_actions = ['aktif', 'tutup', 'selesai'];
if (!in_array($action, $allowed_actions)) {
    $_SESSION['error_message'] = "Action tidak valid.";
    header("Location: index_poster.php");
    exit();
}

// Verifikasi bahwa lowongan ini milik user yang sedang login
$sql_check = "SELECT * FROM lowongan WHERE id_lowongan = ? AND user_id = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("ii", $id_lowongan, $_SESSION['user_id']);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows == 0) {
    $_SESSION['error_message'] = "Anda tidak memiliki akses untuk mengubah status lowongan ini.";
    header("Location: index_poster.php");
    exit();
}

// Ubah status lowongan
$sql_update = "UPDATE lowongan SET status_lowongan = ? WHERE id_lowongan = ? AND user_id = ?";
$stmt_update = $conn->prepare($sql_update);
$stmt_update->bind_param("sii", $action, $id_lowongan, $_SESSION['user_id']);

if ($stmt_update->execute()) {
    // Persiapkan pesan sukses berdasarkan action
    $status_message = "";
    switch ($action) {
        case 'aktif':
            $status_message = "Lowongan berhasil diaktifkan kembali.";
            break;
        case 'tutup':
            $status_message = "Lowongan berhasil ditutup.";
            break;
        case 'selesai':
            $status_message = "Lowongan berhasil ditandai sebagai selesai.";
            break;
    }
    
    $_SESSION['success_message'] = $status_message;
} else {
    $_SESSION['error_message'] = "Gagal mengubah status lowongan: " . $conn->error;
}

// Redirect kembali ke halaman index_poster.php
header("Location: index_poster.php");
exit();
?>