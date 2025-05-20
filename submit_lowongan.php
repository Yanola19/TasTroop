<?php
include 'connection_db.php';
session_start();

// Cek sesi login
if (!isset($_SESSION['user_id'])) {
    die("Akses ditolak. Silakan login terlebih dahulu.");
}

// Ambil data dari form
$nama_lowongan     = $_POST['nama_lowongan'];
$jenis_lowongan    = $_POST['jenis_lowongan'];
$tanggal_tutup     = $_POST['tanggal_tutup'];
$created_at        = date("Y-m-d H:i:s");
$tanggal_unggah    = date("Y-m-d H:i:s");
$user_id           = $_SESSION['user_id'];
$deskripsi         = $_POST['deskripsi'];
$limit             = $_POST['limit_pelamar'];
$harga             = $_POST['harga_jasa'];
$status_lowongan   = 'aktif'; // Status default saat ditambahkan

// Insert ke database
$sql = "INSERT INTO lowongan 
        (user_id, jenis_lowongan, nama_lowongan, deskripsi, tanggal_tutup, status_lowongan, limit_pelamar, harga_jasa, created_at, tanggal_unggah)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param(
    "isssssiiis",
    $user_id,
    $jenis_lowongan,
    $nama_lowongan,
    $deskripsi,
    $tanggal_tutup,
    $status_lowongan, // Status default saat ditambahkan
    $limit,
    $harga,
    $created_at,
    $tanggal_unggah
);

if ($stmt->execute()) {
    // Tampilkan HTML dengan pop-up JS
    echo '
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <title>Lowongan Ditambahkan</title>
        <script>
            window.onload = function() {
                alert("✅ Lowongan berhasil ditambahkan!");
            }
        </script>
        <style>
            body {
                font-family: Arial, sans-serif;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                height: 100vh;
                background-color: #f0f0f0;
            }
            .btn {
                padding: 10px 20px;
                background-color: #28a745;
                color: white;
                border: none;
                border-radius: 5px;
                text-decoration: none;
                font-size: 16px;
                margin-top: 20px;
            }
            .btn:hover {
                background-color: #218838;
            }
        </style>
    </head>
    <body>
        <h2>Lowongan telah berhasil ditambahkan.</h2>
        <a href="index_poster.php" class="btn">Kembali ke Menu Utama</a>
    </body>
    </html>';
} else {
    echo "❌ Gagal menambahkan lowongan: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
