<?php
include('connection_db.php');
session_start();

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    echo "Anda harus login terlebih dahulu.";
    exit();
}

// Ambil ID lowongan dan ID pelamar
$id_lowongan = $_GET['id_lowongan'];
$user_id = $_GET['user_id'];

// Update status lowongan menjadi "Dalam Proses" dan pilih pelamar
$sql = "UPDATE daftar_lowongan SET status = 'selected' WHERE id_lowongan = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id_lowongan, $user_id);

if ($stmt->execute()) {
    echo "Pelamar berhasil dipilih untuk menangani proyek!";
    // Redirect ke halaman memantau pelamar
    header("Location: manage_applicants.php?id_lowongan=" . $id_lowongan);
    exit();
} else {
    echo "Gagal memilih pelamar.";
}
?>
